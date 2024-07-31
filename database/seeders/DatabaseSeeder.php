<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DefaultUserRoleSeeder::class);

        $this->call(CourierSeeder::class);
        // $this->call(OrderSeeder::class);
        // $this->call(TrackingOrderSeeder::class);
        $this->call(KodktsSeeder::class);
        $this->call(ConfigGeneralSeeder::class);

        // Config Seeder
        $this->call(ConfigPoslajuSeeder::class);
        $this->call(ConfigMpmBayarSeeder::class);

        // MUET Seeder
        // $this->call(MuetCalonSeeder::class);
        // $this->call(MuetPusatSeeder::class);
        // $this->call(MuetSkorSeeder::class);
        // $this->call(MuetTarikhSeeder::class);

    }
}
