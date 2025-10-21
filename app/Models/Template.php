<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $table = 'templates';

    protected $fillable = [
        'template_name',
        'vendor',
        'model',
        're_seller',
        'modified_date',
        'file_location',
        'file_id',
        'file_name',
        'is_default'
    ];
}
