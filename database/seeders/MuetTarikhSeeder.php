<?php

namespace Database\Seeders;

use App\Models\MuetTarikh;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MuetTarikhSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mt = new MuetTarikh();
        $mt->tahun = 2024;
        $mt->sidang = 1;
        $mt->tarikh_isu =  '25/01/2024';
        $mt->tarikh_exp =  '25/02/2029';
        $mt->sesi = 'Sesi 1';
        $mt->save();

        $mt = new MuetTarikh();
        $mt->tahun = 2020;
        $mt->sidang = 1;
        $mt->tarikh_isu =  '25/01/2020';
        $mt->tarikh_exp =  '25/02/2025';
        $mt->sesi = 'Sesi 1';
        $mt->save();
    }
}
