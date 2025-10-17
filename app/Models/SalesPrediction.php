<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesPrediction extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'store_id',
        'predicted_quantity',
        'confidence_level',
        'prediction_date',
        'for_date',
        'factors'
    ];

    // Add date casting
    protected $casts = [
        'prediction_date' => 'date',
        'for_date' => 'date',
        'factors' => 'array'
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
