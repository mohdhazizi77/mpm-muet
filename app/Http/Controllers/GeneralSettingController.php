<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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


        $validator = Validator::make($request->all(), [
            'rate_mpmprint' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'rate_selfprint' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'email_alert_order' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $config = ConfigGeneral::updateOrCreate(
            [
                'id' => 1,
            ],
            [
                'rate_mpmprint' => $request->rate_mpmprint,
                'rate_selfprint' => $request->rate_selfprint,
                'email_alert_order' => $request->email_alert_order,
            ]
        );

        return redirect()->back()
                         ->with('success', 'Update successful')
                         ->with('config', $config);

    }
}
