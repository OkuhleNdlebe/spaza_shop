@extends('layouts.app')

@section('title', 'Add New Store')

@section('content')
<div class="container mt-4">
    <h1 class="text-primary text-center">Add a New Spaza Store</h1>

    <div class="card shadow-sm mt-3">
        <div class="card-body">
            <form action="{{ route('stores.store') }}" method="POST" id="storeForm">
                @csrf
                
                <div class="mb-3">
                    <label for="name" class="form-label">Store Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label for="owner_name" class="form-label">Owner Name</label>
                    <input type="text" name="owner_name" class="form-control" value="{{ old('owner_name') }}" required>
                </div>

                <div class="mb-3">
                    <label for="contact_number" class="form-label">Contact Number</label>
                    <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number') }}" required>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Street Address</label>
                    <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}" placeholder="e.g., 123 Main Street">
                    <div class="form-text">Enter street address, then click "Search Location" button</div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="city" class="form-label">City/Suburb</label>
                            <input type="text" name="city" id="city" class="form-control" value="{{ old('city') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="postal_code" class="form-label">Postal Code</label>
                            <input type="text" name="postal_code" id="postal_code" class="form-control" value="{{ old('postal_code') }}">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Area/Landmark</label>
                    <input type="text" name="location" class="form-control" value="{{ old('location') }}" required>
                    <div class="form-text">e.g., "CBD", "Township Name", or nearby landmark</div>
                </div>

                <div class="mb-3">
                    <label for="low_stock_threshold" class="form-label">Low Stock Alert Threshold</label>
                    <input type="number" name="low_stock_threshold" class="form-control" value="{{ old('low_stock_threshold', 5) }}" min="1">
                </div>

                <div class="mb-3">
                    <button type="button" id="searchLocationBtn" class="btn btn-info">
                        <i class="bi bi-search"></i> Search Location
                    </button>
                </div>

                <!-- Leaflet Map -->
                <div class="mb-3">
                    <label>Location Map (Click to set precise location)</label>
                    <div id="map" style="height: 400px; border-radius: 8px;"></div>
                    <div class="form-text">Click on map to set exact store location</div>
                </div>

                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">

                <button type="submit" class="btn btn-success">Save Store</button>
                <a href="{{ route('stores.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Leaflet CSS and JavaScript -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

<script>
let map, marker;

// Initialize map
map = L.map('map').setView([-33.9249, 18.4241], 13); // Cape Town coordinates

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// Initialize marker
marker = L.marker([-33.9249, 18.4241], { draggable: true }).addTo(map);

// Update coordinates when marker is dragged
marker.on('dragend', function(e) {
    const position = marker.getLatLng();
    document.getElementById('latitude').value = position.lat;
    document.getElementById('longitude').value = position.lng;
    
    // Reverse geocode to get address
    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${position.lat}&lon=${position.lng}`)
        .then(response => response.json())
        .then(data => {
            if (data.display_name) {
                document.getElementById('address').value = data.display_name.split(',')[0];
                if (data.address.city) document.getElementById('city').value = data.address.city;
                if (data.address.postcode) document.getElementById('postal_code').value = data.address.postcode;
            }
        });
});

// Click on map to set location
map.on('click', function(e) {
    marker.setLatLng(e.latlng);
    document.getElementById('latitude').value = e.latlng.lat;
    document.getElementById('longitude').value = e.latlng.lng;
});

// Search location button
document.getElementById('searchLocationBtn').addEventListener('click', function() {
    const address = document.getElementById('address').value;
    const city = document.getElementById('city').value;
    const postalCode = document.getElementById('postal_code').value;
    
    let searchQuery = address;
    if (city) searchQuery += ', ' + city;
    if (postalCode) searchQuery += ' ' + postalCode;
    searchQuery += ', South Africa';
    
    if (!searchQuery.trim()) {
        alert('Please enter an address to search');
        return;
    }
    
    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(searchQuery)}&limit=1`)
        .then(response => response.json())
        .then(data => {
            if (data && data.length > 0) {
                const lat = parseFloat(data[0].lat);
                const lon = parseFloat(data[0].lon);
                
                map.setView([lat, lon], 15);
                marker.setLatLng([lat, lon]);
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lon;
                
                if (data[0].display_name) {
                    // Extract just the street address
                    const parts = data[0].display_name.split(',');
                    if (parts[0]) document.getElementById('address').value = parts[0];
                }
            } else {
                alert('Location not found. Please try a different address.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error searching location. Please try again.');
        });
});
</script>
@endsection