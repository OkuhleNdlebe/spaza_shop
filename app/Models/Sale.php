<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
        protected $fillable = [
        'store_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_amount',
        'sale_date',
        'notes'
    ];

    protected $casts = [
        'sale_date' => 'datetime',
        'unit_price' => 'decimal:2',
        'total_amount' => 'decimal:2'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Scope for filtering sales by date range
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('sale_date', [$startDate, $endDate]);
    }

    // Scope for sales in the last X days
    public function scopeLastDays($query, $days)
    {
        return $query->where('sale_date', '>=', now()->subDays($days));
    }
}
