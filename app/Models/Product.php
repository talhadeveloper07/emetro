<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function productPrices()
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class, 'discount_category_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
    public function boms()
    {
        return $this->hasMany(ProductBom::class, 'product_id');
    }

    // For hardware/software: get all services that link to this product
    public function linkedServices()
    {
        return $this->hasMany(Product::class, 'linked_product_id')->where('product_type', 'Service');
    }
    // For service: get the product it links to
    public function linkedProduct()
    {
        return $this->belongsTo(Product::class, 'linked_product_id');
    }
}
