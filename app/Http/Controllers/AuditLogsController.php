<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\AuditLog;
use DataTables;

class AuditLogsController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::User() ? Auth::User() : abort(403);
        $type = $request->userType;

        return view('modules.admin.administration.audit-logs.index',
            compact([
                'user',
                'type'
            ]));

    }

    // public function getAjax(){

    //     $logs = AuditLog::latest()->get();

    //     $data = [];
    //     foreach ($logs as $key => $log) {
    //         $data[$key] = [
    //             'action'    => $log->activity,
    //             'created_date' => $log->created_at->format('d/m/y H:i:s'),
    //             'data'      => unserialize($log->summary),
    //         ];
    //         if (!empty($log->user->id)) {
    //             $data[$key]['user_id'] = $log->user->id;
    //             $data[$key]['user_name'] = $log->user->name;
    //         } else {
    //             $data[$key]['user_id'] = $log->candidate->id;
    //             $data[$key]['user_name'] = $log->candidate->name;
    //         }

    //     }

    //     return datatables($data)->toJson();
    // }

    // public function getAjax()
    // {
    //     // Retrieve only 100 records per page using pagination
    //     // $logs = AuditLog::latest()->paginate(1000);
    //     $logs = AuditLog::get();

    //     $data = [];
    //     foreach ($logs as $key => $log) {
    //         $data[$key] = [
    //             'action'        => $log->activity,
    //             'created_date'  => $log->created_at->format('d/m/y H:i:s'),
    //             'data'          => unserialize($log->summary),
    //         ];

    //         if (!empty($log->user->id)) {
    //             $data[$key]['user_id']   = $log->user->id ?? '-';
    //             $data[$key]['user_name'] = $log->user->name ?? '-';
    //         } else {
    //             $data[$key]['user_id']   = $log->candidate->id ?? '-';
    //             $data[$key]['user_name'] = $log->candidate->name ?? '-';
    //         }
    //     }

    //     // Use Datatables with pagination
    //     return datatables()->of($data)->with('pagination', [
    //         'total' => $logs->total(),
    //         'per_page' => $logs->perPage(),
    //         'current_page' => $logs->currentPage(),
    //         'last_page' => $logs->lastPage(),
    //     ])->toJson();
    // }

    public function getAjax(Request $request)
    {
        // dd($request->toArray());
        // dd($query);

        if ($request->type == "Admin") {
            $query = AuditLog::with(['user'])->whereNotNull('user_id')->latest();
        } elseif($request->type == "Candidate") {
            $query = AuditLog::with(['candidate'])->whereNotNull('candidate_id')->latest();
        } else {
            dd("invalid type");
        }

        return DataTables::of($query)
            ->filter(function ($query) use ($request) {
                if ($request->has('search')) {
                    $search = $request->search['value'];
                    $query->where(function($q) use ($search) {
                        $q->where('activity', 'like', "%{$search}%")
                        ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('candidate', fn($q) => $q->where('name', 'like', "%{$search}%"));
                    });
                }
            })
            ->addColumn('data', function($log) {
                return unserialize($log->summary);
            })
            ->addColumn('user_id', function($log) {
                return !empty($log->user->id) ? $log->user->id : ($log->candidate->id ?? '-');
            })
            ->addColumn('user_name', function($log) {
                return !empty($log->user->id) ? $log->user->name : ($log->candidate->name ?? '-');
            })
            ->addColumn('created_date', function($log) {
                return $log->created_at->format('d/m/y H:i:s');
            })
            ->addColumn('action', function($log) {
                return $log->activity;
            })
            ->toJson();
    }

}
