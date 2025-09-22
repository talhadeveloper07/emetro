<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\XmlHelper;


class ProvisioningInfinity3065 extends Model
{
    protected $table = 'soft_phone_provisioning';
    protected $primaryKey = 'slno';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'device_id',
        'slno',
        'first_name',
        'last_name',
        'extension',
        'email',
        'mobile',
        's1_ip',
        's1_port',
        's1_retry_number',
        's2_ip',
        's2_port',
        's2_retry_number',
        'reseller_name',
        'device_type',
        'device_current_status',
        'org_id',
    ];

    protected $casts = [
        's1_port' => 'integer',
        's1_retry_number' => 'integer',
        's2_port' => 'integer',
        's2_retry_number' => 'integer',
    ];

    protected static function booted()
    {
        static::created(function ($record) {
            XmlHelper::saveXml($record);
        });

        static::updated(function ($record) {
            XmlHelper::saveXml($record);
        });

        static::deleted(function ($record) {
            XmlHelper::deleteXml($record);
        });
    }


    /**
     * Generate or Update XML file from database
     */
    protected static function updateXmlFile()
    {
        $records = self::all();

        $xml = new \SimpleXMLElement('<softphones/>');

        foreach ($records as $record) {
            $phone = $xml->addChild('softphone');
            $phone->addChild('slno', $record->slno);
            $phone->addChild('device_id', $record->device_id);
            $phone->addChild('first_name', $record->first_name);
            $phone->addChild('last_name', $record->last_name);
            $phone->addChild('extension', $record->extension);
            $phone->addChild('email', $record->email);
            $phone->addChild('mobile', $record->mobile);
            $phone->addChild('s1_ip', $record->s1_ip);
            $phone->addChild('s1_port', $record->s1_port);
            $phone->addChild('s1_retry_number', $record->s1_retry_number);
            $phone->addChild('s2_ip', $record->s2_ip);
            $phone->addChild('s2_port', $record->s2_port);
            $phone->addChild('s2_retry_number', $record->s2_retry_number);
            $phone->addChild('reseller_name', $record->reseller_name);
            $phone->addChild('device_type', $record->device_type);
            $phone->addChild('device_current_status', $record->device_current_status);
            $phone->addChild('org_id', $record->org_id);
        }

        // Save file inside public folder (accessible via browser)
        $xml->asXML(public_path('soft_phone_provisioning.xml'));
    }
}
