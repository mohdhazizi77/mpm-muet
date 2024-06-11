<?php

namespace Database\Seeders;

use App\Models\MuetSkor;
use App\Models\Kodkts;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MuetSkorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kodkts = Kodkts::get();

        foreach ($kodkts as $k => $v) {
            $ms = new MuetSkor();
            $ms->tahun = 2024;
            $ms->sidang = 1;
            $ms->kodnegeri = 'MB';
            $ms->kodpusat = '1001';
            $ms->jcalon = '1';
            $ms->nocalon = '001';
            $ms->kodkts = $v->id;
            $ms->mkhbaru = rand(45,90);
            $ms->save();
        }

        foreach ($kodkts as $k => $v) {
            $ms = new MuetSkor();
            $ms->tahun = 2020;
            $ms->sidang = 1;
            $ms->kodnegeri = 'MB';
            $ms->kodpusat = '1001';
            $ms->jcalon = '1';
            $ms->nocalon = '001';
            $ms->kodkts = $v->id;
            $ms->mkhbaru = rand(45,90);
            $ms->save();
        }
    }
}
