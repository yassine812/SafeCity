<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
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
                <a href="{{ route('citizen.dashboard') }}" class="flex items-center px-4 py-3 text-pink-100 hover:bg-pink-900/30 rounded-lg transition-all duration-200 group">
                    <div class="w-6 h-6 flex items-center justify-center mr-3 rounded-full bg-pink-900/30 group-hover:bg-pink-500/30 transition-colors">
                        <i class="fas fa-home text-pink-300 text-sm"></i>
                    </div>
                    <span class="font-medium">Tableau de bord</span>
                </a>
                
                <a href="{{ route('citizen.incidents.index') }}" class="flex items-center px-4 py-3 text-pink-100 hover:bg-pink-900/30 rounded-lg transition-all duration-200 group">
                    <div class="w-6 h-6 flex items-center justify-center mr-3 rounded-full bg-pink-900/30 group-hover:bg-pink-500/30 transition-colors">
                        <i class="fas fa-exclamation-triangle text-pink-300 text-sm"></i>
                    </div>
                    <span class="font-medium">Mes signalements</span>
                </a>
                
                <a href="{{ route('citizen.incidents.create') }}" class="flex items-center px-4 py-3 bg-gradient-to-r from-pink-500/20 to-pink-600/30 text-white rounded-lg border-l-4 border-pink-400 shadow-md">
                    <div class="w-6 h-6 flex items-center justify-center mr-3 rounded-full bg-pink-400/30">
                        <i class="fas fa-plus-circle text-pink-100 text-sm"></i>
                    </div>
                    <span class="font-semibold text-white">Nouveau signalement</span>
                    <span class="ml-auto w-2 h-2 bg-pink-400 rounded-full animate-pulse"></span>
                </a>
                
                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-pink-100 hover:bg-pink-900/30 rounded-lg transition-all duration-200 group">
                    <div class="w-6 h-6 flex items-center justify-center mr-3 rounded-full bg-pink-900/30 group-hover:bg-pink-500/30 transition-colors">
                        <i class="fas fa-user text-pink-300 text-sm"></i>
                    </div>
                    <span class="font-medium">Mon Profil</span>
                </a>
                
                <div class="pt-4 mt-4 border-t border-pink-900/30">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
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
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
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

            <form action="{{ route('citizen.incidents.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf

                @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-700 rounded">
                    <b>Une erreur est survenue :</b>
                    <ul class="mt-2 list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="space-y-6 p-6">
                    <!-- Category -->
                    <div class="space-y-2">
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Catégorie <span class="text-pink-500">*</span></label>
                        <select name="category_id" id="category_id" required 
                                class="block w-full pl-4 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 shadow-sm">
                            <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Sélectionnez une catégorie</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-pink-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Titre -->
                    <div class="space-y-2">
                        <label for="title" class="block text-sm font-medium text-gray-700">Titre <span class="text-pink-500">*</span></label>
                        <div class="relative">
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required 
                                class="block w-full pl-4 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 shadow-sm" 
                                placeholder="Décrivez brièvement le problème">
                        </div>
                        @error('title')
                            <p class="mt-1 text-sm text-pink-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- Description -->
                    <div class="space-y-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description détaillée <span class="text-pink-500">*</span></label>
                        <div class="mt-1">
                            <textarea id="description" name="description" rows="4" required 
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 shadow-sm">{{ old('description') }}</textarea>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Décrivez le problème en détail. Soyez aussi précis que possible.</p>
                        @error('description')
                            <p class="mt-1 text-sm text-pink-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ville -->
                    <div class="space-y-2">
                        <label for="city" class="block text-sm font-medium text-gray-700">Ville <span class="text-pink-500">*</span></label>
                        <select name="city" id="city" required 
                            class="block w-full pl-4 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 shadow-sm">
                            <option value="" disabled {{ old('city') ? '' : 'selected' }}>Sélectionnez une ville</option>
                            <option value="Ariana" {{ old('city') == 'Ariana' ? 'selected' : '' }}>Ariana</option>
                            <option value="Béja" {{ old('city') == 'Béja' ? 'selected' : '' }}>Béja</option>
                            <option value="Ben Arous" {{ old('city') == 'Ben Arous' ? 'selected' : '' }}>Ben Arous</option>
                            <option value="Bizerte" {{ old('city') == 'Bizerte' ? 'selected' : '' }}>Bizerte</option>
                            <option value="Gabès" {{ old('city') == 'Gabès' ? 'selected' : '' }}>Gabès</option>
                            <option value="Gafsa" {{ old('city') == 'Gafsa' ? 'selected' : '' }}>Gafsa</option>
                            <option value="Jendouba" {{ old('city') == 'Jendouba' ? 'selected' : '' }}>Jendouba</option>
                            <option value="Kairouan" {{ old('city') == 'Kairouan' ? 'selected' : '' }}>Kairouan</option>
                            <option value="Kasserine" {{ old('city') == 'Kasserine' ? 'selected' : '' }}>Kasserine</option>
                            <option value="Kébili" {{ old('city') == 'Kébili' ? 'selected' : '' }}>Kébili</option>
                            <option value="Le Kef" {{ old('city') == 'Le Kef' ? 'selected' : '' }}>Le Kef</option>
                            <option value="Mahdia" {{ old('city') == 'Mahdia' ? 'selected' : '' }}>Mahdia</option>
                            <option value="Manouba" {{ old('city') == 'Manouba' ? 'selected' : '' }}>Manouba</option>
                            <option value="Médenine" {{ old('city') == 'Médenine' ? 'selected' : '' }}>Médenine</option>
                            <option value="Monastir" {{ old('city') == 'Monastir' ? 'selected' : '' }}>Monastir</option>
                            <option value="Nabeul" {{ old('city') == 'Nabeul' ? 'selected' : '' }}>Nabeul</option>
                            <option value="Sfax" {{ old('city') == 'Sfax' ? 'selected' : '' }}>Sfax</option>
                            <option value="Sidi Bouzid" {{ old('city') == 'Sidi Bouzid' ? 'selected' : '' }}>Sidi Bouzid</option>
                            <option value="Siliana" {{ old('city') == 'Siliana' ? 'selected' : '' }}>Siliana</option>
                            <option value="Sousse" {{ old('city') == 'Sousse' ? 'selected' : '' }}>Sousse</option>
                            <option value="Tataouine" {{ old('city') == 'Tataouine' ? 'selected' : '' }}>Tataouine</option>
                            <option value="Tozeur" {{ old('city') == 'Tozeur' ? 'selected' : '' }}>Tozeur</option>
                            <option value="Tunis" {{ old('city') == 'Tunis' ? 'selected' : '' }}>Tunis</option>
                            <option value="Zaghouan" {{ old('city') == 'Zaghouan' ? 'selected' : '' }}>Zaghouan</option>
                        </select>
                        @error('city')
                            <p class="mt-1 text-sm text-pink-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Adresse -->
                    <div class="space-y-2">
                        <label for="address_line1" class="block text-sm font-medium text-gray-700">Adresse <span class="text-pink-500">*</span></label>
                        <input type="text" name="address_line1" id="address_line1" value="{{ old('address_line1') }}" required 
                            class="block w-full pl-4 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 shadow-sm" 
                            placeholder="Adresse complète">
                        @error('address_line1')
                            <p class="mt-1 text-sm text-pink-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Code postal -->
                    <div class="space-y-2">
                        <label for="postal_code" class="block text-sm font-medium text-gray-700">Code postal <span class="text-pink-500">*</span></label>
                        <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" required 
                            class="block w-full pl-4 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 shadow-sm" 
                            placeholder="Code postal">
                        @error('postal_code')
                            <p class="mt-1 text-sm text-pink-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Hidden country field with default value -->
                    <input type="hidden" name="country" value="Tunisia">

                    <!-- File Upload Dropzone -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Photos / Vidéos de l'incident (max 5)
                        </label>

                        <input 
                            id="mediaInput"
                            type="file"
                            name="media[]"
                            accept="image/*,video/*"
                            multiple
                            class="hidden"
                        />

                        <div id="dropzone" class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-pink-400 transition-colors duration-200"
                             onclick="document.getElementById('mediaInput').click()">
                            <div class="space-y-2">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400"></i>
                                <p class="text-sm text-gray-600">Glissez-déposez vos fichiers ici ou cliquez pour sélectionner</p>
                                <p class="text-xs text-gray-500">Formats acceptés : JPG, PNG, GIF, MP4 (max 5 fichiers)</p>
                            </div>
                        </div>

                        @error('media')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                        @error('media.*')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror

                        <div id="mediaPreview" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mt-4"></div>
                    </div>
                </div>

                <div class="mt-8 pt-5 border-t border-gray-100">
                    <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                        <a href="{{ route('citizen.dashboard') }}" class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-colors duration-200">
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
        const selectedLocationText = document.getElementById('selectedLocationText');

        let map, marker;

        if (mapModal && openMapModal && closeMapModal && cancelLocation && confirmLocation && selectedLocationText && locationInput && latitudeInput && longitudeInput) {
            // Function to update location inputs and text
            function updateLocationDisplay(lat, lng, address) {
                latitudeInput.value = lat.toFixed(6);
                longitudeInput.value = lng.toFixed(6);
                locationInput.value = address;
                selectedLocationText.innerText = address;
            }

            openMapModal.addEventListener('click', function() {
                mapModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                if (!map) {
                    initMap();
                } else {
                    map.invalidateSize();
                }
            });

            function closeModal() {
                mapModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }

            closeMapModal.addEventListener('click', closeModal);
            cancelLocation.addEventListener('click', closeModal);

            function initMap() {
            const defaultLat = 33.5731;
            const defaultLng = -7.5898;
            const initialLat = latitudeInput.value && latitudeInput.value !== '0' ? parseFloat(latitudeInput.value) : defaultLat;
            const initialLng = longitudeInput.value && longitudeInput.value !== '0' ? parseFloat(longitudeInput.value) : defaultLng;

            map = L.map('map').setView([initialLat, initialLng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            marker = L.marker([initialLat, initialLng], {
                draggable: true
            }).addTo(map);

            marker.on('dragend', function(e) {
                const position = marker.getLatLng();
                reverseGeocode(position.lat, position.lng);
            });

            map.on('click', function(e) {
                if (marker) {
                    marker.setLatLng(e.latlng);
                } else {
                    marker = L.marker(e.latlng, {
                        draggable: true
                    }).addTo(map);
                }
                reverseGeocode(e.latlng.lat, e.latlng.lng);
            });
        }

            function reverseGeocode(lat, lng) {
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&accept-language=fr`)
                .then(response => response.json())
                .then(data => {
                    const address = data.display_name || `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                    updateLocationDisplay(lat, lng, address);
                })
                .catch(error => {
                    console.error('Error getting address:', error);
                    const address = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                    updateLocationDisplay(lat, lng, address);
                });
        }

            confirmLocation.addEventListener('click', function() {
            if (marker) {
                const position = marker.getLatLng();
                reverseGeocode(position.lat, position.lng);
                document.getElementById('locationStatus').textContent = 'Localisation mise à jour';
            } else {
                // If no marker is placed, use the center of the map
                const center = map.getCenter();
                reverseGeocode(center.lat, center.lng);
                document.getElementById('locationStatus').textContent = 'Localisation mise à jour';
            }
            closeModal();
        });
        }

        // Media Upload with Preview
        const mediaInput = document.getElementById("mediaInput");
        const mediaPreview = document.getElementById("mediaPreview");
        const fileCounter = document.getElementById("fileCounter");
        const dropzone = document.getElementById("dropzone");

        if (dropzone) {
            dropzone.addEventListener('dragover', handleDragOver);
            dropzone.addEventListener('dragleave', handleDragLeave);
            dropzone.addEventListener('drop', handleDrop);
        }

        // Restore files from localStorage on page load
        document.addEventListener('DOMContentLoaded', () => {
            const savedFiles = localStorage.getItem('savedFiles');
            if (savedFiles) {
                try {
                    const files = JSON.parse(savedFiles);
                    if (files && files.length > 0) {
                        const dataTransfer = new DataTransfer();
                        
                        // Create a mock FileList using DataTransfer
                        files.forEach(fileInfo => {
                            const file = new File(
                                [fileInfo.data],
                                fileInfo.name,
                                { type: fileInfo.type }
                            );
                            dataTransfer.items.add(file);
                        });
                        
                        mediaInput.files = dataTransfer.files;
                        updateMediaPreview();
                    }
                } catch (e) {
                    console.error('Error restoring files:', e);
                    localStorage.removeItem('savedFiles');
                }
            }
        });

        mediaInput.addEventListener("change", () => {
            updateMediaPreview();
        });

        // Handle drag over
        function handleDragOver(e) {
            e.preventDefault();
            e.stopPropagation();
            e.target.classList.add('border-pink-500', 'bg-pink-50');
        }

        // Handle drag leave
        function handleDragLeave(e) {
            e.preventDefault();
            e.stopPropagation();
            e.target.classList.remove('border-pink-500', 'bg-pink-50');
        }

        // Handle file drop
        function handleDrop(e) {
            e.preventDefault();
            e.stopPropagation();
            e.target.classList.remove('border-pink-500', 'bg-pink-50');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleFiles(files);
                // Update the file input with the dropped files
                updateFileInput(files);
            }
        }

        // Handle file selection
        mediaInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                handleFiles(this.files);
                // Update the file input with the new files
                updateFileInput(this.files);
            }
        });
        
        // Function to update the file input with selected files
        function updateFileInput(files) {
            const dataTransfer = new DataTransfer();
            Array.from(files).forEach(file => {
                dataTransfer.items.add(file);
            });
            mediaInput.files = dataTransfer.files;
        }

        // Save files to localStorage
        function saveFilesToStorage() {
            const files = Array.from(mediaInput.files || []);
            const filesToSave = [];
            
            // Convert files to base64 for storage
            const filePromises = files.map(file => {
                return new Promise((resolve) => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        filesToSave.push({
                            name: file.name,
                            type: file.type,
                            size: file.size,
                            data: e.target.result.split(',')[1] // Remove data URL prefix
                        });
                        resolve();
                    };
                    reader.readAsDataURL(file);
                });
            });
            
            Promise.all(filePromises).then(() => {
                localStorage.setItem('savedFiles', JSON.stringify(filesToSave));
            });
        }
        
        // Process selected files
        function handleFiles(files) {
            const MAX_FILES = 5;
            const validFiles = [];
            const invalidFiles = [];
            
            // Get existing files
            const existingFiles = Array.from(mediaInput.files || []);
            
            // Check total file count
            if (existingFiles.length + files.length > MAX_FILES) {
                alert(`Vous ne pouvez téléverser que ${MAX_FILES} fichiers au maximum.`);
                return;
            }
            
            // Process each file
            Array.from(files).forEach(file => {
                const fileType = file.type.split('/')[0];
                const validTypes = ['image', 'video'];
                
                if (validTypes.includes(fileType) && file.size <= 20 * 1024 * 1024) { // 20MB max
                    // Check for duplicate files
                    const isDuplicate = existingFiles.some(
                        existingFile => existingFile.name === file.name && existingFile.size === file.size
                    );
                    
                    if (!isDuplicate) {
                        validFiles.push(file);
                    }
                } else {
                    invalidFiles.push(file.name);
                }
            });
            
            // Show error for invalid files
            if (invalidFiles.length > 0) {
                alert(`Les fichiers suivants n'ont pas été acceptés :\n${invalidFiles.join('\n')}\n\nAssurez-vous que les fichiers sont des images ou des vidéos et ne dépassent pas 20Mo.`);
            }
            
            // Check total file count
            const currentFiles = mediaInput.files ? Array.from(mediaInput.files) : [];
            const totalFiles = currentFiles.length + validFiles.length;
            
            if (totalFiles > MAX_FILES) {
                invalidFiles.push(`Vous ne pouvez pas sélectionner plus de ${MAX_FILES} fichiers au total`);
            } else {
                // Add valid files to the input
                const dt = new DataTransfer();
                
                // Add existing files
                currentFiles.forEach(file => dt.items.add(file));
                
                // Add new valid files (up to the limit)
                const remainingSlots = MAX_FILES - currentFiles.length;
                validFiles.slice(0, remainingSlots).forEach(file => dt.items.add(file));
                
                mediaInput.files = dt.files;
            }
            
            // Show error messages if any
            if (invalidFiles.length > 0) {
                showFileErrors(invalidFiles);
            }
            
            // Update preview and save to storage
            updateMediaPreview();
            saveFilesToStorage();
        }
        
        // Show file validation errors
        function showFileErrors(errors) {
            const errorHtml = errors.map(error => 
                `<div class="p-3 mb-2 bg-red-50 text-red-700 text-sm rounded-lg flex items-start">
                    <i class="fas fa-exclamation-circle mt-0.5 mr-2"></i>
                    <span>${error}</span>
                </div>`
            ).join('');
            
            // Remove any existing error messages
            const existingErrors = document.querySelectorAll('.file-upload-error');
            existingErrors.forEach(el => el.remove());
            
            // Add new error messages
            if (errors.length > 0) {
                const errorContainer = document.createElement('div');
                errorContainer.className = 'file-upload-error mt-3';
                errorContainer.innerHTML = errorHtml;
                document.querySelector('#dropzone').after(errorContainer);
            }
        }

        // Update media preview
        function updateMediaPreview() {
            mediaPreview.innerHTML = "";
            const files = Array.from(mediaInput.files || []);
            
            if (files.length === 0) {
                // Check if we have saved files in localStorage
                const savedFiles = localStorage.getItem('savedFiles');
                if (savedFiles) {
                    try {
                        const parsedFiles = JSON.parse(savedFiles);
                        if (parsedFiles && parsedFiles.length > 0) {
                            // If we have saved files but no files in the input,
                            // it means the page was just loaded and we need to restore the preview
                            const dataTransfer = new DataTransfer();
                            parsedFiles.forEach(fileInfo => {
                                const file = new File(
                                    [fileInfo.data],
                                    fileInfo.name,
                                    { type: fileInfo.type }
                                );
                                dataTransfer.items.add(file);
                            });
                            mediaInput.files = dataTransfer.files;
                            files.push(...Array.from(dataTransfer.files));
                        }
                    } catch (e) {
                        console.error('Error restoring files:', e);
                        localStorage.removeItem('savedFiles');
                    }
                }
                
                if (files.length === 0) {
                    return;
                }
            }

            files.forEach((file, index) => {
                const previewItem = document.createElement("div");
                previewItem.className = "relative group rounded-lg overflow-hidden border-2 border-gray-200 hover:border-pink-300 hover:shadow-lg transition-all duration-200 transform hover:-translate-y-1";
                
                // Remove button
                const removeBtn = document.createElement("button");
                removeBtn.innerHTML = "<i class='fas fa-times text-sm'></i>";
                removeBtn.className = "absolute top-2 right-2 bg-black/80 hover:bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center transition-all duration-200 transform hover:scale-110 shadow-md";
                removeBtn.type = "button";
                removeBtn.title = "Supprimer";
                removeBtn.addEventListener("click", (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    removeFile(index);
                });

                // File info
                const fileInfo = document.createElement("div");
                fileInfo.className = "absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/90 via-black/70 to-transparent p-2 text-white text-xs";
                fileInfo.innerHTML = `
                    <div class="truncate">${file.name}</div>
                    <div class="flex justify-between items-center text-xs text-gray-300 mt-1">
                        <span>${(file.size / 1024).toFixed(1)} KB</span>
                        <span class="text-xs px-2 py-0.5 bg-black/30 rounded">${file.type.split('/')[1]?.toUpperCase() || 'FILE'}</span>
                    </div>`;

                // Media preview
                if (file.type.startsWith("image/")) {
                    const img = document.createElement("img");
                    img.src = URL.createObjectURL(file);
                    img.className = "w-full h-32 md:h-40 object-cover";
                    img.loading = "lazy";
                    previewItem.appendChild(img);
                } else if (file.type.startsWith("video/")) {
                    const videoContainer = document.createElement("div");
                    videoContainer.className = "relative w-full h-32 md:h-40 bg-black";
                    
                    const video = document.createElement("video");
                    video.src = URL.createObjectURL(file);
                    video.className = "w-full h-full object-contain";
                    video.controls = false;
                    
                    const playButton = document.createElement("div");
                    playButton.className = "absolute inset-0 flex items-center justify-center text-white text-3xl opacity-70 hover:opacity-100";
                    playButton.innerHTML = "<i class='fas fa-play-circle'></i>";
                    playButton.onclick = (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        video.controls = !video.controls;
                    };
                    
                    videoContainer.appendChild(video);
                    videoContainer.appendChild(playButton);
                    previewItem.appendChild(videoContainer);
                }

                previewItem.appendChild(fileInfo);
                previewItem.appendChild(removeBtn);
                mediaPreview.appendChild(previewItem);
            });
        }

        // Remove file at index
        function removeFile(indexToRemove) {
            const dt = new DataTransfer();
            const files = Array.from(mediaInput.files);
            
            files.forEach((file, index) => {
                if (index !== indexToRemove) {
                    dt.items.add(file);
                }
            });
            
            mediaInput.files = dt.files;
            updateMediaPreview();
            saveFilesToStorage();
            
            // Remove any error messages when all files are removed
            if (dt.files.length === 0) {
                const existingErrors = document.querySelectorAll('.file-upload-error');
                existingErrors.forEach(el => el.remove());
                localStorage.removeItem('savedFiles');
            }
        }
    });
</script>

@push('styles')
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
@endpush
