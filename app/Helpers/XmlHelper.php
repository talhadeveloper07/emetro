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

        $phone = $dom->createElement('softphone');
        $dom->appendChild($phone);

        $add = function ($name, $value) use ($dom, $phone) {
            $child = $dom->createElement($name);
            $child->appendChild($dom->createTextNode((string) $value));
            $phone->appendChild($child);
        };

        foreach ($record->getAttributes() as $key => $value) {
            $add($key, $value);
        }

        $fileName = "softphone_{$record->device_id}.xml";
        $hashName = strtoupper(md5($fileName)) . '.xml';
        Storage::put("provisioning_xml/{$hashName}", $dom->saveXML());
    }

    public static function deleteXml(ProvisioningInfinity3065 $record)
    {
        $fileName = "softphone_{$record->device_id}.xml";
        Storage::delete("provisioning_xml/{$fileName}");
    }
}
