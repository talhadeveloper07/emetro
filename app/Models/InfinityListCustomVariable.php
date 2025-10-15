<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfinityListCustomVariable extends Model
{
    protected $table = 'infinity_list_custom_variables';

    protected $fillable  = [
        'parent_slno',
        'slno',
        'pcode',
        'pvalue'
    ];
}
