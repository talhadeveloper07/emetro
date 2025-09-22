<?php

namespace App\Imports;

use App\Models\OrderHeader;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OdrHeaderImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts, ShouldQueue
{
    public function collection(Collection $rows)
    {
//        $header = null;
        $Data=[];
        foreach ($rows as $row) {

            $Data[] = [
                'id' => $row['id'] ?(int)$row['id'] : null,
                'uid' => self::nullify($row['uid']),
                'sid' => self::nullify($row['sid']),
                'end_customer' => self::nullify($row['end_customer']),
                'address' => self::nullify($row['address']),
                'reseller_id' => self::nullify($row['reseller_id']),
                'total' => self::toNumber($row['total']),
                'balance' => self::toNumber($row['balance']),
                'dicount' => self::toNumber($row['dicount']),
                'status' => self::nullify($row['status']),
                'quote_date' => self::toCarbon($row['quote_date']),
                'type' => self::nullify($row['type']),
                'support_discount' => self::nullify($row['support_discount']),
                'invoice_status' => self::nullify($row['invoice_status']),
                'data' => self::toSerializedJson($row['data']),
                'payment_status' => self::toSerializedJson($row['payment_status']),
                'order_status' => self::nullify($row['order_status']),
                'extra_discount' => self::nullify($row['extra_discount']),
                'paid_category' => self::nullify($row['paid_category']),
                'software_po' => self::nullify($row['software_po']),
                'billing_option' => self::nullify($row['billing_option']),
                'end_customer_id' => self::nullify($row['end_customer_id']),
                'payment_error' => self::nullify($row['payment_error']),
                'monthly' => self::nullify($row['monthly']),
                'quote_id' => self::nullify($row['quote_id']),
                'created_at' => self::toCarbon($row['created']),
                'updated_at' => self::toCarbon($row['updated']),
            ];
        }
        OrderHeader::upsert($Data, ['id']);
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
