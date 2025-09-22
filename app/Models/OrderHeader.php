<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderHeader extends Model
{
    protected $guarded = [];

    public function org()
    {
        return $this->belongsTo(Organization::class,'reseller_id','nid');
    }
    public function details()
    {
        return $this->hasMany(OrderDetail::class,'header_id','id')->orderBy('sort_order','DESC');
    }
}
