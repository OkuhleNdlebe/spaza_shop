<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'manufacturer_id', 'expiry_date', 'price', 'supplier_id'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function generateQrCode()
    {
        $productUrl = route('products.show', $this->id);
        return QrCode::size(200)->generate($productUrl);
    }
    public function manufacturer()
{
    return $this->belongsTo(Manufacturer::class);
}

public function stores()
{
    return $this->belongsToMany(Store::class, 'store_product')
        ->withPivot('quantity', 'delivered_at', 'expire_date')
        ->withTimestamps();
}
 public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
