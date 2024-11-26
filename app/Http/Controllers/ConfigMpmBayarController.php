<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConfigMpmBayar;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

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

        // $configMpmBayar = ConfigMpmBayar::updateOrCreate(
        //     ['id' => $request->id],
        //     [
        //         'url' => $request->url,
        //         'token' => $request->token,
        //         'secret_key' => $request->secret_key,
        //     ]
        // );

        // AuditLog::create([
        //     'user_id' => Auth::User()->id,
        //     'activity' => 'Update MPMBayar config',
        //     'summary' => serialize('Data that change before and after'),
        //     'device' => AuditLog::getDeviceDetail(),
        // ]);

        // Get old data for audit log if updating
        $oldData = null;
        if ($request->id) {
            $oldData = ConfigMpmBayar::find($request->id);
        }

        // Update or create configuration
        $configMpmBayar = ConfigMpmBayar::updateOrCreate(
            ['id' => $request->id],
            [
                'url' => $request->url,
                'token' => $request->token, // Encrypt sensitive data
                'secret_key' => $request->secret_key,
            ]
        );

        // Prepare audit log data
        $changes = [
            'before' => $oldData ? [
                'url' => $oldData->url,
                'token' => $oldData->token, // Don't log actual token
                'secret_key' => $oldData->secret_key,
            ] : 'New Configuration',
            'after' => [
                'url' => $configMpmBayar->url,
                'token' => $configMpmBayar->token,
                'secret_key' => $configMpmBayar->secret_key,
            ]
        ];

        // Create audit log
        AuditLog::create([
            'user_id' => Auth::id(),
            'activity' => $oldData ? 'Update MPMBayar config' : 'Create MPMBayar config',
            'summary' => serialize($changes),
            'device' => AuditLog::getDeviceDetail(),
        ]);

        return redirect()->back()
                         ->with('success', 'Update successful')
                         ->with('configMpmBayar', $configMpmBayar);

    }
}
