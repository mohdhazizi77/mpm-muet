<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralSettingController extends Controller
{
    public function index()
    {
        return view('modules.admin.administration.general-settings.index');
    }
}
