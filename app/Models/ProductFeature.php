<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'feature',
    ];

    // Each feature belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
