<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Incident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a new comment
     */
    public function store(Request $request, Incident $incident)
    {
        $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        $comment = Comment::create([
            'incident_id' => $incident->id,
            'user_id' => Auth::id(),
            'content' => $request->content
        ]);

        return back()->with('success', 'Commentaire ajouté avec succès');
    }

    /**
     * Delete a comment
     */
    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            abort(403); // Forbidden
        }

        $comment->delete();

        return back()->with('success', 'Commentaire supprimé');
    }
}
