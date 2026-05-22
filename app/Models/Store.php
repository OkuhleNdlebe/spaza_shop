<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'location', 
        'owner_name', 
        'contact_number', 
        'low_stock_threshold',
        'latitude',      
        'longitude',     
        'address',       
        'city',          
        'postal_code'    
    ];
    
    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8'
    ];
    
    public function products()
    {
        return $this->belongsToMany(Product::class, 'store_product')
            ->withPivot('quantity', 'delivered_at', 'expire_date')
            ->withTimestamps();
    }
    
    public function lowStockProducts()
    {
        return $this->belongsToMany(Product::class, 'store_product')
            ->wherePivot('quantity', '<=', $this->low_stock_threshold ?? 5)
            ->withPivot('quantity');
    }
    
    public function getFullAddressAttribute()
    {
        $parts = [];
        if ($this->address) $parts[] = $this->address;
        if ($this->location) $parts[] = $this->location;
        if ($this->city) $parts[] = $this->city;
        if ($this->postal_code) $parts[] = $this->postal_code;
        
        return implode(', ', $parts);
    }
    
    public function getOpenStreetMapUrlAttribute()
    {
        if ($this->latitude && $this->longitude) {
            return "https://www.openstreetmap.org/?mlat={$this->latitude}&mlon={$this->longitude}#map=15/{$this->latitude}/{$this->longitude}";
        }
        return "https://www.openstreetmap.org/search?query=" . urlencode($this->full_address);
    }
    
    public function getDirectionsUrlAttribute()
    {
        if ($this->latitude && $this->longitude) {
            return "https://www.openstreetmap.org/directions?engine=fossgis_osrm_car&route=&to={$this->latitude}%2C{$this->longitude}";
        }
        return "#";
    }
}