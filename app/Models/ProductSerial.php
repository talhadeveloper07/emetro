<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSerial extends Model
{
    protected $guarded = [];

    protected $table = 'product_serial';
    public $timestamps = false;

    protected $casts = [
        'updated' => 'integer',
        'created' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created = time();
            $model->updated = time();
        });

        static::updating(function ($model) {
            $model->updated = time();
        });
    }

    public function org()
    {
        return $this->hasOne(Organization::class, 'nid', 're_seller');
    }
    public function secondaryOrg()
    {
        return $this->hasOne(Organization::class, 'nid', 'end_customer_id');
    }
    public function children()
    {
        return $this->hasMany(ProductSerialChild::class, 'slno', 'slno');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'product_code', 'product_code');
    }
    public function parentChild()
    {
        return $this->hasOne(ProductSerialParentChild::class, 'slno', 'slno');
    }

}
