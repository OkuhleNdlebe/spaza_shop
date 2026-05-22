@extends('layouts.app')

@section('title', 'Edit Store')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary mb-0">Edit Store</h1>
        <a href="{{ route('stores.show', $store) }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Store
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('stores.update', $store) }}" method="POST" id="storeForm">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Store Name *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $store->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="owner_name" class="form-label">Owner Name *</label>
                            <input type="text" name="owner_name" class="form-control @error('owner_name') is-invalid @enderror" 
                                   value="{{ old('owner_name', $store->owner_name) }}" required>
                            @error('owner_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="contact_number" class="form-label">Contact Number *</label>
                            <input type="text" name="contact_number" class="form-control @error('contact_number') is-invalid @enderror" 
                                   value="{{ old('contact_number', $store->contact_number) }}" required>
                            @error('contact_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="low_stock_threshold" class="form-label">Low Stock Alert Threshold</label>
                            <input type="number" name="low_stock_threshold" class="form-control @error('low_stock_threshold') is-invalid @enderror" 
                                   value="{{ old('low_stock_threshold', $store->low_stock_threshold ?? 5) }}" min="1">
                            <div class="form-text">Get alerted when product quantity falls below this number</div>
                            @error('low_stock_threshold')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Street Address</label>
                    <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" 
                           value="{{ old('address', $store->address) }}" placeholder="e.g., 123 Main Street">
                    <div class="form-text">Enter street address, then click "Search Location" button to find on map</div>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="city" class="form-label">City/Suburb</label>
                            <input type="text" name="city" id="city" class="form-control @error('city') is-invalid @enderror" 
                                   value="{{ old('city', $store->city) }}">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="postal_code" class="form-label">Postal Code</label>
                            <input type="text" name="postal_code" id="postal_code" class="form-control @error('postal_code') is-invalid @enderror" 
                                   value="{{ old('postal_code', $store->postal_code) }}">
                            @error('postal_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Area/Landmark *</label>
                    <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" 
                           value="{{ old('location', $store->location) }}" required>
                    <div class="form-text">e.g., "CBD", "Township Name", or nearby landmark</div>
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <button type="button" id="searchLocationBtn" class="btn btn-info">
                        <i class="bi bi-search"></i> Search Location on Map
                    </button>
                    <button type="button" id="getCurrentLocationBtn" class="btn btn-success">
                        <i class="bi bi-geo-alt"></i> Use My Current Location
                    </button>
                </div>

                <!-- Leaflet Map -->
                <div class="mb-3">
                    <label class="form-label">Location Map (Click on map to set precise location)</label>
                    <div id="map" style="height: 400px; border-radius: 8px;"></div>
                    <div class="form-text mt-2">
                        <i class="bi bi-info-circle"></i> 
                        Click anywhere on the map to set the exact store location. You can also drag the marker.
                    </div>
                </div>

                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $store->latitude) }}">
                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $store->longitude) }}">

                <!-- Current Location Display -->
                @if($store->latitude && $store->longitude)
                <div class="alert alert-info mb-3">
                    <i class="bi bi-geo-alt-fill"></i>
                    <strong>Current Location:</strong> 
                    Latitude: {{ $store->latitude }}, Longitude: {{ $store->longitude }}
                </div>
                @endif

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('stores.show', $store) }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Update Store
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Leaflet CSS and JavaScript -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
let map, marker;
let currentLat = {{ $store->latitude ?? '-33.9249' }};
let currentLng = {{ $store->longitude ?? '18.4241' }};

// Initialize map
function initMap() {
    const centerLat = currentLat;
    const centerLng = currentLng;
    
    map = L.map('map').setView([centerLat, centerLng], 15);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);
    
    // Initialize marker (draggable)
    marker = L.marker([centerLat, centerLng], { draggable: true }).addTo(map);
    
    // Update coordinates when marker is dragged
    marker.on('dragend', function(e) {
        const position = marker.getLatLng();
        updateCoordinates(position.lat, position.lng);
        
        // Reverse geocode to get address
        reverseGeocode(position.lat, position.lng);
    });
    
    // Click on map to set location
    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        updateCoordinates(e.latlng.lat, e.latlng.lng);
        
        // Reverse geocode to get address
        reverseGeocode(e.latlng.lat, e.latlng.lng);
    });
}

// Update hidden fields with coordinates
function updateCoordinates(lat, lng) {
    document.getElementById('latitude').value = lat.toFixed(8);
    document.getElementById('longitude').value = lng.toFixed(8);
}

