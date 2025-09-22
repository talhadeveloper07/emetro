<?php

namespace App\Imports;

use App\Models\OrderDetail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OdrDetailImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts, ShouldQueue
{
    public function collection(Collection $rows)
    {
//        $header = null;
        $Data=[];
        foreach ($rows as $row) {

            $Data[] = [
                'id' => self::nullify($row['id']),
                'header_id' => self::nullify($row['header_id']),
                'product_node_id' => self::nullify($row['product_node_id']),
                'product_node_title' => self::nullify($row['product_node_title']),
                'sort_order' => self::nullify($row['sort_order']),
                'qty' => self::nullify($row['qty']),
                'price' => self::toNumber($row['price']),
                'options' => self::toSerializedJson($row['options']),
                'created_at' => self::toCarbon($row['created']),
                'updated_at' => self::toCarbon($row['created']),
            ];
//            dd($Data);
        }
        OrderDetail::upsert($Data, ['id']);
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
