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
        $this->call(ExamSessionSeeder::class);
        $this->call(CourierSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(TrackingOrderSeeder::class);

    }
}
