<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DectExtension extends Model
{
    protected $table = 'dect_extension';

    protected $fillable = [
        'extension',
        'display_name',
        'secret',
        'index',
        'mac'
    ];
}
