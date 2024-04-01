<?php

namespace App\Http\Controllers;

use App\Exports\PosCompletedXlsxExport;
use App\Exports\PosProcessingXlsxExport;
use App\Models\Pos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class PosCompletedController extends Controller
{
    public function index()
    {
        $user = Auth::User() ? Auth::User() : abort(403);

        return view('admin.pos.completed.index',
            compact([
                'user',
            ]));

    }

    public function getAjax(Request $request)
    {
        if ($request->ajax()) {

            $query = Pos::query()->where('id', '<>', '0')
                ->where('status', 'COMPLETED')
                ->orderBy('date', 'asc');

            $data = !empty($query) ? $query->get() : [];

            return DataTables::of($data)->addIndexColumn()->toJson();
        }
    }

    public function exportXlsx()
    {
        return Excel::download(new PosCompletedXlsxExport, 'completed.xlsx');

    }
}
