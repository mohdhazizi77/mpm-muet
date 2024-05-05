<?php

namespace Database\Seeders;

use App\Models\Courier;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courier = new Courier();
        $courier->name = "POSLAJU MY";
        $courier->rate = "20.00";
        $courier->currency = "MYR";
        $courier->duration = "3-5 Days";
        $courier->api_url = "www.poslaju.com/api/pos/v1";
        $courier->api_key = "YOUR API KEY HERE";
        $courier->secret_key =  "YOUR SECRET KEY HERE";
        $courier->save();
    }
}
