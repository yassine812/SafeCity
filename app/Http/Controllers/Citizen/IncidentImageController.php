<?php

namespace App\Http\Controllers;

use App\Models\IncidentImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class IncidentImageController extends Controller
{
    public function destroy(IncidentImage $image)
    {
        // Check ownership
        if ($image->incident->user_id !== auth()->id()) {
            abort(403);
        }

        // Delete physical file
        Storage::disk('public')->delete($image->path);

        // Delete record
        $image->delete();

        return back()->with('success', 'Image supprimée.');
    }
}
