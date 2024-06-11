<?php

namespace Database\Seeders;

use App\Models\MuetCalon;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MuetCalonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mc = new MuetCalon();
        $mc->tahun = 2024;
        $mc->sidang = 1;
        $mc->nama = 'Luqman Hakim';
        $mc->kp = '991006055193';
        $mc->kodnegeri = 'MB';
        $mc->kodpusat = '1001';
        $mc->jcalon = '1';
        $mc->nocalon = '001';
        $mc->alamat1 = 'tepi masjid';
        $mc->alamat2 = '';
        $mc->poskod = '40200';
        $mc->bandar = 'Shah Alam';
        $mc->negeri = 'Selangor';
        $mc->skor_agregat = '250';
        $mc->band = '5';

        $mc->save();

        $mc = new MuetCalon();
        $mc->tahun = 2020;
        $mc->sidang = 1;
        $mc->nama = 'Luqman Hakim';
        $mc->kp = '991006055193';
        $mc->kodnegeri = 'MB';
        $mc->kodpusat = '1001';
        $mc->jcalon = '1';
        $mc->nocalon = '001';
        $mc->alamat1 = 'tepi masjid';
        $mc->alamat2 = '';
        $mc->poskod = '40200';
        $mc->bandar = 'Shah Alam';
        $mc->negeri = 'Selangor';
        $mc->skor_agregat = '120';
        $mc->band = '3';

        $mc->save();
    }
}
