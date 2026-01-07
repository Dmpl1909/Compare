<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'brand',
        'description',
        'image_url',
    ];

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function alerts()
    {
        return $this->hasMany(PriceAlert::class);
    }
}
