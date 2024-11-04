<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class ConfigPoslaju extends Model
{
    protected $table = 'config_poslajus';

    protected $fillable = [
        'url',
        'client_id',
        'client_secret',
        'grant_type',
        'scope',
        'Prefix',
        'ApplicationCode',
        'Secretid',
        'username',
        'subscriptionCode',
        'requireToPickup',
        'requireWebHook',
        'accountNo',
        'callerName',
        'callerPhone',
        'pickupLocationID',
        'pickupLocationName',
        'contactPerson',
        'phoneNo',
        'pickupAddress',
        'pickupDistrict',
        'pickupProvince',
        'pickupCountry',
        'pickupEmail',
        'postCode',
        'ItemType',
        'totalQuantityToPickup',
        'PaymentType',
        'readyToCollectAt',
        'closeAt',
        'ShipmentName',
        'currency',
        'countryCode',
    ];

    protected $casts = [
        'requireToPickup' => 'boolean',
        'requireWebHook' => 'boolean',
        'accountNo' => 'integer',
        'postCode' => 'integer',
        'ItemType' => 'integer',
        'totalQuantityToPickup' => 'integer',
    ];

    public function tokenExists() // Changed to public
    {
        return Session::has('bearer_token');
    }

    public function tokenExpiredOrAboutToExpire() // Changed to public
    {
        $expiresAt = Session::get('bearer_token_expires_at', Carbon::now()->subSecond());
        return Carbon::now()->greaterThanOrEqualTo($expiresAt->subHours(1));
    }

    public function getNewToken() // Changed to public
    {
        $ConfigPoslaju = ConfigPoslaju::first();

        try {
            $url = $ConfigPoslaju->url . "/oauth2/token";
            $data = [
                'client_id' => $ConfigPoslaju->client_id,
                'client_secret' => $ConfigPoslaju->client_secret,
                'grant_type' => $ConfigPoslaju->grant_type,
                // 'scope' => $ConfigPoslaju->scope,
            ];

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_HTTPHEADER, ['Accept: application/json']);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

            $output = curl_exec($curl);
            return [$url, $data, $output];
            if (curl_errno($curl)) {
                error_log("cURL error: " . curl_error($curl));
                curl_close($curl);
                return "An error occurred while connecting to the POS API. Please try again later.";
            }

            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($http_status != 200) {
                error_log("HTTP Status Code: " . $http_status);
                curl_close($curl);
                return "An error occurred with the POS API. Please try again later.";
            }

            curl_close($curl);
            $output = json_decode($output);

            if (!empty($output) && isset($output->access_token)) {
                $token = $output->access_token;
                $expiresAt = now()->addSeconds($output->expires_in);
                Session::put('bearer_token', $token);
                Session::put('bearer_token_expires_at', $expiresAt);

                return $output;
            } else {
                error_log("Failed to connect to the POS API.");
                return "An error occurred while processing your request. Please try again later.";
            }

        } catch (\Exception $e) {
            error_log("API token retrieval failed: " . $e->getMessage());
            return "An error occurred while processing your request. Please try again later.";
        }
    }

    public static function getToken()
    {
        $configPoslaju = ConfigPoslaju::first();

        if (!$configPoslaju) {
            return response()->json(['error' => 'ConfigPoslaju settings not found.'], 404);
        }

        if ($configPoslaju->tokenExists() && !$configPoslaju->tokenExpiredOrAboutToExpire()) {
            $bearerToken = Session::get('bearer_token');
        } else {
            $tokenResponse = $configPoslaju->getNewToken();
            if (is_string($tokenResponse)) {
                return response()->json(['error' => $tokenResponse], 500);
            }
            $bearerToken = $tokenResponse->access_token;
        }

        return response()->json(['token' => $bearerToken]);
    }
}
