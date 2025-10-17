<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'location', 'owner_name', 'contact_number', 'low_stock_threshold'];
    
    public function products()
{
    return $this->belongsToMany(Product::class, 'store_product')
        ->withPivot('quantity', 'delivered_at', 'expire_date')
        ->withTimestamps();
}
public function lowStockProducts()
{
    return $this->belongsToMany(Product::class, 'store_product')
        ->wherePivot('quantity', '<=', $this->low_stock_threshold)
        ->withPivot('quantity');
}
}
