<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Organization extends Model
{
    protected $guarded = [];
    protected static function boot()
    {
        parent::boot();

        // Auto-assign NID when creating new organization
        static::creating(function ($organization) {
            if (empty($organization->nid)) {
                $organization->nid = self::getNextNid();
            }
        });
    }
    public function hwFulfillments(): HasMany
    {
        return $this->hasMany(OrganizationHwFulfillment::class, 'org_nid', 'nid');
    }

    public function swFulfillments(): HasMany
    {
        return $this->hasMany(OrganizationSwFulfillment::class, 'org_nid', 'nid');
    }
    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'discount_organization')
            ->withPivot('custom_amount', 'is_custom')
            ->withTimestamps();
    }

    public function setting()
    {
        return $this->hasOne(OrganizationSetting::class, 'org_nid', 'nid');
    }
    public function paymentTerms()
    {
        return $this->belongsToMany(PaymentTerm::class, 'organization_payment_term', 'organization_id', 'payment_term_id');
    }
    public function notes()
    {
        return $this->hasMany(OrganizationNote::class, 'org_id', 'id');
    }
    public function documents()
    {
        return $this->hasMany(OrganizationDocument::class, 'org_id', 'id');
    }
    public function logs()
    {
        return $this->hasMany(OrganizationLog::class, 'organization_id', 'id');
    }



    /**
     * Get the next available NID
     */
    public static function getNextNid()
    {
        $maxNid = self::max('nid');
        return $maxNid ? $maxNid + 1 : 1;
    }

    /**
     * Assign NID to records that don't have one
     */
    public static function assignMissingNids()
    {
        $recordsWithoutNid = self::whereNull('nid')->orWhere('nid', 0)->get();

        if ($recordsWithoutNid->isEmpty()) {
            return 0; // No records to update
        }

        $currentMaxNid = self::max('nid') ?? 0;
        $updatedCount = 0;

        foreach ($recordsWithoutNid as $record) {
            $currentMaxNid++;
            $record->update(['nid' => $currentMaxNid]);
            $updatedCount++;
        }

        return $updatedCount;
    }

    /**
     * Get organization by NID
     */
    public static function findByNid($nid)
    {
        return self::where('nid', $nid)->first();
    }
}
