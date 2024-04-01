<?php

namespace App\Http\Controllers;

use App\Models\CefrConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::User() ? Auth::User() : abort(403);

        return view('admin.dashboard',
            compact([
                'user',
            ]));
    }
}
