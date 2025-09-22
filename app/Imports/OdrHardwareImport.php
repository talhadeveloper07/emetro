<?php

namespace App\Imports;

use App\Models\OrderHardware;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OdrHardwareImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts, ShouldQueue
{
    public function collection(Collection $rows)
    {
//        $header = null;
        $Data=[];
        foreach ($rows as $row) {

            $Data[] = [
                'id' => $row['id'] ?(int)$row['id'] : null,
                'distributer' => self::nullify($row['distributer']),
                'order_id' => self::nullify($row['order_id']),
                'reseller_order_id' => self::nullify($row['reseller_order_id']),
                'account_on_file' => self::nullify($row['account_on_file']),
                'account_no' => self::nullify($row['account_no']),
                'carrier' => self::nullify($row['carrier']),
                'shipping_location_name' => self::nullify($row['shipping_location_name']),
                'shipping_street_address' => self::nullify($row['shipping_street_address']),
                'shipping_city' => self::nullify($row['shipping_city']),
                'shipping_state' => self::nullify($row['shipping_state']),
                'shipping_zip_code' => self::nullify($row['shipping_zip_code']),
                'phone' => self::nullify($row['phone']),
                'att' => self::nullify($row['att']),
                'billing_location_name' => self::nullify($row['billing_location_name']),
                'billing_street_address' => self::nullify($row['billing_street_address']),
                'billing_city' => self::nullify($row['billing_city']),
                'billing_state' => self::nullify($row['billing_state']),
                'billing_zip_code' => self::nullify($row['billing_zip_code']),
                'email' => self::nullify($row['email']),
                'reseller_id' => self::nullify($row['reseller_id']),
                'shipping_country' => self::nullify($row['shipping_country']),
                'billing_country' => self::nullify($row['billing_country']),
                'user_id' => self::nullify($row['user_id']),
                'created_at' => self::toCarbon($row['created']),
                'updated_at' => self::toCarbon($row['updated']),
            ];
        }
        OrderHardware::upsert($Data, ['id']);
    }
    public function chunkSize(): int
    {
        return 500;
    }

    public function batchSize(): int
    {
        return 500;
    }
    private static function nullify($value)
    {
        return ($value === "NULL"|| $value === "" )? null : $value;
    }
    private static function toNumber($value)
    {
        if ($value === "NULL" || $value === "" || $value === null) {
            return null;
        }
        return is_numeric($value) ? (float) $value : null;
    }
    private static function toSerializedJson($value)
    {
        if ($value === "NULL" || $value === "" || $value === null) {
            return null;
        }

        $unserialized = @unserialize($value);

        // check for valid unserialization, including serialized false
        if ($unserialized !== false || $value === 'b:0;') {
            return json_encode($unserialized);
        }

        // fallback: return null if unserialization fails
        return null;
    }
    private static function toCarbon($timestamp)
    {
        return $timestamp === "NULL" || $timestamp === null ? null : Carbon::createFromTimestamp($timestamp)->toDateTimeString();
    }
    public function disableTransactions(): bool
    {
        return true;
    }
}
