<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CustomLoginController extends Controller
{
    /**
     * Afficher le formulaire de connexion.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Gérer une tentative d'authentification.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        // Vérifier si l'utilisateur existe et s'il s'est inscrit via un fournisseur
        if ($user && $user->provider) {
            return back()
                ->withInput()
                ->withErrors([
                    'email' => "Ce compte a été créé avec " . ucfirst($user->provider) . ". Veuillez vous connecter avec " . ucfirst($user->provider) . ".",
                ]);
        }

        // Tenter de connecter l'utilisateur
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('citizen.dashboard'));
        }

        // Si l'authentification échoue
        return back()
            ->withInput()
            ->withErrors([
                'email' => 'Les informations d\'identification fournies ne correspondent pas à nos enregistrements.',
            ]);
    }

    /**
     * Déconnecter l'utilisateur.
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
