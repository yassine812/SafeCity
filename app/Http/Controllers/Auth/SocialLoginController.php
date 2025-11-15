<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

class SocialLoginController extends Controller
{
    /**
     * Redirect the user to the provider authentication page.
     *
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToProvider($provider)
    {
        try {
            return Socialite::driver($provider)->redirect();
        } catch (\Exception $e) {
            Log::error("Social login redirect failed: " . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'Unable to connect with ' . ucfirst($provider));
        }
    }

    /**
     * Obtain the user information from the provider.
     *
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            Log::error("Social login callback failed: " . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'Failed to authenticate with ' . ucfirst($provider));
        }

        // Check if user already exists
        $user = User::where('email', $socialUser->getEmail())->first();

        if (!$user) {
            try {
                $user = User::create([
                    'name' => $socialUser->getName() ?: $socialUser->getNickname(),
                    'email' => $socialUser->getEmail(),
                    'password' => bcrypt(Str::random(16)),
                    'email_verified_at' => now(),
                ]);
            } catch (\Exception $e) {
                Log::error("User creation failed: " . $e->getMessage());
                return redirect()->route('login')
                    ->with('error', 'Failed to create user account.');
            }
        }

        // Log the user in
        Auth::login($user, true);

        return redirect()->intended(route('dashboard'));
    }
}
