<?php

namespace Database\Seeders;

use App\Models\MuetPusat;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MuetPusatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mp = new MuetPusat();
        $mp->tahun = 2024;
        $mp->sidang = 1;
        $mp->kodnegeri = 'MB';
        $mp->kodpusat = '1001';
        $mp->namapusat = 'Dewan Bandaraya Seksen 7';
        $mp->save();
        
        $mp = new MuetPusat();
        $mp->tahun = 2020;
        $mp->sidang = 1;
        $mp->kodnegeri = 'MB';
        $mp->kodpusat = '1001';
        $mp->namapusat = 'Dewan Bandaraya Seksen 7';
        $mp->save();
    }
}
