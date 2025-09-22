<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function priceRegion()
    {
        return $this->belongsTo(PriceRegion::class, 'price_region_id');
    }
}
