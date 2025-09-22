<?php

namespace App\Imports;

use App\Models\AssuranceNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrgNotificationImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts, ShouldQueue
{
    public function collection(Collection $rows)
    {
        $notifications = [];

        foreach ($rows as $record) {
            $notifications[] = [
                'id' => self::nullify($record['nid']),
                'slno' => self::nullify($record['slno']),
                'subject' => self::nullify($record['subject']),
                'mail_message' => self::nullify($record['mail_message']),
                'expiry_date' => self::toCarbon($record['expiry_date']),
                'installed_by' => self::nullify($record['installed_by']) !== null ? (int) $record['installed_by'] : null,
                'message_type' => self::nullify($record['message_type']),
                'alert_status' => self::nullify($record['alert_status']),
                'mail_status' => self::nullify($record['mail_status']),
                'assurance_quote_id' => self::nullify($record['assurance_quote_id']) !== null ? (int) $record['assurance_quote_id'] : null,
                'order_id' => self::nullify($record['order_id']),
                'template_id' => self::nullify($record['template_id']),
                'to' => self::nullify($record['to']),
                'attachment_content' => self::nullify($record['attachment_content']),
                'attachment_filename' => self::nullify($record['attachment_filename']),
                'attachment_file_type' => self::nullify($record['attachment_file_type']),
                'created_at' => self::toCarbon($record['created']),
                'updated_at' => self::toCarbon($record['updated']),
            ];
        }

        // Upsert using unique 'id'
        AssuranceNotification::upsert($notifications, ['id']);
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
        return ($value === "NULL" || $value === null) ? null : $value;
    }

    private static function toCarbon($timestamp)
    {
        return ($timestamp === "NULL" || empty($timestamp))
            ? now()
            : Carbon::createFromTimestamp($timestamp)->toDateTimeString();
    }
}
