<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;

use App\Models\ConfigPoslaju;

class CheckBearerTokenPos
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->getNewToken();

        // Check if the token exists in the session
        if (!$this->tokenExists()) {
            // Token doesn't exist, get a new one
            $this->getNewToken();
        }

        // Check if the token is expired or about to expire (within 11 hours)
        if ($this->tokenExpiredOrAboutToExpire()) {
            // Renew the token
            $this->getNewToken();
        }

        return $next($request);
    }

    /**
     * Check if the token exists in the session.
     *
     * @return bool True if the token exists, false otherwise.
     */
    private function tokenExists()
    {
        return Session::has('bearer_token');
    }

    /**
     * Get a new Bearer token by calling the API.
     *
     * @return void
     */
    private function getNewToken()
    {

        try {
            $url = "https://gateway-usc.pos.com.my/security/connect/token";
            // $data = [
            //     'client_id' => "66712e0af304bd000e908bb5",
            //     'client_secret' => "1tG5mGMAvAzu5qyM59iqWE4lSQFmDohRhN/HuPusnoM=",
            //     'grant_type' => "client_credentials",
            //     'scope' => "as01.gen-connote.all as2corporate.preacceptancessingle.all as01.routing-code.all as2corporate.v2trackntracewebapijson.all as01.generate-pl9-with-connote.all"
            // ];

            $data = [
                'client_id' => ConfigPoslaju::first()->client_id,
                'client_secret' => ConfigPoslaju::first()->client_secret,
                'grant_type' => ConfigPoslaju::first()->grant_type,
                'scope' => ConfigPoslaju::first()->scope,
            ];

            $output = '';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Accept: application/json',
            ));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $output = curl_exec($curl);
            $output = json_decode($output);

            if (curl_errno($curl)) {
                $error_msg = curl_error($curl);
                error_log("cURL error: " . $error_msg); // Log the error
                curl_close($curl);
                return "An error occurred while connecting to the POS API. Please try again later.";
            }

            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if ($http_status != 200) {
                $error_msg = "HTTP Status Code: " . $http_status;
                error_log("cURL error: " . $error_msg); // Log the error
                curl_close($curl);
                return "An error occurred with the POS API. Please try again later.";
            }

            if (!empty($output)) {
                curl_close($curl);

                $token = $output->access_token;
                $durationInSeconds = $output->expires_in;

                // Convert the duration from seconds to hours
                $durationInHours = $durationInSeconds / 3600;

                // Store the token in the session
                Session::put('bearer_token', $token);

                // Set the expiration time
                $expiresAt = now()->addHours($durationInHours);
                Session::put('bearer_token_expires_at', $expiresAt);

                return $output;
            } else {
                $error_msg = "Failed to connect to the POS API. URL or TOKEN may be incorrect.";
                error_log("Connection error: " . $error_msg); // Log the error
                curl_close($curl);
                return "An error occurred while processing your request. Please try again later.";
            }

        } catch (\Exception $e) {
            // Handle API call failure (e.g., log error)
        }
    }

    /**
     * Check if the token is expired or about to expire.
     *
     * @return bool True if the token is expired or about to expire, false otherwise.
     */
    private function tokenExpiredOrAboutToExpire()
    {
        $expiresAt = Session::get('bearer_token_expires_at', Carbon::now()->subSecond());

        // Check if token is expired or within 11 hours of expiration
        return Carbon::now()->greaterThanOrEqualTo($expiresAt->subHours(1));
    }
}
