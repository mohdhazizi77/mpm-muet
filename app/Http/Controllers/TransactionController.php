<?php

namespace App\Http\Controllers;

use App\Models\Pos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class TransactionController extends Controller
{
    public function index()
    {
        $user = Auth::User() ? Auth::User() : abort(403);

        return view('admin.report.transaction.index',
            compact([
                'user',
            ]));

    }

    public function getAjax(Request $request)
    {
        if ($request->ajax()) {

            $query = Pos::query()->where('id', '<>', '0')
                ->orderBy('date', 'asc');

            $data = !empty($query) ? $query->get() : [];

            return DataTables::of($data)->addIndexColumn()->toJson();
        }
    }
}