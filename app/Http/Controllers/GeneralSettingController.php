<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConfigGeneral;
class GeneralSettingController extends Controller
{
    public function index()
    {
        $config  =  ConfigGeneral::get()->first();
        return view('modules.admin.administration.general-settings.index', compact(['config']));
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'rate_mpmprint' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'rate_selfprint' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        $settings = ConfigGeneral::updateOrCreate(
            [
                'id' => 1,
            ],
            [
                'rate_mpmprint' => $request->rate_mpmprint,
                'rate_selfprint' => $request->rate_selfprint,
            ]
        );

        return redirect()->route('general_setting.index');

    }


}
