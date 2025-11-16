<?php

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\IncidentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the citizen dashboard with all incidents.
     */
    public function index()
    {
        $incidents = Incident::with(['user', 'category', 'status', 'votes'])
            ->withCount('votes')
            ->latest()
            ->paginate(10);
            
        $categories = \App\Models\Category::all();
            
        return view('citizen.dashboard', compact('incidents', 'categories'));
    }
}
