<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpiryAlert extends Model
{
    use HasFactory;
    
protected $fillable = ['product_id', 'store_id', 'expiry_date', 'days_until_expiry', 'notification_sent'];

public function product()
{
    return $this->belongsTo(Product::class);
}

public function store()
{
    return $this->belongsTo(Store::class);
}
}
