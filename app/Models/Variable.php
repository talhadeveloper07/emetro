<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
    protected $fillable = ['name', 'value'];

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = serialize($value);
    }

    // Unserialize when fetching
    public function getValueAttribute($value)
    {
        return unserialize($value);
    }
}

