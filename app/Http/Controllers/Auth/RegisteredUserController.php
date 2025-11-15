<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Vérifier si l'utilisateur existe déjà avec cet email
        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser) {
            // Si l'utilisateur existe déjà via un fournisseur externe
            if ($existingUser->provider) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'email' => "Cette adresse e-mail est déjà associée à un compte " . ucfirst($existingUser->provider) . ". Veuillez vous connecter avec " . ucfirst($existingUser->provider) . ".",
                    ]);
            }

            // Si l'utilisateur existe déjà avec un mot de passe
            return back()
                ->withInput()
                ->withErrors([
                    'email' => 'Cette adresse e-mail est déjà utilisée. Veuillez vous connecter ou utiliser une autre adresse e-mail.',
                ]);
        }

        // Créer un nouvel utilisateur
        $user = new User();
        $user->fill([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // Will be hashed by the model's setPasswordAttribute mutator
        ]);
        $user->save();

        event(new Registered($user));

        // Rediriger vers la page de connexion avec un message de succès
        return redirect(route('login'))
            ->with('status', 'Inscription réussie ! Veuillez vous connecter avec vos identifiants.');
    }
}
