<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
// use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

use App\Models\Candidate;


use App\Models\ModCalon;
use App\Models\ModSkor;
use App\Models\ModTarikh;
// use App\Models\ModPusat;


// use App\Models\Kodkts;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ImportModCandidateCsv implements ToModel, WithChunkReading, WithBatchInserts, WithHeadingRow, SkipsEmptyRows, ShouldQueue
{
    public function model(array $row)
    {
        // dd($row);

        $tahun          = $row['tahun'];
        $sidang         = $row['sesi'];
        $sesi           = $row['namasesi'];
        $nama           = $row['nama'];
        $kp             = $row['kp'];
        $pusat          = null; //$row[6];
        $angka_giliran  = $row['angkagiliran'];
        $tarikh_isu     = $row['tarikh_isu'];
        $tarikh_exp     = $row['tarikh_exp'];
        $listening      = $row['listening'];
        $speaking       = $row['speaking'];
        $reading        = $row['reading'];
        $writing        = $row['writing'];
        $skor_agregat   = $row['skor_agregat'];
        $band           = $row['band'];

        if (strpos($kp, '-') !== false) {
            $kp = str_replace('-', '', $kp); // buang '-' dekat ic
        }

        $user = Candidate::updateOrCreate(
            [
                'identity_card_number' => $kp,
            ],
            [
                'name'     => $nama,
                'password' => Hash::make(12345678), //Hash::make($kp),
            ]
        );

        $user->assignRole('CALON');

        // // year and session
        // $seperator = " ";
        // $year_session = explode(" ", $row[1]);

        // $sesi = $year_session[1];
        // $year = $year_session[2];

        // Split the string by "/"
        $parts = explode("/", $angka_giliran);
        // echo(print_r($parts, 1));
        // Log::info(print_r($parts, 1));

        // Process the first part
        $part1 = $parts[0];
        $kodnegeri = substr($part1, 0, 2); // "MW"
        $kodpusat = substr($part1, 2, 4); // "3101"

        // Process the second part
        $reg_id = $parts[1];
        $nocalon = substr($parts[1], -4);

        // $sesi = str_replace("MUET", "MOD", $row[3]);

        $calon = ModCalon::updateOrCreate(
            [
                'angka_giliran' => $angka_giliran,
            ],
            [
                'tahun' => $tahun,
                'sidang' => $sidang,
                'nama' => $nama,
                'kp' => $kp,
                'kodnegeri' => $kodnegeri,
                'kodpusat' => $kodpusat,
                'reg_id' => $reg_id,
                'nocalon' => $nocalon,
                'alamat1' => '-',
                'alamat2' => '-',
                'poskod' => '-',
                'bandar' => '-',
                'negeri' => '-',
                'skor_agregat' => $skor_agregat,
                'band' => $band,
            ]
        );


        // $skor = new ModSkor();

        $result = [
            1 => $listening, //listening
            2 => $speaking, //speaking
            3 => $reading, //reading
            4 => $writing, //writing
        ];

        foreach ($result as $key => $value) {
            ModSkor::updateOrCreate([
                'tahun'      => $tahun,
                'sidang'     => $sidang,
                'kodnegeri'  => $kodnegeri,
                'kodpusat'   => $kodpusat,
                'reg_id'     => $reg_id,
                'nocalon'    => $nocalon,
                'kodkts'     => $key,
            ], [
                'skorbaru'    => $value,
            ]);
        }

        $ModTarikh = ModTarikh::updateOrCreate(
            [
                'tahun' => $tahun,
                'sidang' => $sidang
            ],
            [
                'tarikh_isu'        => $tarikh_isu,
                'tarikh_exp'        => $tarikh_exp,
                'sesi'              => $sesi,
            ]
        );

        // $ModPusat = ModPusat::updateOrCreate(
        //     [
        //         'tahun'     => $tahun,
        //         'sidang'    => $sidang,
        //         'kodnegeri' => $kodnegeri,
        //         'kodpusat'  => $kodpusat,
        //     ],
        //     [
        //         'namapusat'        => $pusat,
        //     ]
        // );

        // return $calon;
        // }

        // Log::info('Processed ' . $processedCount . ' out of ' . $totalCount . ' rows');
        // Log::info('Script completed successfully. Everything looks good [' . date('Y-m-d H:i:s') . ']');
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function startRow(): int
    {
        return 2;
    }
}
