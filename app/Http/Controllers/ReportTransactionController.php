<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportTransactionController extends Controller
{
    public function index()
    {
        $user = Auth::User() ? Auth::User() : abort(403);

        return view('admin.report.transaction.index',
            compact([
                'user',
            ]));

    }
}
