<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationSetting extends Model
{
    protected $guarded = [];
    protected $casts = [
        'is_paypal' => 'boolean',
        'is_stripe' => 'boolean',
        'is_emtpay' => 'boolean',
        'is_term' => 'boolean',
        'is_create_order' => 'boolean',
        'emtpay_topup' => 'boolean',
        'save_credit_card' => 'boolean',
        'monthly_bill_auto_payment' => 'boolean',
        'annual_bill_auto_payment' => 'boolean',
        'payment_terms_credit_limit' => 'float',
    ];
}
