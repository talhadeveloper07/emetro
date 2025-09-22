<?php

namespace App\Imports;

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

class OrgUserImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts, ShouldQueue
{
    protected $defaultPassword;
    public function __construct()
    {
        $this->defaultPassword = Hash::make('password123');
    }
    public function collection(Collection $rows)
    {
//        $header = null;
        foreach ($rows as $row) {
            if (!empty($row['email'])) {
                $userData = [
                    'uid' => $row['uid'] ?? null,
                    'org_id' => self::nullify($row['main_contact_id']),
                    'name' => self::nullify($row['name']),
                    'email' => self::nullify($row['email']),
                    'first_name' => $row['first_name'] ?? null,
                    'last_name' => $row['last_name'] ?? null,
                    'password' => $this->defaultPassword,
                    'office_phone' => self::nullify($row['office_phone']),
                    'cell' => self::nullify($row['cell']),
                    'ucx_course' => self::nullify($row['ucx_course']),
                    'infinity_one_course' => self::nullify($row['infinity_one_course']),
                    'job_title' => self::nullify($row['job_title']),
                    'courses' => self::nullify($row['courses']),
                    'newsletter_id' => self::nullify($row['newsletter_id']),
                    'created_by' => self::nullify($row['created_by']),
                    'updated_by' => self::nullify($row['updated_by']),
                    'created_at' => self::toCarbon($row['created']),
                    'updated_at' => self::toCarbon($row['updated']),
                ];

                $user = User::updateOrCreate(['email' => $row['email']], $userData);

                if (!empty($row['roles'])) {
                    $roles = explode(',', $row['roles']);

                    $roles = array_map(function ($role) {
                        $role = trim($role);

                        if ($role === 'End Customer 2') {
                            return 'Customer';
                        }

                        return $role;
                    }, $roles);

                    $user->syncRoles($roles);
                }
            }
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
        return $value === "NULL" ? null : $value;
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
