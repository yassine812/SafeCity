<?php

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\Category;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IncidentController extends Controller
{
    /**
     * List user incidents
     */
    public function index()
    {
        $incidents = Incident::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('citizen.incidents.index', compact('incidents'));
    }

    /**
     * Show creation form
     */
    public function create()
    {
        $categories = Category::all();
        return view('citizen.incidents.create', compact('categories'));
    }

    /**
     * Store a new incident
     */
    /**
     * Show the form for editing the specified incident.
     */
    public function edit(Incident $incident)
    {
        // Check if the authenticated user is the owner of the incident
        if ($incident->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        $incident->load('images'); // Load the images relationship
        
        return view('citizen.incidents.edit', compact('incident', 'categories'));
    }

    /**
     * Store a new incident
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'  => 'nullable|exists:categories,id',
            'title'        => 'required|string|max:255',
            'description'  => 'required|string|max:2000',
            'city'         => 'required|string|max:255',
            'address_line1'=> 'required|string|max:255',
            'postal_code'  => 'required|string|max:20',
            'country'      => 'required|string|max:255',
            'media.*'      => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov|max:20480'
        ]);

        // CREATE INCIDENT
        $incident = Incident::create([
            'user_id'      => Auth::id(),
            'category_id'  => $validated['category_id'] ?? null,
            'title'        => $validated['title'],
            'description'  => $validated['description'],
            'city'         => $validated['city'],
            'address_line1'=> $validated['address_line1'],
            'postal_code'  => $validated['postal_code'],
            'country'      => $validated['country'],
        ]);

        // SAVE MEDIA
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store("incidents/{$incident->id}", 'public');

                $incident->images()->create([
                    'path' => $path   // FIXED
                ]);
            }
        }

        return redirect()
            ->route('citizen.dashboard')
            ->with('success', 'Incident créé avec succès.');
    }

    /**
     * Update the specified incident in storage.
     */
    public function update(Request $request, Incident $incident)
    {
        // Check if the authenticated user is the owner of the incident
        if ($incident->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'category_id'  => 'nullable|exists:categories,id',
            'title'        => 'required|string|max:255',
            'description'  => 'required|string|max:2000',
            'city'         => 'required|string|max:255',
            'address_line1'=> 'required|string|max:255',
            'postal_code'  => 'required|string|max:20',
            'country'      => 'required|string|max:255',
            'media.*'      => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov|max:20480'
        ]);

        // UPDATE INCIDENT
        $incident->update([
            'category_id'  => $validated['category_id'] ?? null,
            'title'        => $validated['title'],
            'description'  => $validated['description'],
            'city'         => $validated['city'],
            'address_line1'=> $validated['address_line1'],
            'postal_code'  => $validated['postal_code'],
            'country'      => $validated['country'],
        ]);

        // SAVE NEW MEDIA
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store("incidents/{$incident->id}", 'public');
                $incident->images()->create([
                    'path' => $path
                ]);
            }
        }

        return redirect()
            ->route('citizen.incidents.show', $incident)
            ->with('success', 'Incident mis à jour avec succès.');
    }

    /**
     * Show incident
     */
    public function show(Incident $incident)
    {
        $this->authorize('view', $incident);

        $incident->load(['images', 'comments.user']);

        return view('citizen.incidents.show', compact('incident'));
    }

    /**
     * Delete incident
     */
    public function destroy(Incident $incident)
    {
        $this->authorize('delete', $incident);

        // Delete all images
        foreach ($incident->images as $img) {
            Storage::disk('public')->delete($img->path); // FIXED
        }

        $incident->delete();

        return back()->with('success', 'Incident supprimé.');
    }

    /**
     * Vote system
     */
    public function vote($id)
    {
        $incident = Incident::findOrFail($id);
        $user = auth()->user();

        $hasVoted = Vote::where('user_id', $user->id)
                        ->where('incident_id', $id)
                        ->exists();

        if ($hasVoted) {
            return response()->json([
                'success' => true,
                'has_voted' => false,
                'votes_count' => $incident->votes_count
            ]);
        }

        Vote::create([
            'user_id' => $user->id,
            'incident_id' => $id
        ]);

        $incident->increment('votes_count');

        return response()->json([
            'success' => true,
            'has_voted' => true,
            'votes_count' => $incident->votes_count
        ]);
    }
}
