<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConfigMpmBayar;
use Illuminate\Support\Facades\Validator;

class ConfigMpmBayarController extends Controller
{
    public function index()
    {
        $configMpmBayar = ConfigMpmBayar::first();
        return view('modules.admin.administration.config.mpmbayar.index', compact('configMpmBayar'));
    }

    public function updateOrCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|string',
            'token' => 'required|string',
            'secret_key' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $configMpmBayar = ConfigMpmBayar::updateOrCreate(
            ['id' => $request->id],
            [
                'url' => $request->url,
                'token' => $request->token,
                'secret_key' => $request->secret_key,
            ]
        );
        return redirect()->back()
                         ->with('success', 'Update successful')
                         ->with('configMpmBayar', $configMpmBayar);

    }
}
