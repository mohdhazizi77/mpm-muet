<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ConfigMpmBayar;

class ConfigMpmBayarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ConfigMpmBayar::create([
            'url' => 'https://example.com/api',
            'token' => 'example_token',
            'secret_key' => 'example_secret_key',
        ]);

        // ConfigMpmBayar::create([
        //     'url' => 'https://ebayar-lab.mpm.edu.my',
        //     'token' => 'a2aWmIGjPSVZ8F3OvS2BtppKM2j6TKvKXE7u8W7MwbkVyZjwZfSYdNP5ACem',
        //     'secret_key' => '1eafc1e9-df86-4c8c-a3de-291ada259ab0',
        // ]);

    }
}
