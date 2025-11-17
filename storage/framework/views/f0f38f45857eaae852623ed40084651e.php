<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SafeCity — Mes Signalements</title>

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
            padding: 2rem;
            background-color: #f8fafc;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: var(--sidebar-text);
            text-decoration: none;
            transition: all 0.2s;
            border-radius: 0.5rem;
            margin: 0.25rem 1rem;
        }

        .nav-link:hover {
            background-color: var(--sidebar-hover);
        }

        .nav-link.active {
            background-color: var(--accent);
            color: white;
        }

        .nav-link i {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
        }

        .dashboard-card {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            margin-bottom: 2rem;
        }

        .title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .subtitle {
            color: #64748b;
            font-size: 0.875rem;
        }

        .feed-card {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            margin-bottom: 1.5rem;
            border: 1px solid #e2e8f0;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }

        .pagination .page-link {
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
            border-radius: 0.375rem;
            color: #4b5563;
            text-decoration: none;
            transition: all 0.2s;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--accent);
            color: white;
            border-color: var(--accent);
        }

        .pagination .page-link:hover {
            background-color: #f1f5f9;
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                width: 100%;
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
                
                <a href="<?php echo e(route('citizen.incidents.index')); ?>" class="flex items-center px-4 py-3 bg-gradient-to-r from-pink-500/20 to-pink-600/30 text-white rounded-lg border-l-4 border-pink-400 shadow-md">
                    <div class="w-6 h-6 flex items-center justify-center mr-3 rounded-full bg-pink-400/30">
                        <i class="fas fa-exclamation-triangle text-pink-100 text-sm"></i>
                    </div>
                    <span class="font-semibold text-white">Mes signalements</span>
                    <span class="ml-auto w-2 h-2 bg-pink-400 rounded-full animate-pulse"></span>
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

    <div class="main-content">
        <div class="dashboard-card">
            <!-- HEADER -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="title">Mes Signalements</h1>
                    <p class="subtitle">Consultez et gérez tous vos signalements</p>
                </div>
                <a href="<?php echo e(route('citizen.incidents.create')); ?>" class="bg-gradient-to-r from-purple-500 to-pink-500 text-white px-6 py-2.5 rounded-lg font-medium hover:opacity-90 transition flex items-center">
                    <i class="fas fa-plus-circle mr-2"></i>
                    <span>Nouveau signalement</span>
                </a>
            </div>

    <?php if(session('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if($incidents->isEmpty()): ?>
        <div class="bg-white rounded-xl shadow-sm p-12 text-center border border-gray-100">
            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-gray-50 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Aucun signalement pour le moment</h3>
            <p class="text-gray-500 mb-6 max-w-md mx-auto">Vous n'avez pas encore créé de signalement. Commencez par signaler un incident pour contribuer à la sécurité de votre quartier.</p>
            <a href="<?php echo e(route('citizen.incidents.create')); ?>" class="inline-flex items-center bg-gradient-to-r from-purple-500 to-pink-500 text-white px-6 py-2.5 rounded-lg font-medium hover:opacity-90 transition">
                <i class="fas fa-plus-circle mr-2"></i>
                <span>Signaler un incident</span>
            </a>
        </div>
    <?php else: ?>
        <div class="space-y-6">
            <?php $__currentLoopData = $incidents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $incident): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <!-- Incident Card -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-pink-50 hover:shadow-2xl transition-all duration-300" id="incident-<?php echo e($incident->id); ?>">
                    <!-- Header -->
                    <div class="p-5 flex items-center">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-pink-400 to-pink-500 flex items-center justify-center text-white font-semibold shadow-md">
                            <?php echo e(strtoupper(substr($incident->user->name, 0, 1))); ?>

                        </div>
                        <div class="ml-4">
                            <h3 class="font-semibold text-gray-900 text-sm"><?php echo e($incident->user->name); ?></h3>
                            <div class="flex items-center text-xs text-gray-500">
                                <span><?php echo e($incident->created_at->diffForHumans()); ?></span>
                                <span class="mx-1">•</span>
                                <i class="fas fa-map-marker-alt text-pink-400"></i>
                            </div>
                        </div>
                        <div class="ml-auto">
                            <?php
                                $statusSlug = strtolower($incident->status ?? 'en_attente');
                                $statusName = ucfirst(str_replace('_', ' ', $incident->status ?? 'en_attente'));
                                
                                $statusClasses = [
                                    'nouveau' => 'bg-yellow-100 text-yellow-800',
                                    'en_attente' => 'bg-yellow-100 text-yellow-800',
                                    'en_cours' => 'bg-blue-100 text-blue-800',
                                    'resolu' => 'bg-green-100 text-green-800',
                                    'ferme' => 'bg-gray-100 text-gray-800'
                                ];
                                
                                // Map 'nouveau' status to display as 'En attente'
                                $displayStatus = ($statusSlug === 'nouveau') ? 'En attente' : $statusName;
                                
                                $statusClass = $statusClasses[$statusSlug] ?? 'bg-gray-100 text-gray-800';
                            ?>
                            <div class="flex items-center space-x-2">
                                <button class="vote-btn flex items-center px-2 py-1 bg-gray-100 hover:bg-gray-200 rounded-full text-sm transition-colors" data-id="<?php echo e($incident->id); ?>">
                                    <i class="fas fa-fire text-pink-500"></i>
                                    <span class="ml-1 vote-count"><?php echo e($incident->votes_count ?? 0); ?></span>
                                </button>
                                <span class="px-3 py-1 rounded-full text-xs font-medium <?php echo e($statusClass); ?> shadow-sm">
                                    <?php echo e($displayStatus); ?>

                                </span>
                            </div>
                            </span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="px-5 pb-4">
                        <h2 class="text-lg font-semibold text-gray-900 mb-2"><?php echo e($incident->title ?? ucfirst($incident->type)); ?></h2>
                        <p class="text-gray-700 text-sm leading-relaxed"><?php echo e($incident->description); ?></p>
                    </div>

                    <!-- Location -->
                    <?php
                        $address1 = $incident->address_line1;
                        $address2 = $incident->address_line2;
                        $city = $incident->city;
                        $postalCode = $incident->postal_code;
                    ?>
                    <?php if($address1 || $address2 || $city || $postalCode): ?>
                    <div class="px-5 pb-4">
                        <div class="flex items-start text-sm">
                            <i class="fas fa-map-marker-alt mt-1 mr-2 text-pink-500"></i>
                            <div class="space-y-1">
                                <?php if($address1): ?>
                                    <div class="font-medium text-gray-900"><?php echo e($address1); ?></div>
                                    <?php if($address2): ?>
                                        <div class="text-gray-700"><?php echo e($address2); ?></div>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if($city || $postalCode): ?>
                                <div class="flex flex-wrap items-center gap-x-3 text-gray-600 mt-1">
                                    <?php if($city): ?>
                                        <span class="inline-flex items-center">
                                            <i class="fas fa-city mr-1 text-pink-400"></i>
                                            <?php echo e($city); ?>

                                        </span>
                                    <?php endif; ?>
                                    <?php if($postalCode): ?>
                                        <span class="inline-flex items-center">
                                            <i class="fas fa-mailbox mr-1 text-pink-400"></i>
                                            <?php echo e($postalCode); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Media Section -->
                    <?php if($incident->images->isNotEmpty()): ?>
                    <div class="px-5 pb-4">
                        <div class="grid grid-cols-3 gap-2">
                            <?php $__currentLoopData = $incident->images->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden">
                                <img src="<?php echo e(asset('storage/' . $image->path)); ?>" 
                                     alt="Incident image" 
                                     class="w-full h-full object-cover">
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Footer -->
                    <div class="px-5 py-3 border-t border-gray-100 bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <a href="<?php echo e(route('citizen.incidents.edit', $incident)); ?>" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center">
                                    <i class="fas fa-edit mr-1"></i>
                                    Modifier
                                </a>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="text-sm text-gray-500">
                                    <i class="far fa-comment-alt mr-1"></i>
                                    <?php echo e($incident->comments_count ?? 0); ?>

                                </span>
                                <span class="text-sm text-gray-500">
                                    <i class="far fa-thumbs-up mr-1"></i>
                                    <?php echo e($incident->votes_count ?? 0); ?>

                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center text-sm text-gray-500">
                                <button class="flex items-center space-x-1 hover:text-purple-600 transition-colors">
                                    <i class="far fa-comment-alt"></i>
                                    <span><?php echo e($incident->comments_count ?? 0); ?> commentaires</span>
                                </button>
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <form action="<?php echo e(route('citizen.incidents.vote', $incident)); ?>" method="POST" class="flex items-center">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="flex items-center space-x-1 hover:text-yellow-500 transition-colors">
                                        <i class="fas fa-thumbs-up"></i>
                                        <span><?php echo e($incident->votes_count ?? 0); ?> votes</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="text-sm text-gray-500">
                            Signalé il y a <?php echo e($incident->created_at->diffForHumans()); ?>

                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <div class="mt-8">
                <div class="mt-8">
                    <?php echo e($incidents->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Toggle sidebar on mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const menuBtn = document.querySelector('.mobile-menu-btn');
            
            if (window.innerWidth < 1024) {
                if (!sidebar.contains(event.target) && !menuBtn.contains(event.target)) {
                    sidebar.classList.remove('open');
                }
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth >= 1024) {
                sidebar.style.transform = 'translateX(0)';
            } else {
                sidebar.style.transform = '';
            }
        });

        // Handle voting
        document.querySelectorAll('.vote-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.dataset.id;
                const countSpan = this.querySelector('.vote-count');
                const button = this;

                // Add loading state
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                fetch(`/incidents/${id}/vote`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Update the vote count
                    countSpan.textContent = data.votes;
                    
                    // Toggle active state
                    if (data.message.includes('added')) {
                        button.classList.add('text-pink-600');
                    } else {
                        button.classList.remove('text-pink-600');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Une erreur est survenue lors du vote. Veuillez réessayer.');
                })
                .finally(() => {
                    // Remove loading state
                    button.disabled = false;
                    button.innerHTML = `
                        <i class="fas fa-fire"></i>
                        <span class="ml-1 vote-count">${countSpan.textContent}</span>
                    `;
                });
            });
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\zerni\CascadeProjects\windsurf-project-8\SafeCity\resources\views/citizen/incidents/index.blade.php ENDPATH**/ ?>