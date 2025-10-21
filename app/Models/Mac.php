<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mac extends Model
{
    
    // Table name
    protected $table = 'mac';

    // Mass assignable fields
    protected $fillable = [
        'mac',
        'vendor',
        'model',
        'template_name',
        're_seller',
        'modified_date',
    ];
}
