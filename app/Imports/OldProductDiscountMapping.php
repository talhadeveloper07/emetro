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

class OldProductDiscountMapping implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts, ShouldQueue
{
    public function collection(Collection $rows)
    {
//        $header = null;

        foreach ($rows as $row) {

            $Data = [
                'product_id' => self::nullify($row['nid']),
                'discount_id' => self::nullify($row['discount_id']),
            ];
            \App\Models\OldProductDiscountMapping::insert($Data);

        }
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
