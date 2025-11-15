<?php

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    /**
     * Toggle a vote on an incident.
     * 
     * @param  \App\Models\Incident  $incident
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toggle(Request $request, Incident $incident)
    {
        $user = Auth::user();
        $voteType = $request->input('type', 'up'); // 'up' or 'down'
        
        // Check if user has already voted
        $existingVote = $incident->votes()->where('user_id', $user->id)->first();
        
        if ($existingVote) {
            // If same vote type, remove the vote
            if ($existingVote->type === $voteType) {
                $existingVote->delete();
                $message = 'Vote removed successfully';
            } else {
                // If different vote type, update the vote
                $existingVote->update(['type' => $voteType]);
                $message = 'Vote updated successfully';
            }
        } else {
            // Create new vote
            $incident->votes()->create([
                'user_id' => $user->id,
                'type' => $voteType,
            ]);
            $message = 'Vote added successfully';
        }
        
        // Refresh the incident to get updated vote counts
        $incident->refresh();
        
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'votes' => [
                    'up' => $incident->upVotes()->count(),
                    'down' => $incident->downVotes()->count(),
                    'user_vote' => $incident->votes()->where('user_id', $user->id)->first()?->type
                ]
            ]);
        }
        
        return back()->with('success', $message);
    }
}
