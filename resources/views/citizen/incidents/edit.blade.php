@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-100 to-pink-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-gray-800">Modifier le signalement</h1>
            <p class="mt-2 text-gray-600">Mettez à jour les détails de votre signalement</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
            <form action="{{ route('citizen.incidents.update', $incident) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Titre -->
                    <div class="col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titre *</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $incident->title) }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Catégorie -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Catégorie *</label>
                        <select name="category_id" id="category_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $incident->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Localisation -->
                    <div class="col-span-2">
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Localisation *</label>
                        <input type="text" name="location" id="location" 
                            value="{{ old('location', $incident->location) }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            required>
                        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $incident->latitude) }}">
                        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $incident->longitude) }}">
                        <div id="map" class="mt-2 h-48 bg-gray-100 rounded-lg"></div>
                        @error('location')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                        <textarea name="description" id="description" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            required>{{ old('description', $incident->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Images existantes -->
                    @if($incident->images->isNotEmpty())
                        <div class="col-span-2">
                            <p class="text-sm font-medium text-gray-700 mb-2">Images actuelles</p>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($incident->images as $image)
                                    <div class="relative group">
                                        <img src="{{ asset('storage/' . $image->path) }}" 
                                            alt="Image {{ $loop->iteration }}" 
                                            class="w-full h-32 object-cover rounded-lg">
                                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                            <label class="cursor-pointer">
                                                <input type="checkbox" name="deleted_images[]" value="{{ $image->id }}" class="hidden" id="delete-image-{{ $image->id }}">
                                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-medium">Supprimer</span>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Nouvelles images -->
                    <div class="col-span-2">
                        <label for="images" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ $incident->images->isNotEmpty() ? 'Ajouter d\'autres images' : 'Images (max 5)' }}
                        </label>
                        <input type="file" name="images[]" id="images" multiple 
                            accept="image/*" 
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                        <p class="mt-1 text-xs text-gray-500">Formats acceptés : JPG, PNG, GIF. Taille max : 5MB par image.</p>
                        @error('images.*')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                    <a href="{{ route('citizen.incidents.show', $incident) }}" 
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        Annuler
                    </a>
                    <button type="submit" 
                        class="px-6 py-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Initialisation de la carte pour la sélection de l'emplacement
    function initMap() {
        const map = new google.maps.Map(document.getElementById("map"), {
            center: { 
                lat: {{ $incident->latitude ?? 36.7538 }}, 
                lng: {{ $incident->longitude ?? 3.0588 }}
            },
            zoom: 15,
        });

        let marker = new google.maps.Marker({
            position: { 
                lat: {{ $incident->latitude ?? 36.7538 }}, 
                lng: {{ $incident->longitude ?? 3.0588 }}
            },
            map: map,
            draggable: true
        });

        const geocoder = new google.maps.Geocoder();
        const locationInput = document.getElementById('location');
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');

        // Mettre à jour la position du marqueur lors du déplacement
        marker.addListener('dragend', function() {
            const position = marker.getPosition();
            updateLocationInputs(position.lat(), position.lng());
            geocodeLatLng(geocoder, map, position.lat(), position.lng());
        });

        // Recherche d'adresse lors de la saisie
        let autocomplete = new google.maps.places.Autocomplete(locationInput);
        autocomplete.addListener('place_changed', function() {
            const place = autocomplete.getPlace();
            if (!place.geometry) {
                return;
            }
            
            const lat = place.geometry.location.lat();
            const lng = place.geometry.location.lng();
            
            updateLocationInputs(lat, lng);
            
            // Mettre à jour le marqueur
            const newPosition = new google.maps.LatLng(lat, lng);
            marker.setPosition(newPosition);
            map.setCenter(newPosition);
        });

        function updateLocationInputs(lat, lng) {
            latitudeInput.value = lat;
            longitudeInput.value = lng;
        }

        function geocodeLatLng(geocoder, map, lat, lng) {
            const latlng = { lat: lat, lng: lng };
            geocoder.geocode({ location: latlng })
                .then((response) => {
                    if (response.results[0]) {
                        locationInput.value = response.results[0].formatted_address;
                    }
                });
        }
    }

    // Gestion de la suppression des images
    document.querySelectorAll('input[type="checkbox"][name^="deleted_images"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const imageContainer = this.closest('.relative');
            if (this.checked) {
                imageContainer.style.opacity = '0.5';
                imageContainer.style.border = '2px solid red';
            } else {
                imageContainer.style.opacity = '1';
                imageContainer.style.border = 'none';
            }
        });
    });
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places&callback=initMap">
</script>
@endpush

<style>
    .pac-container {
        z-index: 1100 !important;
    }
</style>
@endsection