// Reverse geocoding to get address from coordinates
async function reverseGeocode(lat, lng) {
    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&addressdetails=1`);
        const data = await response.json();
        
        if (data.display_name) {
            // Update address fields
            if (data.address.road || data.address.building) {
                const streetNumber = data.address.building || data.address.house_number || '';
                const street = data.address.road || data.address.pedestrian || '';
                const streetAddress = [streetNumber, street].filter(Boolean).join(' ');
                if (streetAddress) {
                    document.getElementById('address').value = streetAddress;
                }
            }
            
            if (data.address.city) document.getElementById('city').value = data.address.city;
            if (data.address.town) document.getElementById('city').value = data.address.town;
            if (data.address.suburb) document.getElementById('city').value = data.address.suburb;
            if (data.address.postcode) document.getElementById('postal_code').value = data.address.postcode;
        }
    } catch (error) {
        console.error('Reverse geocoding error:', error);
    }
}

// Search location by address
async function searchLocation() {
    const address = document.getElementById('address').value;
    const city = document.getElementById('city').value;
    const postalCode = document.getElementById('postal_code').value;
    
    let searchQuery = address;
    if (city) searchQuery += ', ' + city;
    if (postalCode) searchQuery += ' ' + postalCode;
    searchQuery += ', South Africa';
    
    if (!searchQuery.trim() || searchQuery === ', South Africa') {
        alert('Please enter an address to search');
        return;
    }
    
    // Show loading indicator
    const searchBtn = document.getElementById('searchLocationBtn');
    const originalText = searchBtn.innerHTML;
    searchBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Searching...';
    searchBtn.disabled = true;
    
    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(searchQuery)}&limit=1`);
        const data = await response.json();
        
        if (data && data.length > 0) {
            const lat = parseFloat(data[0].lat);
            const lon = parseFloat(data[0].lon);
            
            map.setView([lat, lon], 16);
            marker.setLatLng([lat, lon]);
            updateCoordinates(lat, lon);
            
            // If we got a full address back, use it
            if (data[0].display_name) {
                const parts = data[0].display_name.split(',');
                if (parts[0]) document.getElementById('address').value = parts[0];
            }
            
            // Extract city and postal code from response
            if (data[0].address) {
                if (data[0].address.city) document.getElementById('city').value = data[0].address.city;
                if (data[0].address.town) document.getElementById('city').value = data[0].address.town;
                if (data[0].address.suburb) document.getElementById('city').value = data[0].address.suburb;
                if (data[0].address.postcode) document.getElementById('postal_code').value = data[0].address.postcode;
            }
        } else {
            alert('Location not found. Please try a different address or be more specific.');
        }
    } catch (error) {
        console.error('Search error:', error);
        alert('Error searching location. Please try again.');
    } finally {
        searchBtn.innerHTML = originalText;
        searchBtn.disabled = false;
    }
}

// Get user's current location
function getCurrentLocation() {
    if (!navigator.geolocation) {
        alert('Geolocation is not supported by your browser');
        return;
    }
    
    const locationBtn = document.getElementById('getCurrentLocationBtn');
    const originalText = locationBtn.innerHTML;
    locationBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Getting location...';
    locationBtn.disabled = true;
    
    navigator.geolocation.getCurrentPosition(
        function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            
            map.setView([lat, lng], 16);
            marker.setLatLng([lat, lng]);
            updateCoordinates(lat, lng);
            reverseGeocode(lat, lng);
            
            locationBtn.innerHTML = originalText;
            locationBtn.disabled = false;
            
            // Show success message
            const successMsg = document.createElement('div');
            successMsg.className = 'alert alert-success alert-dismissible fade show mt-3';
            successMsg.innerHTML = `
                <i class="bi bi-check-circle"></i> Location updated to your current position!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.querySelector('.card-body').insertBefore(successMsg, document.querySelector('#map').nextSibling);
            
            setTimeout(() => successMsg.remove(), 3000);
        },
        function(error) {
            let errorMessage = 'Unable to get your location. ';
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    errorMessage += 'Please allow location access.';
                    break;
                case error.POSITION_UNAVAILABLE:
                    errorMessage += 'Location information unavailable.';
                    break;
                case error.TIMEOUT:
                    errorMessage += 'Location request timed out.';
                    break;
                default:
                    errorMessage += 'An error occurred.';
            }
            alert(errorMessage);
            locationBtn.innerHTML = originalText;
            locationBtn.disabled = false;
        }
    );
}

// Event listeners
document.getElementById('searchLocationBtn').addEventListener('click', searchLocation);
document.getElementById('getCurrentLocationBtn').addEventListener('click', getCurrentLocation);

// Initialize map when page loads
document.addEventListener('DOMContentLoaded', function() {
    initMap();
    
    // If coordinates are already set, show them
    if (currentLat && currentLng && currentLat !== '-33.9249') {
        updateCoordinates(currentLat, currentLng);
    }
});
</script>

<style>
.leaflet-container {
    z-index: 1;
}
.btn-group {
    gap: 10px;
}
#map {
    cursor: crosshair;
}
</style>
@endsection