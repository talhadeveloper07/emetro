<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentTerm extends Model
{
    protected $guarded = [];


    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'organization_payment_term', 'payment_term_id', 'organization_id');
    }
}
