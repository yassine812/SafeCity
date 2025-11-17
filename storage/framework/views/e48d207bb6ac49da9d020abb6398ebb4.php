<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SafeCity — Modifier le signalement</title>

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
            </div>
            
            <nav class="space-y-2">
                <a href="<?php echo e(route('citizen.dashboard')); ?>" class="nav-link group">
                    <i class="fas fa-home text-pink-300 group-hover:text-white"></i>
                    Tableau de bord
                </a>
                <a href="<?php echo e(route('citizen.incidents.index')); ?>" class="nav-link group">
                    <i class="fas fa-exclamation-triangle text-pink-300 group-hover:text-white"></i>
                    Mes signalements
                </a>
                <a href="<?php echo e(route('citizen.incidents.create')); ?>" class="nav-link group">
                    <i class="fas fa-plus-circle text-pink-300 group-hover:text-white"></i>
                    Nouveau signalement
                </a>
                <a href="<?php echo e(route('profile.edit')); ?>" class="nav-link group">
                    <i class="fas fa-user text-pink-300 group-hover:text-white"></i>
                    Mon profil
                </a>
                <form method="POST" action="<?php echo e(route('logout')); ?>" class="w-full">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="nav-link group w-full text-left">
                        <i class="fas fa-sign-out-alt text-pink-300 group-hover:text-white"></i>
                        Déconnexion
                    </button>
                </form>
            </nav>
        </div>
    </div>

    <!-- Main content -->
    <div class="main-content">
        <div class="dashboard-card">
            <!-- HEADER -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="title">Modifier le signalement</h1>
                    <p class="subtitle">Mettez à jour les détails de votre signalement</p>
                </div>
            </div>

            <form action="<?php echo e(route('citizen.incidents.update', $incident)); ?>" 
                  method="POST" enctype="multipart/form-data" class="p-6">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="space-y-6">
                    <!-- Category -->
                    <div class="space-y-2">
                        <label for="category_id" class="block text-sm font-medium text-gray-700">
                            Catégorie <span class="text-pink-500">*</span>
                        </label>

                        <select name="category_id" id="category_id" required 
                            class="block w-full pl-4 pr-10 py-3 border rounded-lg">
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>"
                                    <?php echo e($incident->category_id == $category->id ? 'selected' : ''); ?>>
                                    <?php echo e($category->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Title -->
                    <div class="space-y-2">
                        <label for="title" class="block text-sm font-medium">Titre *</label>
                        <input type="text" name="title" id="title"
                            value="<?php echo e($incident->title); ?>"
                            class="w-full px-4 py-3 border rounded-lg" required>
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <label for="description" class="block text-sm font-medium">Description *</label>
                        <textarea name="description" id="description"
                            rows="4" required
                            class="w-full px-4 py-3 border rounded-lg"><?php echo e($incident->description); ?></textarea>
                    </div>

                    <!-- City -->
                    <div class="space-y-2">
                        <label for="city" class="block text-sm font-medium">Ville *</label>
                        <input type="text" name="city" id="city"
                            value="<?php echo e($incident->city); ?>"
                            class="w-full px-4 py-3 border rounded-lg" required>
                    </div>

                    <!-- Address -->
                    <div class="space-y-2">
                        <label for="address_line1" class="block text-sm font-medium">Adresse *</label>
                        <input type="text" name="address_line1" id="address_line1"
                            value="<?php echo e($incident->address_line1); ?>"
                            class="w-full px-4 py-3 border rounded-lg" required>
                    </div>

                    <!-- Postal Code -->
                    <div class="space-y-2">
                        <label for="postal_code" class="block text-sm font-medium">Code postal *</label>
                        <input type="text" name="postal_code" id="postal_code"
                            value="<?php echo e($incident->postal_code); ?>"
                            class="w-full px-4 py-3 border rounded-lg" required>
                    </div>

                    <!-- Country -->
                    <input type="hidden" name="country" value="Tunisia">

                    <!-- Media Upload -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Médias (images/vidéos)</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg" id="dropzone">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="media" class="relative cursor-pointer bg-white rounded-md font-medium text-pink-600 hover:text-pink-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-pink-500">
                                        <span>Télécharger des fichiers</span>
                                        <input id="media" name="media[]" type="file" class="sr-only" multiple>
                                    </label>
                                    <p class="pl-1">ou glisser-déposer</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF jusqu'à 5MB</p>
                            </div>
                        </div>
                        <?php $__errorArgs = ['media'];
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

                    <!-- Media Preview -->
                    <div id="media-preview" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <?php $__currentLoopData = $incident->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="relative group">
                                <img src="<?php echo e(asset('storage/'.$image->path)); ?>" 
                                     class="w-full h-32 object-cover rounded-lg">
                                <button type="button" 
                                        class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity"
                                        onclick="event.preventDefault(); document.getElementById('delete-image-<?php echo e($image->id); ?>').submit();">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                                <form id="delete-image-<?php echo e($image->id); ?>" 
                                      action="<?php echo e(route('incident-images.destroy', $image)); ?>" 
                                      method="POST" 
                                      class="hidden">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                </form>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <!-- Submit -->
                    <div class="flex justify-end mt-6">
                        <button type="submit"
                            class="px-6 py-3 bg-pink-600 text-white rounded-lg">
                            Enregistrer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle sidebar on mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const menuButton = document.querySelector('.mobile-menu-btn');
            
            if (window.innerWidth < 1024 && 
                !sidebar.contains(event.target) && 
                !menuButton.contains(event.target)) {
                sidebar.classList.add('-translate-x-full');
            }
        });

        // Preview uploaded media
        document.getElementById('media')?.addEventListener('change', function(event) {
            const files = event.target.files;
            let previewContainer = document.getElementById('media-preview');
            
            if (!previewContainer) {
                const newPreviewContainer = document.createElement('div');
                newPreviewContainer.id = 'media-preview';
                newPreviewContainer.className = 'mt-4 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4';
                document.querySelector('form').insertBefore(newPreviewContainer, document.querySelector('button[type="submit"]'));
                previewContainer = newPreviewContainer;
            } else {
                imageContainer.style.opacity = '1';
                imageContainer.style.border = 'none';
            }
        });
    });
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(config('services.google.maps_api_key')); ?>&libraries=places&callback=initMap">
</script>

<style>
    .pac-container {
        z-index: 1100 !important;
    }
</style>
<?php /**PATH C:\Users\zerni\CascadeProjects\windsurf-project-8\SafeCity\resources\views/citizen/incidents/edit.blade.php ENDPATH**/ ?>