<!DOCTYPE html>
<html lang="fr" class="h-full">
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
            --success: #10b981;
            --danger: #ef4444;
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            overflow: hidden;
        }

        .sidebar {
            width: 280px;
            background-color: #1e293b;
            color: #f8fafc;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex: 1;
            margin-left: 280px;
            height: 100vh;
            overflow-y: auto;
            padding: 2rem;
            background-color: #f8fafc;
        }

        .dashboard-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .subtitle {
            color: #64748b;
            font-size: 0.875rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--grad-start), var(--grad-end));
            color: white;
            border: none;
            padding: 0.625rem 1.25rem;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #334155;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background-color: var(--input);
            transition: all 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(255, 127, 191, 0.2);
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile menu button -->
    <button class="mobile-menu-btn fixed top-4 left-4 z-50 p-2 rounded-md bg-white shadow-md lg:hidden" onclick="toggleSidebar()">
        <i class="fas fa-bars text-gray-800"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar bg-slate-800 text-slate-100 shadow-lg" id="sidebar">
        <div class="p-6">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold">
                    <span class="bg-gradient-to-r from-pink-300 to-pink-400 bg-clip-text text-transparent">SafeCity</span>
                </h2>
                <button class="lg:hidden text-pink-200 hover:text-white" onclick="toggleSidebar()">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            
            <nav class="space-y-2">
                <a href="<?php echo e(route('citizen.dashboard')); ?>" class="flex items-center px-4 py-3 text-pink-100 hover:bg-pink-900/30 rounded-lg transition-all duration-200 group">
                    <div class="w-6 h-6 flex items-center justify-center mr-3 rounded-full bg-pink-900/30 group-hover:bg-pink-500/30 transition-colors">
                        <i class="fas fa-home text-pink-300 text-sm"></i>
                    </div>
                    <span class="font-medium">Tableau de bord</span>
                </a>
                
                <a href="<?php echo e(route('citizen.incidents.index')); ?>" class="flex items-center px-4 py-3 text-pink-100 hover:bg-pink-900/30 rounded-lg transition-all duration-200 group">
                    <div class="w-6 h-6 flex items-center justify-center mr-3 rounded-full bg-pink-900/30 group-hover:bg-pink-500/30 transition-colors">
                        <i class="fas fa-exclamation-triangle text-pink-300 text-sm"></i>
                    </div>
                    <span class="font-medium">Mes signalements</span>
                </a>
                
                <a href="<?php echo e(route('citizen.incidents.create')); ?>" class="flex items-center px-4 py-3 text-pink-100 hover:bg-pink-900/30 rounded-lg transition-all duration-200 group">
                    <div class="w-6 h-6 flex items-center justify-center mr-3 rounded-full bg-pink-900/30 group-hover:bg-pink-500/30 transition-colors">
                        <i class="fas fa-plus-circle text-pink-300 text-sm"></i>
                    </div>
                    <span class="font-medium">Nouveau signalement</span>
                    <span class="ml-auto px-2 py-0.5 text-xs font-medium bg-pink-500/20 text-pink-300 rounded-full">Nouveau</span>
                </a>
                
                <a href="<?php echo e(route('profile.edit')); ?>" class="flex items-center px-4 py-3 bg-gradient-to-r from-pink-500/20 to-pink-600/30 text-white rounded-lg border-l-4 border-pink-400 shadow-md">
                    <div class="w-6 h-6 flex items-center justify-center mr-3 rounded-full bg-pink-400/30">
                        <i class="fas fa-user text-pink-100 text-sm"></i>
                    </div>
                    <span class="font-semibold text-white">Mon Profil</span>
                    <span class="ml-auto w-2 h-2 bg-pink-400 rounded-full animate-pulse"></span>
                </a>
                
                <div class="pt-4 mt-4 border-t border-pink-900/30">
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="w-full flex items-center px-4 py-3 text-pink-200 hover:bg-pink-900/20 rounded-lg transition-all duration-200 group">
                            <div class="w-6 h-6 flex items-center justify-center mr-3 rounded-full bg-pink-900/30 group-hover:bg-pink-500/30 transition-colors">
                                <i class="fas fa-sign-out-alt text-pink-300 text-sm"></i>
                            </div>
                            <span class="font-medium">Déconnexion</span>
                        </button>
                    </form>
                </div>
            </nav>
            
            <!-- User info at bottom -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-pink-900/30 bg-gradient-to-t from-pink-900/30 to-transparent backdrop-blur-sm">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-pink-400 to-pink-500 shadow-md flex items-center justify-center text-white font-bold">
                        <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-white"><?php echo e(auth()->user()->name); ?></p>
                        <p class="text-xs text-pink-200/80">Compte Citoyen</p>
                    </div>
                    <div class="ml-auto">
                        <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="dashboard-card">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="title flex items-center">
                        <i class="fas fa-user-cog text-pink-500 mr-3"></i>
                        Mon Espace Personnel
                    </h1>
                    <p class="subtitle text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Gérez vos informations personnelles et paramètres de sécurité
                    </p>
                </div>
                <div class="bg-gradient-to-r from-blue-100 to-pink-100 p-3 rounded-lg">
                    <p class="text-sm text-gray-600">
                        <i class="fas fa-shield-alt text-blue-400 mr-1"></i>
                        Vos données sont sécurisées et cryptées
                    </p>
                </div>
            </div>

            <div class="space-y-8">
                <!-- Informations du profil -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-user-circle mr-2 text-pink-500"></i>
                        Informations du profil
                    </h2>
                    <?php echo $__env->make('profile.partials.update-profile-information-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>

                <!-- Mise à jour du mot de passe -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-key mr-2 text-blue-400"></i>
                        Mise à jour du mot de passe
                    </h2>
                    <?php echo $__env->make('profile.partials.update-password-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>

                <!-- Suppression du compte -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-red-100">
                    <h2 class="text-lg font-semibold text-red-500 mb-4">
                        <i class="fas fa-exclamation-triangle mr-2 text-red-500"></i>
                        Zone de suppression de compte
                    </h2>
                    <p class="text-sm text-gray-600 mb-4">
                        <i class="fas fa-info-circle text-blue-400 mr-1"></i>
                        Attention : La suppression de votre compte est irréversible. Toutes vos données personnelles et signalements seront définitivement supprimés.
                        Nous vous recommandons d'exporter vos données avant de procéder.
                    </p>
                    <?php echo $__env->make('profile.partials.delete-user-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle sidebar on mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const menuBtn = document.querySelector('.mobile-menu-btn');
            
            if (window.innerWidth < 1024 && 
                !sidebar.contains(event.target) && 
                !menuBtn.contains(event.target)) {
                sidebar.classList.remove('active');
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
    </script>
</body>
</html>
<?php /**PATH C:\Users\zerni\CascadeProjects\windsurf-project-8\SafeCity\resources\views/profile/edit.blade.php ENDPATH**/ ?>