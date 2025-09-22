<?php

namespace App\Imports;

use App\Models\Organization;
use App\Models\OrganizationDocument;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;

class OrgDocImport implements ToCollection
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
//            dd($record);
            $org = null;
            $resellerId = self::nullify($record['reseller_id']);
            if ($resellerId) {
                $org = Organization::where('nid', $resellerId)->first();
            }
            if (!$org) {
                $orgId = self::nullify($record['org_id']);
                if ($orgId) {
                    $org = Organization::where('id', $orgId)->first();
                }
            }
            $org_id = $org ? $org->id : null;
            $path=self::nullify($record['filename']);
            $filename = $path?"/org_document/".basename($path):null;
            $data = [
                'org_id' => $org_id,
                'type' => self::nullify($record['type']),
                'file' => $filename,
                'status' => self::nullify($record['status']),
                'added_by' => self::nullify($record['added_user']) !== null ? (int) $record['added_user'] : null,
                'updated_by' => self::nullify($record['updated_user']) !== null ? (int) $record['updated_user'] : null,
                'created_at' => self::toCarbon($record['created']),
                'updated_at' => self::toCarbon($record['updated']),
            ];

            OrganizationDocument::updateOrCreate(['id' => $record['id']], $data);
        }
    }

    private static function nullify($value)
    {
        return $value === "NULL" ? null : $value;
    }

    private static function toCarbon($timestamp)
    {
        return $timestamp === "NULL" ? now() : Carbon::createFromTimestamp($timestamp)->toDateTimeString();
    }
}
