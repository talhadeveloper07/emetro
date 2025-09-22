<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSerialAccess extends Model
{
    protected $guarded = [];

    protected $table = 'product_serial_access';
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

    public function productSerial()
    {
        return $this->belongsTo(ProductSerial::class, 'slno', 'slno');
    }
}
