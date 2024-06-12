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
        $courier->disp_name = "POSLAJU MY";
        $courier->rate = "60.00";
        $courier->currency = "MYR";
        $courier->duration = "3-5 Days";
        $courier->save();

        // $courier = new Courier();
        // $courier->name = "JNT";
        // $courier->disp_name = "JNT";
        // $courier->rate = "50.00";
        // $courier->currency = "MYR";
        // $courier->duration = "3-5 Days";
        // $courier->save();
    }
}
