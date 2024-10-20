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

        $logs = AuditLog::latest()->get();

        $data = [];
        foreach ($logs as $key => $log) {
            $data[$key] = [
                'action'    => $log->activity,
                'created_date' => $log->created_at->format('d/m/y H:i:s'),
                'data'      => unserialize($log->summary),
            ];
            if (!empty($log->user->id)) {
                $data[$key]['user_id'] = $log->user->id;
                $data[$key]['user_name'] = $log->user->name;
            } else {
                $data[$key]['user_id'] = $log->candidate->id;
                $data[$key]['user_name'] = $log->candidate->name;
            }

        }

        return datatables($data)->toJson();
    }
}
