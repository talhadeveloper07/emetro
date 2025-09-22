<?php

namespace App\Traits;
trait AutoUid
{
    protected static function bootAutoUid()
    {
        static::creating(function ($model) {
            // Lock table to prevent concurrency issues
            $maxUid = static::lockForUpdate()->max('uid') ?? 0;
            $model->uid = $maxUid + 1;
        });
    }
}
