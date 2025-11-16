<?php

use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Redirect old dashboard to new citizen dashboard
Route::get('/dashboard', function () {
    return redirect()->route('citizen.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.main');
    })->name('login');

    Route::get('/register', function () {
        return view('auth.main');
    })->name('register');
});

// Routes protégées par authentification
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Citizen dashboard
    Route::get('/citizen/dashboard', [\App\Http\Controllers\Citizen\DashboardController::class, 'index'])
        ->name('citizen.dashboard');
        
    // Citizen incidents
    Route::resource('citizen/incidents', \App\Http\Controllers\Citizen\IncidentController::class)
        ->names('citizen.incidents')
        ->except(['show']);
        
    // Show incident with comments
    Route::get('citizen/incidents/{incident}', [\App\Http\Controllers\Citizen\IncidentController::class, 'show'])
        ->name('citizen.incidents.show');
        
    // Vote on incident
    Route::post('citizen/incidents/{incident}/vote', [\App\Http\Controllers\Citizen\VoteController::class, 'toggle'])
        ->name('citizen.incidents.vote');
        
    // Comments on incident
    // Comments
Route::post('/incidents/{incident}/comments', [CommentController::class, 'store'])
    ->name('comments.store')
    ->middleware('auth');

Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
    ->name('comments.destroy')
    ->middleware('auth');

    // Incidents
    Route::resource('incidents', \App\Http\Controllers\IncidentController::class)
        ->middleware('auth');

    // Incident Images
    Route::delete('/incident-images/{image}', 
        [\App\Http\Controllers\Citizen\IncidentImageController::class, 'destroy'])
        ->name('incident-images.destroy')
        ->middleware('auth');

    // Vote on incident (new route)
    Route::post('/incidents/{incident}/vote', 
        [\App\Http\Controllers\Citizen\IncidentController::class, 'vote'])
        ->name('incidents.vote')
        ->middleware('auth');
});

require __DIR__.'/auth.php';

// Social Authentication Routes (simple version)
Route::get('auth/{provider}', [SocialAuthController::class, 'redirect']);
Route::get('auth/{provider}/callback', [SocialAuthController::class, 'callback']);
