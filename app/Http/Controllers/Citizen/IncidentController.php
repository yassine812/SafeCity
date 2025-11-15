<?php

namespace App\Http\Controllers\Citizen;

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
        // Rate limiting: max 5 incidents per hour per IP
        $executed = RateLimiter::attempt(
            $this->throttleKey($request),
            $perHour = 5,
            function() {}
        );

        if (!$executed) {
            return back()->with('error', 'Too many incident reports. Please try again later.');
        }

        // Combine address fields into a single location string
        $location = trim(implode(', ', array_filter([
            $request->input('address'),
            $request->input('postal_code'),
            $request->input('city')
        ])));

        // Add the combined location to the request
        $request->merge(['location' => $location]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'category_id' => 'required|exists:categories,id',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'location' => 'required|string|max:500',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max per image
            'videos.*' => 'nullable|mimetypes:video/mp4,video/quicktime,video/x-msvideo|max:20480', // 20MB max per video
        ], [
            'images.*.max' => 'Each image must not be larger than 5MB.',
            'videos.*.max' => 'Each video must not be larger than 20MB.',
            'videos.*.mimetypes' => 'The video must be a file of type: mp4, mov, avi.',
        ]);

        $incident = Auth::user()->incidents()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'location' => $validated['location'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'status_id' => Status::where('name', 'Pending')->firstOrFail()->id,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('incidents/' . $incident->id, 'public');
                $incident->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('citizen.dashboard')
            ->with('success', 'Incident reported successfully! Our team will review it shortly.');
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
