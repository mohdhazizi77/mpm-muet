<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConfigPoslaju;

class ConfigPoslajuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ConfigPoslaju::updateOrCreate(
            ['username' => 'test_user'], // Unique identifier for the record
            [
                'url' => 'https://gateway-usc.pos.com.my/staging',
                'client_id' => '66712e0af304bd000e908bb5',
                'client_secret' => '1tG5mGMAvAzu5qyM59iqWE4lSQFmDohRhN/HuPusnoM=',
                'grant_type' => 'client_credentials',
                'scope' => 'as01.gen-connote.all as2corporate.preacceptancessingle.all as01.routing-code.all as2corporate.v2trackntracewebapijson.all as01.generate-pl9-with-connote.all',

                'Prefix' => 'ER',
                'ApplicationCode' => 'StagingPos',
                'Secretid' => 'StagingPos@1234',
                'username' => 'StagingPos',

                'subscriptionCode' => 'sub123',
                'requireToPickup' => true,
                'requireWebHook' => true,
                'accountNo' => 1234567890,
                'callerName' => 'SUB(PSM)', //pic
                'callerPhone' => '03-61261600', //pic
                'pickupLocationID' => 'PL123',
                'pickupLocationName' => 'Majlis Peperiksaan Malaysia',
                'contactPerson' => 'SUB(PSM)',
                'phoneNo' => '03-61261600',
                'pickupEmail' => 'muet@mpm.edu.my',
                'pickupAddress' => 'Majlis Peperiksaan Malaysia, Persiaran 1, Bandar Baru Selayang',
                'pickupDistrict' => 'Batu Caves',
                'pickupProvince' => 'Selangor',
                'pickupCountry' => 'MY',
                'postCode' => 12345,
                'ItemType' => 0,
                'totalQuantityToPickup' => 1,
                'PaymentType' => '2',
                'readyToCollectAt' => '12:00 PM',
                'closeAt' => '6:00 PM',
                'ShipmentName' => 'PosLaju',
                'currency' => 'MYR',
                'countryCode' => 'MY',
            ]
        );
    }
}
