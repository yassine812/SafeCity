<?php

namespace App\Http\Controllers\Citizen;

use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\Category;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incidents = Auth::user()->incidents()
            ->latest()
            ->paginate(10);

        // Debug: Log the incidents to check what's being returned
        \Log::info('Incidents loaded:', ['count' => $incidents->count(), 'data' => $incidents->toArray()]);

        return view('citizen.incidents.index', compact('incidents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('citizen.incidents.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Get the rate limiting throttle key for the request.
     */
    protected function throttleKey(Request $request)
    {
        return 'incident:create:' . $request->ip();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        \Log::info('Incident creation request:', $request->except(['_token']));

        // Rate limiting: max 5 incidents per hour per IP
        if (!RateLimiter::attempt($this->throttleKey($request), 5, function() {})) {
            return back()->with('error', 'Trop de signalements. Veuillez réessayer plus tard.');
        }

        try {
            $validated = $request->validate([
                'title'         => 'required|string|max:255',
                'description'   => 'required|string|max:2000',
                'category_id'   => 'required|exists:categories,id',
                'address'       => 'required|string|max:255',
                'city'          => 'required|string|max:255',
                'postal_code'   => 'required|string|max:20',
                'latitude'      => 'required|numeric',
                'longitude'     => 'required|numeric',
                'location'      => 'nullable|string|max:500',
                'media'         => 'nullable|array|max:10',
                'media.*'       => 'file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:20480',
            ]);

            $location = $validated['location'] ?? trim(implode(', ', [$validated['address'], $validated['city'], $validated['postal_code']]), ', ');

            // Create incident
            $incident = Auth::user()->incidents()->create([
                'title'       => $validated['title'],
                'description' => $validated['description'],
                'category_id' => $validated['category_id'],
                'location'    => $location,
                'latitude'    => $validated['latitude'],
                'longitude'   => $validated['longitude'],
                'status_id'   => 1, // Nouveau
            ]);

            // Save media files
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $file) {
                    $path = $file->store("incidents/{$incident->id}", 'public');
                    $incident->images()->create(['path' => $path]);
                }
            }

            return redirect()->route('citizen.dashboard')
                ->with('success', 'Signalement créé avec succès !');
                
        } catch (ValidationException $e) {
            \Log::error('Validation error during incident creation: ' . $e->getMessage(), [
                'errors' => $e->errors(),
            ]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Error creating incident: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Une erreur est survenue lors de la création du signalement. Veuillez réessayer.')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Incident $incident)
    {
        $this->authorize('view', $incident);
        
        $incident->load(['category', 'status', 'user', 'comments.user', 'images']);
        return view('citizen.incidents.show', compact('incident'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Incident $incident)
    {
        $this->authorize('update', $incident);
        
        $categories = Category::all();
        return view('citizen.incidents.edit', compact('incident', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Incident $incident)
    {
        $this->authorize('update', $incident);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:20|max:2000',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string|max:500',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'videos.*' => 'nullable|mimetypes:video/mp4,video/quicktime,video/x-msvideo|max:20480',
            'deleted_images' => 'nullable|array',
            'deleted_images.*' => 'exists:images,id',
        ]);

        $incident->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'location' => $validated['location'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]);

        // Handle image deletions
        if (!empty($validated['deleted_images'])) {
            $imagesToDelete = $incident->images()->whereIn('id', $validated['deleted_images'])->get();
            foreach ($imagesToDelete as $image) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            }
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('incidents/' . $incident->id, 'public');
                $incident->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('citizen.incidents.show', $incident)
            ->with('success', 'Incident updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Incident $incident)
    {
        $this->authorize('delete', $incident);
        
        // Delete associated images from storage
        foreach ($incident->images as $image) {
            Storage::disk('public')->delete($image->path);
        }
        
        $incident->delete();
        
        return redirect()->route('citizen.dashboard')
            ->with('success', 'Incident deleted successfully!');
    }

    /**
     * Handle user vote on an incident
     */
    public function vote(Incident $incident)
    {
        $user = Auth::user();
        
        // Check if user already voted
        if ($incident->votes()->where('user_id', $user->id)->exists()) {
            // Remove vote if already voted
            $incident->votes()->detach($user->id);
            $message = 'Vote retiré avec succès';
        } else {
            // Add vote
            $incident->votes()->attach($user->id);
            $message = 'Merci pour votre vote !';
        }
        
        // Get updated votes count
        $votesCount = $incident->votes()->count();
        
        return response()->json([
            'success' => true,
            'message' => $message,
            'votes_count' => $votesCount,
            'has_voted' => !$incident->votes()->where('user_id', $user->id)->exists()
        ]);
    }
}
