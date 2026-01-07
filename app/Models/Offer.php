<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'source_id',
        'price',
        'availability',
        'url',
        'collected_at',
    ];

    protected $casts = [
        'collected_at' => 'datetime',
        'price' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function priceHistories()
    {
        return $this->hasMany(PriceHistory::class);
    }
}
