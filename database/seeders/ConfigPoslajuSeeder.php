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
                'url' => 'https://api.poslaju.com',
                'client_id' => 'your_client_id',
                'client_secret' => 'your_client_secret',
                'grant_type' => 'client_credentials',
                'scope' => 'read write',

                'Prefix' => 'ERC',
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
