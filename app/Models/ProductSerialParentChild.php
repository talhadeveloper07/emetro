<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSerialParentChild extends Model
{
    protected $guarded = [];

    protected $table = 'product_serial_parent_child';
    public $timestamps = false;

//    public const CREATED_AT = 'created';
//    public const UPDATED_AT = 'updated';

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

    public function children()
    {
        return $this->hasMany(ProductSerialChild::class, 'assigned_to_parent', 'slno');
    }
    public function childDevices()
    {
        return $this->hasManyThrough(
            ProductSerial::class,
            ProductSerialChild::class,
            'assigned_to_parent',
            'slno',
            'slno',
            'slno'
        );
    }
    public function access()
    {
        return $this->hasOne(ProductSerialAccess::class, 'slno', 'slno');
    }
    public function notes()
    {
        return $this->hasMany(ProductSerialNote::class, 'slno', 'slno');
    }
    public function sipTruncks()
    {
        return $this->hasMany(ProductSerialSipTruck::class, 'slno', 'slno');
    }
    public function logs()
    {
        return $this->hasMany(ProductSerialLog::class, 'parent_slno', 'slno');
    }
}
