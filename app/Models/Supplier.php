<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'company_name',
        'contact_person',
        'phone_number',
        'email',
        'address',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

public function performanceMetrics()
{
    $products = $this->products()->withCount('stores')->get();
    
    return [
        'total_products' => $products->count(),
        'products_in_stock' => $products->sum('stores_count'),
        'average_delivery_time' => $this->calculateAverageDeliveryTime(),
        'quality_rating' => $this->calculateQualityRating()
    ];
}

private function calculateAverageDeliveryTime()
{
    // This would use actual delivery data
    return rand(1, 5); // Placeholder
}

private function calculateQualityRating()
{
    // This would use product quality data
    return rand(3, 5); // Placeholder 3-5 star rating
}

// Add this to track performance
public function performanceLogs()
{
    return $this->hasMany(SupplierPerformanceLog::class);
}
}
