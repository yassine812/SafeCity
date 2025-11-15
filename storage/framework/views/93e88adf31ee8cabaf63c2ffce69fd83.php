<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SafeCity — Nouveau Signalement</title>

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

        .dashboard-card {
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            overflow: hidden;
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
            background: linear-gradient(135deg, var(--accent), #ff5ca1);
            color: white;
            font-weight: 500;
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px -5px rgba(255, 127, 191, 0.5);
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
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #f472b6;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #ec4899;
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
                
                <a href="<?php echo e(route('citizen.incidents.create')); ?>" class="flex items-center px-4 py-3 bg-gradient-to-r from-pink-500/20 to-pink-600/30 text-white rounded-lg border-l-4 border-pink-400 shadow-md">
                    <div class="w-6 h-6 flex items-center justify-center mr-3 rounded-full bg-pink-400/30">
                        <i class="fas fa-plus-circle text-pink-100 text-sm"></i>
                    </div>
                    <span class="font-semibold text-white">Nouveau signalement</span>
                    <span class="ml-auto w-2 h-2 bg-pink-400 rounded-full animate-pulse"></span>
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

    <!-- Main Content -->
    <div class="main-content">
        <div class="dashboard-card p-6">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="title">Nouveau signalement</h1>
                <p class="subtitle">Remplissez les détails du problème que vous souhaitez signaler.</p>
            </div>

            <form action="<?php echo e(route('citizen.incidents.store')); ?>" method="POST" enctype="multipart/form-data" class="p-6">
                <?php echo csrf_field(); ?>

                <div class="space-y-6 p-6">
                    <!-- Type d'incident (as text field) -->
                    <div class="space-y-2">
                        <label for="type" class="block text-sm font-medium text-gray-700">Type d'incident <span class="text-pink-500">*</span></label>
                        <div class="relative">
                            <input type="text" name="type" id="type" value="<?php echo e(old('type')); ?>" required 
                                class="block w-full pl-4 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 shadow-sm" 
                                placeholder="Ex: Déchets, Voirie, Éclairage, etc.">
                        </div>
                        <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-pink-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Titre -->
                    <div class="space-y-2">
                        <label for="title" class="block text-sm font-medium text-gray-700">Titre <span class="text-pink-500">*</span></label>
                        <div class="relative">
                            <input type="text" name="title" id="title" value="<?php echo e(old('title')); ?>" required 
                                class="block w-full pl-4 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 shadow-sm" 
                                placeholder="Décrivez brièvement le problème">
                        </div>
                        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-pink-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description détaillée <span class="text-pink-500">*</span></label>
                        <div class="mt-1">
                            <textarea id="description" name="description" rows="4" required 
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 shadow-sm"><?php echo e(old('description')); ?></textarea>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Décrivez le problème en détail. Soyez aussi précis que possible.</p>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-pink-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Adresse -->
                    <div class="space-y-2">
                        <label for="address" class="block text-sm font-medium text-gray-700">Adresse <span class="text-pink-500">*</span></label>
                        <input type="text" name="address" id="address" value="<?php echo e(old('address')); ?>" required 
                            class="block w-full pl-4 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 shadow-sm" 
                            placeholder="Adresse complète">
                        <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-pink-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <!-- Ville -->
                    <div class="space-y-2">
                        <label for="city" class="block text-sm font-medium text-gray-700">Ville <span class="text-pink-500">*</span></label>
                        <input type="text" name="city" id="city" value="<?php echo e(old('city')); ?>" required 
                            class="block w-full pl-4 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 shadow-sm" 
                            placeholder="Ville">
                        <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-pink-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <!-- Code postal -->
                    <div class="space-y-2">
                        <label for="postal_code" class="block text-sm font-medium text-gray-700">Code postal <span class="text-pink-500">*</span></label>
                        <input type="text" name="postal_code" id="postal_code" value="<?php echo e(old('postal_code')); ?>" required 
                            class="block w-full pl-4 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 shadow-sm" 
                            placeholder="Code postal">
                        <?php $__errorArgs = ['postal_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-pink-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <!-- Champs cachés pour la localisation -->
                    <input type="hidden" id="latitude" name="latitude" value="<?php echo e(old('latitude', '0')); ?>">
                    <input type="hidden" id="longitude" name="longitude" value="<?php echo e(old('longitude', '0')); ?>">
                        <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <?php $__errorArgs = ['latitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <?php $__errorArgs = ['longitude'];
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

                    <!-- Téléchargement d'images multiples -->
                    <div class="mb-6" x-data="{ files: [] }" x-on:change="files = Array.from($event.target.files)">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Photos / Vidéos de l'incident
                        </label>

                        <input 
                            id="mediaInput"
                            type="file"
                            name="media[]"
                            accept="image/*,video/*"
                            multiple
                            class="block w-full text-sm text-gray-500 file:bg-pink-500 file:text-white file:px-4 file:py-2 file:rounded-lg file:border-0 file:cursor-pointer hover:file:bg-pink-600 transition-colors duration-200"
                        >

                        <!-- Preview Grid -->
                        <div class="flex justify-between items-center mt-2">
                            <p id="fileCounter" class="text-xs text-gray-500">0 fichier(s) sélectionné(s)</p>
                            <p class="text-xs text-gray-500">Max 10 fichiers</p>
                        </div>
                        <div id="mediaPreview" class="mt-2 grid grid-cols-2 sm:grid-cols-3 gap-4"></div>

                        <?php $__errorArgs = ['media.*'];
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
                </div>

                <div class="mt-8 pt-5 border-t border-gray-100">
                    <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                        <a href="<?php echo e(route('citizen.dashboard')); ?>" class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-colors duration-200">
                            <i class="fas fa-times mr-2"></i>
                            Annuler
                        </a>
                        <button type="submit" class="inline-flex justify-center items-center px-6 py-3 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-all duration-200 transform hover:-translate-y-0.5">
                            <i class="fas fa-save mr-2"></i>
                            Enregistrer le signalement
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Map Modal -->
<div id="mapModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg w-full max-w-4xl h-3/4 flex flex-col">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Sélectionner un emplacement sur la carte</h3>
            <button type="button" id="closeMapModal" class="text-gray-400 hover:text-gray-500">
                <span class="sr-only">Fermer</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="flex-1 p-4">
            <div id="map" class="w-full h-full rounded-lg border border-gray-300"></div>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
            <button type="button" id="cancelLocation" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Annuler
            </button>
            <button type="button" id="confirmLocation" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Confirmer l'emplacement
            </button>
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

    // Close sidebar when window is resized to desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) {
            document.getElementById('sidebar').classList.remove('active');
        }
    });
</script>

<?php $__env->startPush('scripts'); ?>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Map Modal Elements
        const mapModal = document.getElementById('mapModal');
        const openMapModal = document.getElementById('openMapModal');
        const closeMapModal = document.getElementById('closeMapModal');
        const cancelLocation = document.getElementById('cancelLocation');
        const confirmLocation = document.getElementById('confirmLocation');
        const locationInput = document.getElementById('location');
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');

        // Initialize map when modal opens
        let map, marker;
        
        openMapModal.addEventListener('click', function() {
            mapModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Initialize map if not already done
            if (!map) {
                initMap();
            }
        });

        // Close modal functions
        function closeModal() {
            mapModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        closeMapModal.addEventListener('click', closeModal);
        cancelLocation.addEventListener('click', closeModal);

        // Initialize the map
        function initMap() {
            // Default to Casablanca coordinates if no previous location
            const defaultLat = 33.5731;
            const defaultLng = -7.5898;
            
            // Use previous location if available
            const initialLat = latitudeInput.value ? parseFloat(latitudeInput.value) : defaultLat;
            const initialLng = longitudeInput.value ? parseFloat(longitudeInput.value) : defaultLng;
            
            map = L.map('map').setView([initialLat, initialLng], 13);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            
            // Add marker
            if (latitudeInput.value && longitudeInput.value) {
                marker = L.marker([initialLat, initialLng], {
                    draggable: true
                }).addTo(map);
            } else {
                // Add click event to place marker
                map.on('click', function(e) {
                    if (marker) {
                        marker.setLatLng(e.latlng);
                    } else {
                        marker = L.marker(e.latlng, {
                            draggable: true
                        }).addTo(map);
                    }
                    updateLocationInputs(e.latlng.lat, e.latlng.lng);
                });
            }
            
            // Update location when marker is dragged
            if (marker) {
                marker.on('dragend', function(e) {
                    const position = marker.getLatLng();
                    updateLocationInputs(position.lat, position.lng);
                });
            }
        }
        
        // Update location inputs with reverse geocoding
        function updateLocationInputs(lat, lng) {
            // Update hidden inputs
            latitudeInput.value = lat.toFixed(6);
            longitudeInput.value = lng.toFixed(6);
            
            // Use OpenStreetMap Nominatim for reverse geocoding
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&accept-language=fr`)
                .then(response => response.json())
                .then(data => {
                    const address = [];
                    if (data.address.road) address.push(data.address.road);
                    if (data.address.house_number) address.push(data.address.house_number);
                    if (data.address.city || data.address.town || data.address.village) {
                        address.push(data.address.city || data.address.town || data.address.village);
                    }
                    locationInput.value = address.join(', ');
                })
                .catch(error => {
                    console.error('Error getting address:', error);
                    locationInput.value = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                });
        }
        
        // Confirm location button
        confirmLocation.addEventListener('click', function() {
            if (marker) {
                const position = marker.getLatLng();
                updateLocationInputs(position.lat, position.lng);
            }
            closeModal();
        });
        
        // Image preview functionality
        const imageInput = document.getElementById('images');
        const imagePreview = document.getElementById('image-preview');
        const selectedCount = document.getElementById('selected-count');
        const maxFiles = 5;
        const uploadArea = document.getElementById('upload-area');
        const dropArea = document.getElementById('drop-area');
        
        // Initialize with empty preview
        showNoImagesMessage();
        
        function updateImageCount(count) {
            if (selectedCount) {
                selectedCount.textContent = count;
                selectedCount.className = count > 0 ? 'font-medium text-blue-600' : 'text-gray-500';
            }
        }
        
        function showNoImagesMessage() {
            if (imagePreview && imagePreview.children.length === 0) {
                const emptyMessage = document.createElement('div');
                emptyMessage.className = 'col-span-full text-center py-8 text-gray-500';
                emptyMessage.innerHTML = `
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="mt-2 text-sm">Aucune image sélectionnée</p>
                    <p class="text-xs mt-1 text-gray-400">Glissez-déposez des images ici ou cliquez pour sélectionner</p>
                `;
                imagePreview.appendChild(emptyMessage);
            }
        }

        function createPreviewItem(file, index) {
            // Remove the "no images" message if it exists
            const noImagesMessage = imagePreview.querySelector('.col-span-full');
            if (noImagesMessage) {
                noImagesMessage.remove();
            }

            const reader = new FileReader();
            
            reader.onload = function(e) {
                const previewItem = document.createElement('div');
                previewItem.className = 'relative group';
                previewItem.innerHTML = `
                    <div class="relative h-32 bg-gray-100 rounded-md overflow-hidden shadow-sm border border-gray-200">
                        <img src="${e.target.result}" alt="Preview ${index + 1}" class="w-full h-full object-cover transition-opacity duration-300" style="opacity: 0">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-200 flex items-center justify-center">
                            <button type="button" class="bg-red-500 text-white rounded-full p-2 opacity-0 group-hover:opacity-100 transform group-hover:scale-110 transition-all duration-200 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2" data-index="${index}" title="Supprimer">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-2">
                            <p class="text-xs text-white truncate" title="${file.name}">${file.name}</p>
                            <p class="text-xs text-white/80">${(file.size / 1024).toFixed(1)} KB • ${file.type.split('/')[1].toUpperCase()}</p>
                        </div>
                    </div>
                `;
                
                // Add to preview container
                imagePreview.appendChild(previewItem);
                
                // Fade in the image after it's loaded
                const img = previewItem.querySelector('img');
                img.onload = function() {
                    img.style.opacity = '1';
                };
                
                // Add event listener to remove button
                const removeBtn = previewItem.querySelector('button');
                removeBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    removeImage(index);
                });
            };
            
            reader.onerror = function() {
                console.error('Error reading file:', file.name);
            };
            
            reader.readAsDataURL(file);
        }
        
        function removeImage(index) {
            // Create a new DataTransfer object and remove the file
            const dt = new DataTransfer();
            const { files } = imageInput;
            
            // Add all files except the one to be removed
            for (let i = 0; i < files.length; i++) {
                if (i !== index) dt.items.add(files[i]);
            }
            
            // Update file input
            imageInput.files = dt.files;
            
            // Update preview
            updatePreview();
        }
        
        function updatePreview() {
            // Clear previous previews
            imagePreview.innerHTML = '';
            
            if (!imageInput || !imageInput.files || imageInput.files.length === 0) {
                showNoImagesMessage();
                return;
            }
            
            // Process each file for preview
            const files = Array.from(imageInput.files).slice(0, maxFiles);
            let processedCount = 0;
            
            files.forEach((file, index) => {
                if (file.type.match('image.*')) {
                    createPreviewItem(file, index);
                    processedCount++;
                }
            });
            
            // Update counter
            updateImageCount(processedCount);
            
            // Show message if no valid images
            if (processedCount === 0) {
                showNoImagesMessage();
            }
        }
        
        // Handle file selection via input
        imageInput.addEventListener('change', function(e) {
            handleFiles(this.files);
        });
        
        // Handle click on upload area to trigger file input
        uploadArea.addEventListener('click', function(e) {
            // Only trigger file input if not clicking on a remove button
            if (!e.target.closest('button')) {
                imageInput.click();
            }
        });
        // Handle drag and drop for images
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });
        
        // Highlight drop area when item is dragged over it
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });
        
        // Handle dropped files
        dropArea.addEventListener('drop', handleDrop, false);
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        function highlight() {
            dropArea.classList.add('border-blue-500', 'bg-blue-50');
        }
        
        function unhighlight() {
            dropArea.classList.remove('border-blue-500', 'bg-blue-50');
        }
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files.length) {
                handleFiles(files);
            }
        }
        
        function handleFiles(files) {
            if (!files || files.length === 0) return;
            
            // Convert FileList to array and filter images
            const imageFiles = Array.from(files).filter(file => file.type.startsWith('image/'));
            
            if (imageFiles.length === 0) {
                alert('Veuillez sélectionner uniquement des fichiers image (JPG, PNG, GIF)');
                return;
            }
            
            // Update file input
            const dataTransfer = new DataTransfer();
            const currentFiles = Array.from(imageInput.files || []);
            const allFiles = [...currentFiles, ...imageFiles].slice(0, maxFiles);
            
            allFiles.forEach(file => dataTransfer.items.add(file));
            imageInput.files = dataTransfer.files;
            
            // Update preview
            updatePreview();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            dropArea.classList.add('border-blue-500', 'bg-blue-50');
        }
        
        function unhighlight() {
            dropArea.classList.remove('border-blue-500', 'bg-blue-50');
        }
        
        dropArea.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files.length) {
                // Convert FileList to array and set to input
                const input = imageInput;
                const newFiles = Array.from(files).filter(file => file.type.match('image.*'));
                
                // If there are existing files, combine them (up to 5 total)
                const existingFiles = Array.from(input.files);
                const allFiles = [...existingFiles, ...newFiles].slice(0, 5);
                
                const dataTransfer = new DataTransfer();
                allFiles.forEach(file => dataTransfer.items.add(file));
                
                input.files = dataTransfer.files;
                
                // Trigger change event to update preview
                const event = new Event('change');
                input.dispatchEvent(event);
            }
        }
    });

    // Multiple Media Upload with Preview
    const input = document.getElementById("mediaInput");
    const previewContainer = document.getElementById("mediaPreview");

    if (input && previewContainer) {
        // Initialize file counter on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateFileCounter(0);
        });

        input.addEventListener("change", function() {
            // Clear old previews
            while (previewContainer.firstChild) {
                previewContainer.removeChild(previewContainer.firstChild);
            }

            const files = this.files;
            if (!files || files.length === 0) {
                updateFileCounter(0);
                return;
            }

            // Process each selected file
            Array.from(files).forEach((file, index) => {
                const fileType = file.type.split('/')[0]; // image | video

                const previewItem = document.createElement("div");
                previewItem.className = "w-full h-32 md:h-40 rounded-lg overflow-hidden shadow border border-gray-200 relative group";
                previewItem.dataset.index = index;

                // Remove button
                const removeBtn = document.createElement("button");
                removeBtn.innerHTML = "<i class='fas fa-times'></i>";
                removeBtn.className = "absolute top-1 right-1 bg-black/70 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 hover:bg-red-500";
                removeBtn.type = "button";
                removeBtn.title = "Supprimer";
                removeBtn.addEventListener("click", (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    removeFile(file);
                    previewItem.remove();
                    updateFileCounter(input.files.length);
                });

                // File info overlay
                const fileInfo = document.createElement("div");
                fileInfo.className = "absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-2 text-white text-xs";
                fileInfo.innerHTML = `
                    <div class="truncate">${file.name}</div>
                    <div class="text-xs text-gray-300">${(file.size / 1024).toFixed(1)} KB</div>
                `;

                // Create preview based on file type
                if (fileType === "image") {
                    const img = document.createElement("img");
                    img.src = URL.createObjectURL(file);
                    img.className = "w-full h-full object-cover";
                    img.loading = "lazy";
                    previewItem.appendChild(img);
                } 
                else if (fileType === "video") {
                    const video = document.createElement("video");
                    video.src = URL.createObjectURL(file);
                    video.className = "w-full h-full object-cover";
                    video.controls = true;
                    previewItem.appendChild(video);
                }

                previewItem.appendChild(fileInfo);
                previewItem.appendChild(removeBtn);
                previewContainer.appendChild(previewItem);
            });

            updateFileCounter(files.length);
        });

        // Update the file counter display
        function updateFileCounter(count) {
            const counter = document.getElementById('fileCounter');
            if (!counter) return;
            
            counter.textContent = `${count} fichier(s) sélectionné(s)`;
            counter.className = `text-xs ${count > 0 ? 'text-pink-600 font-medium' : 'text-gray-500'}`;
        }

        // Remove selected file (must rebuild FileList)
        function removeFile(fileToRemove) {
            const dt = new DataTransfer();
            Array.from(input.files)
                .filter(file => file !== fileToRemove)
                .forEach(file => dt.items.add(file));
            
            input.files = dt.files;
        }
    }
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes fadeInOut {
        0% { opacity: 0; transform: translateY(10px); }
        10% { opacity: 1; transform: translateY(0); }
        90% { opacity: 1; transform: translateY(0); }
        100% { opacity: 0; transform: translateY(-10px); }
    }
    
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out forwards;
    }
    
    .animate-fade-in-out {
        animation: fadeInOut 2.3s ease-in-out forwards;
    }
    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #f472b6;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #ec4899;
    }
    .border-dashed {
        transition: all 0.2s ease-in-out;
    }
    .border-dashed:hover {
        border-color: #3b82f6;
    }
    #map {
        min-height: 400px;
    }
    .leaflet-popup-content-wrapper {
        border-radius: 0.5rem;
    }
    .leaflet-popup-content {
        margin: 0.75rem 1rem;
    }
</style>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\zerni\CascadeProjects\windsurf-project-8\SafeCity\resources\views/citizen/incidents/create.blade.php ENDPATH**/ ?>