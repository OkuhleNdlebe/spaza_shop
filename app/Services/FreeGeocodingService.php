<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FreeGeocodingService
{
    /**
     * Convert address to coordinates using OpenStreetMap Nominatim
     * Free, no API key required, but rate limited to 1 request per second
     */
    public function geocodeAddress($address)
    {
        try {
            // Add delay to respect rate limits
            usleep(1000000); // 1 second delay
            
            $response = Http::get('https://nominatim.openstreetmap.org/search', [
                'q' => $address . ', South Africa',
                'format' => 'json',
                'limit' => 1,
                'addressdetails' => 1
            ]);
            
            if ($response->successful() && count($response->json()) > 0) {
                $data = $response->json()[0];
                
                return [
                    'latitude' => $data['lat'],
                    'longitude' => $data['lon'],
                    'formatted_address' => $data['display_name'],
                    'city' => $data['address']['city'] ?? $data['address']['town'] ?? $data['address']['suburb'] ?? null,
                    'postal_code' => $data['address']['postcode'] ?? null
                ];
            }
        } catch (\Exception $e) {
            Log::error('Geocoding failed: ' . $e->getMessage());
        }
        
        return null;
    }
    
    /**
     * Search for places (autocomplete)
     */
    public function searchPlaces($query)
    {
        try {
            $response = Http::get('https://nominatim.openstreetmap.org/search', [
                'q' => $query . ', South Africa',
                'format' => 'json',
                'limit' => 5,
                'addressdetails' => 1
            ]);
            
            if ($response->successful()) {
                $results = [];
                foreach ($response->json() as $place) {
                    $results[] = [
                        'display_name' => $place['display_name'],
                        'lat' => $place['lat'],
                        'lon' => $place['lon'],
                        'city' => $place['address']['city'] ?? $place['address']['town'] ?? $place['address']['suburb'] ?? null,
                        'postal_code' => $place['address']['postcode'] ?? null
                    ];
                }
                return $results;
            }
        } catch (\Exception $e) {
            Log::error('Place search failed: ' . $e->getMessage());
        }
        
        return [];
    }
}