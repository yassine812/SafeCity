@extends('layouts.app')

@section('content')
<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8 bg-gray-50">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-900">Mon Profil</h1>
            <p class="mt-2 text-sm text-gray-600">Gérez vos informations personnelles et vos paramètres de sécurité</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Informations personnelles</h2>
                <p class="mt-1 text-sm text-gray-500">Ces informations seront visibles par les autres utilisateurs.</p>
            </div>

            <form action="{{ route('citizen.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Profile Photo -->
                    <div class="flex items-center">
                        <div class="relative">
                            <img id="avatarPreview" class="h-20 w-20 rounded-full object-cover" src="{{ $user->avatar ? Storage::url($user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}" alt="{{ $user->name }}">
                            <label for="avatar" class="absolute bottom-0 right-0 bg-white p-1.5 rounded-full shadow-sm border border-gray-300 cursor-pointer hover:bg-gray-50">
                                <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <input id="avatar" name="avatar" type="file" class="sr-only" accept="image/*">
                            </label>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-lg font-medium text-gray-900">Photo de profil</h3>
                            <p class="mt-1 text-sm text-gray-500">Formats supportés : JPG, PNG, GIF jusqu'à 2MB</p>
                        </div>
                    </div>

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nom complet <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Adresse email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                        <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="+212 6 00 00 00 00">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Adresse</label>
                        <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Votre adresse complète">
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Change Section -->
                    <div class="pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Changer le mot de passe</h3>
                        <p class="mt-1 text-sm text-gray-500">Laissez ces champs vides si vous ne souhaitez pas modifier votre mot de passe.</p>

                        <div class="mt-6 space-y-4">
                            <!-- Current Password -->
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700">Mot de passe actuel</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="password" name="current_password" id="current_password" class="block w-full pr-10 border-gray-300 focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md" autocomplete="current-password">
                                </div>
                                @error('current_password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="password" name="new_password" id="new_password" class="block w-full pr-10 border-gray-300 focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md" autocomplete="new-password">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span id="password-strength" class="text-xs text-gray-500"></span>
                                    </div>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Minimum 8 caractères, avec au moins une lettre et un chiffre.</p>
                                @error('new_password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm New Password -->
                            <div>
                                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le nouveau mot de passe</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="block w-full pr-10 border-gray-300 focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md" autocomplete="new-password">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <span id="password-match" class="hidden">
                                            <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-5 border-t border-gray-200">
                    <div class="flex justify-end">
                        <a href="{{ route('citizen.dashboard') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Annuler
                        </a>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Enregistrer les modifications
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Avatar preview
        const avatarInput = document.getElementById('avatar');
        const avatarPreview = document.getElementById('avatarPreview');
        
        if (avatarInput) {
            avatarInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        avatarPreview.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        }
        
        // Password strength indicator
        const passwordInput = document.getElementById('new_password');
        const passwordStrength = document.getElementById('password-strength');
        const passwordConfirm = document.getElementById('new_password_confirmation');
        const passwordMatch = document.getElementById('password-match');
        
        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;
                let message = '';
                
                // Check password length
                if (password.length >= 8) strength += 1;
                
                // Check for numbers
                if (/\d/.test(password)) strength += 1;
                
                // Check for letters
                if (/[a-zA-Z]/.test(password)) strength += 1;
                
                // Check for special characters
                if (/[^a-zA-Z0-9]/.test(password)) strength += 1;
                
                // Set strength message and color
                switch(strength) {
                    case 0:
                    case 1:
                        message = 'Faible';
                        passwordStrength.className = 'text-xs text-red-500';
                        break;
                    case 2:
                        message = 'Moyen';
                        passwordStrength.className = 'text-xs text-yellow-500';
                        break;
                    case 3:
                        message = 'Fort';
                        passwordStrength.className = 'text-xs text-blue-500';
                        break;
                    case 4:
                        message = 'Très fort';
                        passwordStrength.className = 'text-xs text-green-500';
                        break;
                }
                
                passwordStrength.textContent = message || '';
            });
        }
        
        // Password match indicator
        if (passwordConfirm) {
            passwordConfirm.addEventListener('input', function() {
                if (passwordInput.value && this.value) {
                    if (passwordInput.value === this.value) {
                        passwordMatch.classList.remove('hidden');
                        this.classList.remove('border-red-300', 'focus:ring-red-500', 'focus:border-red-500');
                        this.classList.add('border-green-300', 'focus:ring-green-500', 'focus:border-green-500');
                    } else {
                        passwordMatch.classList.add('hidden');
                        this.classList.remove('border-green-300', 'focus:ring-green-500', 'focus:border-green-500');
                        this.classList.add('border-red-300', 'focus:ring-red-500', 'focus:border-red-500');
                    }
                } else {
                    passwordMatch.classList.add('hidden');
                    this.classList.remove('border-green-300', 'focus:ring-green-500', 'focus:border-green-500', 'border-red-300', 'focus:ring-red-500', 'focus:border-red-500');
                }
            });
        }
    });
</script>
@endpush

@push('styles')
<style>
    input[type="file"] {
        border: 0;
        clip: rect(0, 0, 0, 0);
        height: 1px;
        overflow: hidden;
        padding: 0;
        position: absolute !important;
        white-space: nowrap;
        width: 1px;
    }
    
    .file-upload-btn {
        color: #4f46e5;
        text-decoration: none;
        cursor: pointer;
    }
    
    .file-upload-btn:hover {
        text-decoration: underline;
    }
    
    /* Custom checkbox */
    .custom-checkbox {
        display: flex;
        align-items: center;
        position: relative;
        padding-left: 1.5rem;
        cursor: pointer;
    }
    
    .custom-checkbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }
    
    .checkmark {
        position: absolute;
        left: 0;
        height: 1.25rem;
        width: 1.25rem;
        background-color: #fff;
        border: 1px solid #d1d5db;
        border-radius: 0.25rem;
        transition: all 0.2s;
    }
    
    .custom-checkbox:hover input ~ .checkmark {
        border-color: #9ca3af;
    }
    
    .custom-checkbox input:checked ~ .checkmark {
        background-color: #4f46e5;
        border-color: #4f46e5;
    }
    
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }
    
    .custom-checkbox input:checked ~ .checkmark:after {
        display: block;
    }
    
    .custom-checkbox .checkmark:after {
        left: 0.45rem;
        top: 0.25rem;
        width: 0.3rem;
        height: 0.6rem;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }
</style>
@endpush
