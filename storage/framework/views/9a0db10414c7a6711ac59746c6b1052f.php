<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SafeCity — Mon Profil</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --grad-start: #b6e0ff;
            --grad-end: #f3b8d8;
            --card-bg: #ffffff;
            --accent: #ff7fbf;
            --muted: #94a3b8;
            --input: #e8f2fb;
            --sidebar-bg: #1e293b;
            --sidebar-text: #f8fafc;
            --sidebar-hover: #334155;
        }
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            overflow: hidden;
            @apply bg-gray-50;
        }
        .sidebar {
            width: 280px;
            background-color: var(--sidebar-bg);
            color: var(--sidebar-text);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            transition: all 0.3s;
            z-index: 1000;
            overflow-y: auto;
        }
        .nav-link {
            @apply flex items-center px-4 py-3 text-gray-300 rounded-lg transition-colors mb-2;
        }
        .nav-link.active {
            @apply bg-gradient-to-r from-blue-500 to-pink-500 text-white font-medium;
        }
        .nav-link i {
            @apply w-6 text-center mr-3;
        }
        .nav-link:not(.active):hover {
            @apply bg-gray-700;
        }
        .dashboard-card {
            @apply bg-white rounded-xl shadow-sm p-6 mb-6 border border-gray-100;
        }
        .title {
            @apply text-2xl font-bold text-gray-800;
        }
        .user-profile {
            @apply p-4 mb-6 bg-gray-700/50 rounded-lg;
        }
        .nav-link i {
            @apply w-6 text-center mr-3;
        }
        .main-content {
            flex: 1;
            margin-left: 280px;
            height: 100vh;
            overflow-y: auto;
            @apply bg-gray-50;
        }
        .btn-primary {
            @apply bg-gradient-to-r from-blue-500 to-pink-500 text-white px-6 py-2.5 rounded-lg font-medium hover:opacity-90 transition-all shadow-sm hover:shadow-md;
        }
    </style>
</head>
<body>
    <!-- Mobile menu button -->
    <button class="mobile-menu-btn fixed top-4 left-4 z-50 p-2 rounded-md bg-white shadow-md lg:hidden" onclick="toggleSidebar()">
        <i class="fas fa-bars text-gray-800"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="p-6">
            <!-- User Profile -->
            <div class="user-profile flex items-center space-x-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-pink-500 flex items-center justify-center text-white font-bold">
                    <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                </div>
                <div>
                    <div class="font-medium text-white"><?php echo e(auth()->user()->name); ?></div>
                    <div class="text-sm text-gray-300">Citoyen</div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="mt-6">
                <a href="<?php echo e(route('citizen.dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('citizen.dashboard') ? 'active' : ''); ?>">
                    <i class="fas fa-home"></i>
                    <span>Tableau de bord</span>
                </a>
                <a href="<?php echo e(route('citizen.incidents.index')); ?>" class="nav-link <?php echo e(request()->routeIs('citizen.incidents.*') ? 'active' : ''); ?>">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Mes signalements</span>
                </a>
                <a href="<?php echo e(route('citizen.incidents.create')); ?>" class="nav-link">
                    <i class="fas fa-plus-circle"></i>
                    <span>Nouveau signalement</span>
                </a>
                <a href="<?php echo e(route('citizen.profile.edit')); ?>" class="nav-link active">
                    <i class="fas fa-user"></i>
                    <span>Mon Profil</span>
                </a>
            </nav>
        </div>

        <!-- Logout -->
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-700">
            <form method="POST" action="<?php echo e(route('logout')); ?>" class="w-full">
                <?php echo csrf_field(); ?>
                <button type="submit" class="flex items-center w-full px-4 py-3 text-red-400 rounded-lg hover:bg-red-900/20 transition-colors">
                    <i class="w-6 text-center fas fa-sign-out-alt"></i>
                    <span class="ml-3">Déconnexion</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <main class="main-content">
        <div class="p-6">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="title">Mon Profil</h1>
                    <p class="subtitle">Gérez vos informations personnelles et vos paramètres de sécurité</p>
                </div>
            </div>

            <div class="dashboard-card">

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Informations personnelles</h2>
                <p class="mt-1 text-sm text-gray-500">Ces informations seront visibles par les autres utilisateurs.</p>
            </div>

            <form action="<?php echo e(route('citizen.profile.update')); ?>" method="POST" enctype="multipart/form-data" class="p-6">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="space-y-6">
                    <!-- Profile Photo -->
                    <div class="flex items-center">
                        <div class="relative">
                            <img id="avatarPreview" class="h-20 w-20 rounded-full object-cover" src="<?php echo e($user->avatar ? Storage::url($user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name)); ?>" alt="<?php echo e($user->name); ?>">
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
                        <input type="text" name="name" id="name" value="<?php echo e(old('name', $user->name)); ?>" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Adresse email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="<?php echo e(old('email', $user->email)); ?>" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                        <input type="tel" name="phone" id="phone" value="<?php echo e(old('phone', $user->phone)); ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="+212 6 00 00 00 00">
                        <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Adresse</label>
                        <input type="text" name="address" id="address" value="<?php echo e(old('address', $user->address)); ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Votre adresse complète">
                        <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                                <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                                <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                        <a href="<?php echo e(route('citizen.dashboard')); ?>" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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

    <script>
        // Toggle sidebar on mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.style.transform = sidebar.style.transform === 'translateX(0px)' ? 'translateX(-100%)' : 'translateX(0)';
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const menuBtn = document.querySelector('.mobile-menu-btn');
            
            if (window.innerWidth < 1024 && !sidebar.contains(event.target) && !menuBtn.contains(event.target)) {
                sidebar.style.transform = 'translateX(-100%)';
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth >= 1024) {
                sidebar.style.transform = 'translateX(0)';
            } else {
                sidebar.style.transform = 'translateX(-100%)';
            }
        });

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
</script>

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

    .file-upload {
        background-color: #f0f9ff;
        border: 2px dashed #bae6fd;
        border-radius: 0.5rem;
        cursor: pointer;
        display: inline-block;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        width: 100%;
    }

    .file-upload:hover {
        background-color: #e0f2fe;
        border-color: #7dd3fc;
    }

    .file-upload p {
        color: #0c4a6e;
        font-size: 0.875rem;
        margin: 0.5rem 0 0;
    }

    .file-upload svg {
        color: #0ea5e9;
        height: 2.5rem;
        margin: 0 auto;
        width: 2.5rem;
    }
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
<?php /**PATH C:\Users\zerni\CascadeProjects\windsurf-project-8\SafeCity\resources\views/citizen/profile/edit.blade.php ENDPATH**/ ?>