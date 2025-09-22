<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSerialLog extends Model
{
    protected $guarded = [];

    protected $table = 'product_serial_log';
    public $timestamps = false;

    protected $casts = [
        'created' => 'integer',
    ];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created = time();
        });

    }

    public function productSerial()
    {
        return $this->belongsTo(ProductSerial::class, 'slno', 'parent_slno');
    }
    public function productSerialParentChild()
    {
        return $this->belongsTo(ProductSerialParentChild::class, 'slno', 'parent_slno');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'uid');
    }
}
