<?php

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Incident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     */
    public function store(Request $request, Incident $incident)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = new Comment([
            'content' => $validated['content'],
            'user_id' => Auth::id(),
        ]);

        $incident->comments()->save($comment);
        
        // Load the user relationship for the response
        $comment->load('user');

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'comment' => $comment,
                'message' => 'Comment added successfully!'
            ]);
        }

        return redirect()
            ->route('citizen.incidents.show', $incident)
            ->with('success', 'Comment added successfully!');
    }
}
