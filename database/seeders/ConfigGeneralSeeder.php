<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ConfigGeneral;

class ConfigGeneralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $config = new ConfigGeneral();
        $config->rate_mpmprint = "60.00";
        $config->rate_selfprint = "20.00";
        $config->email_alert_order = "notification@mpm.com";
        $config->save();
    }
}
