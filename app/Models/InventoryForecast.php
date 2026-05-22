<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryForecast extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'product_id',
        'store_id',
        'current_stock',
        'predicted_demand',
        'recommended_order',
        'stockout_risk_date',
        'stockout_probability',
        'forecast_date',
        'for_date'
    ];
    
    protected $casts = [
        'stockout_risk_date' => 'date',
        'forecast_date' => 'date',
        'for_date' => 'date'
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}