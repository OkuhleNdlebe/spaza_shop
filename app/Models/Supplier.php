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
}
