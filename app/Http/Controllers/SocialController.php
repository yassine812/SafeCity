<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        // Allowed providers
        if (!in_array($provider, ['google', 'github', 'facebook'])) {
            abort(404);
        }

        try {
            return Socialite::driver($provider)->redirect();
        } catch (\Exception $e) {
            Log::error("Social login redirect failed: " . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'Unable to connect with ' . ucfirst($provider));
        }
    }

    public function callback($provider)
    {
        if (!in_array($provider, ['google', 'github', 'facebook'])) {
            abort(404);
        }

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            Log::error("Social login callback failed: " . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'Failed to authenticate with ' . ucfirst($provider));
        }

        // Find user by provider id or by email
        $user = User::where('provider_name', $provider)
                    ->where('provider_id', $socialUser->getId())
                    ->first();

        if (!$user && $socialUser->getEmail()) {
            $user = User::where('email', $socialUser->getEmail())->first();
        }

        if (!$user) {
            // Create a new user
            try {
                $user = User::create([
                    'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? 'User',
                    'email' => $socialUser->getEmail(),
                    'password' => bcrypt(Str::random(24)),
                    'provider_name' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'email_verified_at' => now(),
                ]);
            } catch (\Exception $e) {
                Log::error("User creation failed: " . $e->getMessage());
                return redirect()->route('login')
                    ->with('error', 'Failed to create user account.');
            }
        } else {
            // Update provider fields if missing
            $user->update([
                'provider_name' => $provider,
                'provider_id' => $socialUser->getId(),
            ]);
        }

        // Log the user in
        Auth::login($user, true);

        return redirect()->intended(route('dashboard'));
    }
}
