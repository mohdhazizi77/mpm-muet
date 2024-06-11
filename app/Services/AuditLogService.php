<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditLogService
{
    public static function log($model, $activity, $oldData, $newData)
    {
        $data = [
            'old' => $oldData,
            'new' => $newData
        ];

        $summary = [
            'table' => get_class($model),
            'id'    => $model->id,
            'data'  => $data,
        ];

        $log = new AuditLog();
        $log->user_id = Auth::user()->id ?? null; // Handle the case if user is not authenticated
        $log->activity = $activity;
        $log->summary = serialize($summary);
        $log->device = self::getDeviceDetail();
        $log->save();
    }

    protected static function getDeviceDetail()
    {
        return request()->userAgent();
    }
}
