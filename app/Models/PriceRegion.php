<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceRegion extends Model
{
    protected $guarded = [];

    public function productPrices()
    {
        return $this->hasMany(ProductPrice::class);
    }
}
