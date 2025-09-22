<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSerialNote extends Model
{
    protected $guarded = [];

    protected $table = 'product_serial_notes';
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
        return $this->belongsTo(ProductSerial::class, 'slno', 'slno');
    }
}
