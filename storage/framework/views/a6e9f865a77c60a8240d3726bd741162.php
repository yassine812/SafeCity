<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SafeCity — Tableau de bord Citoyen</title>

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
        }

        .main-content {
            flex: 1;
            margin-left: 280px;
            height: 100vh;
            overflow-y: auto;
            background: linear-gradient(120deg, var(--grad-start), var(--grad-end));
            padding: 1.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: var(--sidebar-text);
            border-radius: 0.375rem;
            margin: 0.25rem 1rem;
            transition: all 0.2s;
        }

        .nav-link:hover {
            background-color: var(--sidebar-hover);
            color: white;
        }

        .nav-link i {
            width: 24px;
            margin-right: 0.75rem;
            text-align: center;
        }

        .nav-link.active {
            background-color: var(--accent);
            color: white;
            font-weight: 500;
        }

        .user-profile {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .dashboard-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            margin-bottom: 1.5rem;
        }

        .feed-card {
            background: white;
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }

        .feed-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.mobile-show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .mobile-menu-btn {
                display: block !important;
            }
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent), #ff5ca1);
            color: white;
            font-weight: 600;
            padding: 10px 24px;
            border-radius: 50px;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px -5px rgba(255, 127, 191, 0.5);
        }

        .title {
            font-size: 32px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 10px;
        }

        .subtitle {
            color: var(--muted);
            margin-bottom: 30px;
            font-size: 16px;
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
                <a href="<?php echo e(route('citizen.dashboard')); ?>" class="flex items-center px-4 py-3 bg-gradient-to-r from-pink-500/20 to-pink-600/30 text-white rounded-lg border-l-4 border-pink-400 shadow-md">
                    <div class="w-6 h-6 flex items-center justify-center mr-3 rounded-full bg-pink-400/30">
                        <i class="fas fa-home text-pink-100 text-sm"></i>
                    </div>
                    <span class="font-semibold text-white">Tableau de bord</span>
                    <span class="ml-auto w-2 h-2 bg-pink-400 rounded-full animate-pulse"></span>
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
                
                <a href="<?php echo e(route('profile.edit')); ?>" class="flex items-center px-4 py-3 text-pink-100 hover:bg-pink-900/30 rounded-lg transition-all duration-200 group">
                    <div class="w-6 h-6 flex items-center justify-center mr-3 rounded-full bg-pink-900/30 group-hover:bg-pink-500/30 transition-colors">
                        <i class="fas fa-user text-pink-300 text-sm"></i>
                    </div>
                    <span class="font-medium">Mon Profil</span>
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

    <!-- Main content -->
    <div class="main-content">
        <!-- MAIN CONTENT -->
        <div class="dashboard-card">
            <!-- HEADER -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="title">Bienvenue, <?php echo e(auth()->user()->name); ?></h1>
                    <p class="subtitle">Restez informé des incidents dans votre quartier</p>
                </div>
                <a href="<?php echo e(route('citizen.incidents.create')); ?>" class="btn-primary">
                    + Signaler un incident
                </a>
            </div>

            <!-- FEED TITLE -->
            <h2 class="text-xl font-bold mb-6 text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                Incidents dans votre ville
            </h2>

            <!-- INCIDENT FEED -->
            <div class="space-y-6">
                <?php $__empty_1 = true; $__currentLoopData = $incidents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $incident): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="feed-card">
                        <!-- HEADER USER + DATE -->
                        <div class="flex items-center mb-3">
                            <img src="<?php echo e(auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name='.auth()->user()->name); ?>"
                                 class="w-10 h-10 rounded-full object-cover">

                            <div class="ml-3">
                                <p class="font-semibold text-gray-800"><?php echo e($incident->user->name ?? 'Utilisateur inconnu'); ?></p>
                                <p class="text-xs text-gray-500"><?php echo e($incident->created_at->diffForHumans()); ?></p>
                            </div>
                        </div>

                        <!-- INCIDENT TYPE + STATUS -->
                        <div class="mb-3 flex items-center justify-between">
                            <span class="font-bold text-gray-700 text-lg">
                                <?php echo e($incident->type->name ?? 'Type inconnu'); ?>

                            </span>

                            <!-- Status -->
                            <span class="status-badge 
                                <?php if($incident->status=='recu'): ?> bg-blue-100 text-blue-600
                                <?php elseif($incident->status=='en_cours'): ?> bg-yellow-100 text-yellow-700
                                <?php else: ?> bg-green-100 text-green-700 <?php endif; ?>">
                                <?php echo e(ucfirst(str_replace('_', ' ', $incident->status))); ?>

                            </span>
                        </div>

                        <!-- DESCRIPTION -->
                        <p class="text-gray-700 mb-3">
                            <?php echo e($incident->description); ?>

                        </p>

                        <!-- MEDIA (IMAGES) -->
                        <?php if($incident->media && is_array($incident->media) && count($incident->media) > 0): ?>
                            <div class="grid grid-cols-2 gap-3 mb-4">
                                <?php $__currentLoopData = $incident->media; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <img src="<?php echo e(asset('storage/'.$img)); ?>" class="rounded-lg w-full h-48 object-cover shadow">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>

                        <!-- LOCATION -->
                        <?php if($incident->address): ?>
                            <p class="text-sm text-gray-500 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <?php echo e($incident->address); ?>

                            </p>
                        <?php endif; ?>

                        <!-- ACTIONS -->
                        <div class="flex items-center justify-between mt-4 border-t pt-3">
                            <!-- VOTE -->
                            <form action="<?php echo e(route('citizen.incidents.vote', $incident->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="text-gray-600 hover:text-pink-500 font-medium flex items-center transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                    </svg>
                                    <span>Confirmer (<?php echo e($incident->votes_count ?? 0); ?>)</span>
                                </button>
                            </form>

                            <!-- COMMENTS -->
                            <a href="<?php echo e(route('citizen.incidents.show', $incident->id)); ?>"
                               class="text-gray-600 hover:text-pink-500 font-medium flex items-center transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <span>Commentaires</span>
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-12 px-4">
                        <div class="max-w-md mx-auto">
                            <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Aucun incident signalé</h3>
                            <p class="mt-1 text-gray-500">Soyez le premier à signaler un incident dans votre quartier !</p>
                            <div class="mt-6">
                                <a href="<?php echo e(route('citizen.incidents.create')); ?>" class="btn-primary">
                                    Signaler un incident
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- PAGINATION -->
                <?php if($incidents->hasPages()): ?>
                    <div class="mt-8 flex justify-center">
                        <div class="flex space-x-1">
                            <?php echo e($incidents->links()); ?>

                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Custom styles for pagination -->
        <style>
            .pagination {
                display: flex;
                list-style: none;
                padding: 0;
                margin: 0;
            }
            .page-item {
                margin: 0 4px;
            }
            .page-link {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                color: var(--muted);
                font-weight: 500;
                text-decoration: none;
                transition: all 0.2s;
            }
            .page-item.active .page-link {
                background: linear-gradient(135deg, var(--accent), #ff5ca1);
                color: white;
            }
            .page-item:not(.active) .page-link:hover {
                background-color: #f8fafc;
                color: var(--accent);
            }
            .page-item.disabled .page-link {
                opacity: 0.5;
                cursor: not-allowed;
            }
        </style>
    </div>

    <script>
        // Toggle sidebar on mobile
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('mobile-show');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const menuBtn = document.querySelector('.mobile-menu-btn');
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickOnMenuBtn = menuBtn.contains(event.target);
            
            if (!isClickInsideSidebar && !isClickOnMenuBtn && window.innerWidth <= 768) {
                sidebar.classList.remove('mobile-show');
            }
        });

        // Update active link based on current URL
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    navLinks.forEach(l => l.classList.remove('active'));
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html><?php /**PATH C:\Users\zerni\CascadeProjects\windsurf-project-8\SafeCity\resources\views/citizen/dashboard.blade.php ENDPATH**/ ?>