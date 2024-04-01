<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::User() ? Auth::User() : abort(403);

        return view('admin.administration.users.index',
            compact([
                'user',
            ]));

    }

    public function create()
    {
        $user = Auth::User() ? Auth::User() : abort(403);

        return view('admin.administration.users.create',
            compact([
                'user',
            ]));
    }
}
