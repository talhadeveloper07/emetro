<?php

namespace App\Helpers;

use App\Models\ProvisioningInfinity3065;
use Illuminate\Support\Facades\Storage;

class XmlHelper
{
    public static function saveXml(ProvisioningInfinity3065 $record)
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;
    
        // Root tag should be <config>
        $config = $dom->createElement('config');
        $dom->appendChild($config);
    
        // Helper closure to add each element
        $add = function ($name, $value = '') use ($dom, $config) {
            $child = $dom->createElement($name);
            $child->appendChild($dom->createTextNode((string) $value));
            $config->appendChild($child);
        };
    
        // Add specific fields in your required order
        $add('slno', $record->slno);
        $add('email', $record->email);
        $add('mobile', $record->mobile);
        $add('device_id', $record->device_id);
        $add('s1_ip', $record->s1_ip);
        $add('s1_port', $record->s1_port);
        $add('s2_ip', $record->s2_ip);
        $add('s2_port', $record->s2_port);
        $add('extension', $record->extension);
        $add('first_name', $record->first_name);
        $add('last_name', $record->last_name);
        $add('allow_multiple_profile', $record->allow_multiple_profile ? 'Yes' : 'No');
        $add('allow_changes_to_default_profile', $record->allow_changes_default_profile ? 'Yes' : 'No');
        $add('s1_retry_number', $record->s1_retry_number);
        $add('notification_method', $record->notification_method);
        $add('s2_retry_number', $record->s2_retry_number);
        $add('device_current_status', $record->device_current_status);
        $add('created', now()->format('d M y H:i:s O')); // e.g. 02 Oct 25 15:00:50 -0500
        $add('activation_timestamp', time());
        $add('infinityone_url', $record->infinityone_url);
        $add('sms_did1', $record->sms_did_1);
        $add('sms_did2', $record->sms_did_2);
    
        // Save file (MD5 filename style)
        $fileName = "softphone_{$record->device_id}.xml";
        $hashName = strtoupper(md5($fileName)) . '.xml';
        Storage::put("soft_phones/{$hashName}", $dom->saveXML());
    }
    

    public static function deleteXml(ProvisioningInfinity3065 $record)
    {
        $fileName = "softphone_{$record->device_id}.xml";
        Storage::delete("provisioning_xml/{$fileName}");
    }
}
