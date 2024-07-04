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
    }
}
