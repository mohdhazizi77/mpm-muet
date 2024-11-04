<?php

namespace App\Http\Controllers;

use App\Models\ConfigPoslaju;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConfigPoslajuController extends Controller
{
    public function index()
    {
        $configPoslaju = ConfigPoslaju::first();

        return view('modules.admin.administration.config.poslaju.index', compact('configPoslaju'));
    }

    public function updateOrCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|string',
            'client_id' => 'required|string',
            'client_secret' => 'required|string',
            'grant_type' => 'required|string',
            'scope' => 'required|string',
            'Prefix' => 'required|string',
            'ApplicationCode' => 'required|string',
            'Secretid' => 'required|string',
            'username' => 'required|string',
            'subscriptionCode' => 'required|string',
            'requireToPickup' => 'boolean',
            'requireWebHook' => 'boolean',
            'accountNo' => 'required|integer',
            'callerName' => 'required|string',
            'callerPhone' => 'required|string',
            'pickupLocationID' => 'required|string',
            'pickupLocationName' => 'required|string',
            'contactPerson' => 'required|string',
            'phoneNo' => 'required|string',
            'pickupEmail' => 'required|string|email',
            'pickupAddress' => 'required|string',
            'pickupDistrict' => 'required|string',
            'pickupProvince' => 'required|string',
            'pickupCountry' => 'required|string',
            'postCode' => 'required|integer',
            'ItemType' => 'integer',
            'totalQuantityToPickup' => 'integer',
            'PaymentType' => 'string',
            'readyToCollectAt' => 'required|string',
            'closeAt' => 'required|string',
            'ShipmentName' => 'string',
            'currency' => 'string',
            'countryCode' => 'string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput()
                             ->with('error', 'Validation Error');
        }

        // $configPoslaju = ConfigPoslaju::updateOrCreate(
        //     ['id' => 1], // Unique field to identify the record
        //     $request->all()
        // );

        $configPoslaju = ConfigPoslaju::query()->update($request->all());

        return redirect()->back()
                         ->with('success', 'Update successful')
                         ->with('configPoslaju', $configPoslaju);
    }
}
