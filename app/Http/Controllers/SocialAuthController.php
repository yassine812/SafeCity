<?php

namespace App\Http\Controllers;

use Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $social = Socialite::driver($provider)->stateless()->user();
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            // Gestion des erreurs de session invalide
            return redirect('/login')->withErrors('La session a expiré. Veuillez réessayer.');
        } catch (\Exception $e) {
            // Gestion des autres erreurs
            return redirect('/login')->withErrors('Une erreur est survenue lors de la connexion avec ' . ucfirst($provider) . '. Veuillez réessayer.');
        }

        // Vérifier si l'utilisateur existe déjà avec cet email
        $user = User::where('email', $social->getEmail())->first();

        if ($user) {
            // Si l'utilisateur existe mais n'a pas de fournisseur, on le met à jour
            if (empty($user->provider)) {
                $user->update([
                    'provider' => $provider,
                    'provider_id' => $social->getId(),
                ]);
            }
        } else {
            // Créer un nouvel utilisateur
            $user = User::create([
                'name' => $social->getName() ?? $social->getNickname() ?? 'Utilisateur',
                'email' => $social->getEmail(),
                'password' => bcrypt(Str::random(20)),
                'provider' => $provider,
                'provider_id' => $social->getId(),
                'email_verified_at' => now(),
            ]);
        }

        // Connecter l'utilisateur
        Auth::login($user, true);

        // Rediriger vers la page précédente ou le tableau de bord
        return redirect()->intended(route('citizen.dashboard'));
    }
}
