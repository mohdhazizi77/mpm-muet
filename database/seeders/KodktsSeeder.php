<?php

namespace Database\Seeders;

use App\Models\Kodkts;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KodktsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arr = ['Listening','Speaking','Reading','Writing'];

        foreach ($arr as $k => $v) {
            $kodkts = new Kodkts();
            $kodkts->nama = $v;
            $kodkts->save();
        }
    }
}
