<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dect extends Model
{
    use HasFactory;

    // 👇 Table name (if not following Laravel naming convention)
    protected $table = 'dect';

    // 👇 Primary key column
    protected $primaryKey = 'id';

    // 👇 If you don’t use auto-incremented IDs, uncomment below
    // public $incrementing = true;

    // 👇 Laravel manages created_at / updated_at timestamps automatically
    public $timestamps = true;

    // 👇 Fields that can be mass-assigned
    protected $fillable = [
        'mac',
        're_seller',
        'slno',
        'model',
        'extension',
        'last_push',
        'sip_mode',
        'sip_server_address',
        'sip_server_port',
        'time_server',
        'country',
        'region',
        'codec_priority',
        'primary_mac',
        'index_assigned',
    ];
}
