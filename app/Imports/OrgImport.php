<?php

namespace App\Imports;

use App\Models\Organization;
use App\Models\OrganizationNote;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;

class OrgImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $header = null;

        foreach ($rows as $index => $row) {
            if ($index === 0) {
                $header = $row->toArray();
                continue;
            }

            $row = $row->toArray();
            if (count($row) !== count($header)) {
                continue; // skip mismatched rows
            }

            $record = array_combine($header, $row);
            if (!$record) {
                continue;
            }

            // JSON note field handling
            $notes = $record['note'] === "NULL" || $record['note'] === "" ? null : $record['note'];
            if ($notes !== null) {
                $decodedNotes = json_decode($notes, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $record['note'] = json_encode($decodedNotes);
                } else {
                    $record['note'] = null;
                }
            }
            $nid = self::nullify($record['nid']);

            $orgData = [
                'name' => $record['name'],
                'phone' => self::nullify($record['phone']),
                'cell' => self::nullify($record['cell']),
                'billing_address_1' => self::nullify($record['billing_address_1']),
                'billing_address_2' => self::nullify($record['billing_address_2']),
                'billing_city' => self::nullify($record['billing_city']),
                'billing_state' => self::nullify($record['billing_state']),
                'billing_country' => self::nullify($record['billing_country']),
                'billing_zip' => self::nullify($record['billing_zip']),
                'source' => self::nullify($record['source']),
                'website' => self::nullify($record['website']),
                'tags' => self::nullify($record['tags']),
                'status' => self::nullify($record['status']),
                'created_by' => self::nullify($record['created_by']),
                'update_by' => self::nullify($record['update_by']),
                'org_type' => self::nullify($record['org_type']),
                'first_contact' => self::nullify($record['first_contact']),
                'nid' => is_null($nid) ? null : (int) $nid,
                'email' => self::nullify($record['email']),
                'shipping_address_1' => self::nullify($record['shipping_address_1']),
                'shipping_address_2' => self::nullify($record['shipping_address_2']),
                'shipping_city' => self::nullify($record['shipping_city']),
                'shipping_state' => self::nullify($record['shipping_state']),
                'shipping_country' => self::nullify($record['shipping_country']),
                'shipping_zip' => self::nullify($record['shipping_zip']),
                'billing_county' => self::nullify($record['billing_county']),
                'shipping_county' => self::nullify($record['shipping_county']),
                'master_reseller' => self::nullify($record['master_reseller']),
                'distributer' => self::nullify($record['distributer']),
                'emt_contact' => self::nullify($record['emt_contact']),
                'tax_id' => self::nullify($record['tax_id']),
                'no_of_emp' => self::nullify($record['no_of_emp']),
                'logo' => self::nullify($record['logo']),
                'archive' => $record['archive'] === "NULL" ? 0 : $record['archive'],
                'note' => null,
                'tax_exemption' => self::nullify($record['tax_exemption']),
                'payout_email' => Str::limit($record['payout_email'] ?? '', 255),
                'payout_status' => self::nullify($record['payout_status']),
                'payout_type' => self::nullify($record['payout_type']),
                'direct_hardware' => self::nullify($record['direct_hardware']),
                'hardware_direct_email' => self::nullify($record['hardware_direct_email']),
                'direct_software' => self::nullify($record['direct_software']),
                'software_direct_email' => self::nullify($record['software_direct_email']),
                'software_distributer' => self::nullify($record['software_distributer']),
                'price_type' => self::nullify($record['price_type']),
                'agent_name' => self::nullify($record['agent_name']),
                'agent_start' => self::toCarbon($record['agent_start']),
                'created_at' => self::toCarbon($record['created']),
                'updated_at' => self::toCarbon($record['updated']),
            ];

            $organization = Organization::updateOrCreate(['id' => $record['id']], $orgData);
            // Save note in organization_notes table
            // Save notes to organization_notes table
            if (!empty($record['note'])) {
                $decodedNotes = json_decode($record['note'], true);

                if (json_last_error() === JSON_ERROR_NONE && is_array($decodedNotes)) {
                    OrganizationNote::where('org_id',$organization->id)->delete();
                    foreach ($decodedNotes as $noteItem) {
                        OrganizationNote::create([
                            'org_id' => $organization->id,
                            'user_id' => $noteItem['user'] ?? null,
                            'note_type' => $noteItem['note_type'] ?? null,
                            'note' => $noteItem['note'] ?? null,
                            'created_at' => isset($noteItem['created']) ? \Carbon\Carbon::createFromTimestamp($noteItem['created']) : now(),
                            'updated_at' => isset($noteItem['created']) ? \Carbon\Carbon::createFromTimestamp($noteItem['created']) : now(),
                        ]);
                    }
                }
            }

        }
    }

    private static function nullify($value)
    {
        return $value === "NULL" ? null : $value;
    }

    private static function toCarbon($timestamp)
    {
        return $timestamp === "NULL" || $timestamp === null ? null : Carbon::createFromTimestamp($timestamp)->toDateTimeString();
    }
}
