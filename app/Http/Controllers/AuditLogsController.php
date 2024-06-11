<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\AuditLog;


class AuditLogsController extends Controller
{
    public function index()
    {
        $user = Auth::User() ? Auth::User() : abort(403);

        return view('modules.admin.administration.audit-logs.index',
            compact([
                'user',
            ]));

    }

    public function getAjax(){

        $logs = AuditLog::get();

        $data = [];
        foreach ($logs as $key => $log) {
            $data[] = [
                'user_id'   => $log->user->id,
                'user_name' => $log->user->name,
                'action'    => $log->activity,
                'created_date' => $log->created_at,
                'data'      => unserialize($log->summary),
            ];
        }
        return datatables($data)->toJson();
    }
}
