<?php

namespace App\Policies;

use App\Models\Incident;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class IncidentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Users can view their own incidents via the controller
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Incident $incident): bool
    {
        return $user->id === $incident->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Any authenticated user can create incidents
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Incident $incident): bool
    {
        return $user->id === $incident->user_id && $incident->status !== 'resolved';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Incident $incident): bool
    {
        return $user->id === $incident->user_id && $incident->status !== 'resolved';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Incident $incident): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Incident $incident): bool
    {
        return false;
    }
}
