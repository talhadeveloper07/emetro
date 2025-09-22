<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $guarded = [];

    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'discount_organization')
            ->withPivot('custom_amount', 'is_custom')
            ->withTimestamps();
    }

}
