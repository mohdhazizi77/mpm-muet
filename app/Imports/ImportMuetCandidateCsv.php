<?php

namespace App\Imports;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
// use Maatwebsite\Excel\Concerns\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use App\Models\Candidate;
use App\Models\MuetCalon;
use App\Models\MuetSkor;
use App\Models\MuetTarikh;
use App\Models\MuetPusat;

class ImportMuetCandidateCsv implements ToModel, WithChunkReading, WithBatchInserts, WithHeadingRow, SkipsEmptyRows, ShouldQueue
{
    public function model(array $row)
    {

        // dd($row);
        // $totalCount = count($rows);
        // $processedCount = 0;

        // foreach ($rows as $key => $row) {
        // if ($key == 0)
        //     // if ($key == 0 || $key == 1)
        //     continue;

        // if ($row[7] == "ANGKA GILIRAN")
        //     continue;

        // if (empty($row[0])) {
        //     break;
        // }

        if (!empty($row['angkagiliran'])) {

            $tahun          = $row['tahun'];
            $sidang         = $row['sesi'];
            $sesi           = $row['namasesi'];
            $nama           = $row['nama'];
            $kp             = $row['kp'];
            $pusat          = null; //$row['pusat'];
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
                $kp = str_replace('-', '', $kp);
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

            $parts = explode("/", $angka_giliran);
            $part1 = $parts[0];
            $kodnegeri = substr($part1, 0, 2);
            $kodpusat = substr($part1, 2, 4);

            $reg_id = $parts[1];

            $part2 = $parts[1];
            $jcalon = substr($part2, 0, 1);
            $nocalon = substr($part2, 1, 3);

            $calon = MuetCalon::updateOrCreate(
                [
                    'angka_giliran' => $angka_giliran,
                ],
                [
                    'tahun'           => $tahun,
                    'sidang'          => $sidang,
                    'nama'            => $nama,
                    'kp'              => $kp,
                    'kodnegeri'       => $kodnegeri,
                    'kodpusat'        => $kodpusat,
                    'jcalon'          => $jcalon,
                    'reg_id'          => $reg_id,
                    'nocalon'         => $nocalon,
                    'alamat1'         => '-',
                    'alamat2'         => '-',
                    'poskod'          => '-',
                    'bandar'          => '-',
                    'negeri'          => '-',
                    'skor_agregat'    => $skor_agregat,
                    'band'            => $band,
                ]
            );

            $result = [
                1 => $listening,
                2 => $speaking,
                3 => $reading,
                4 => $writing,
            ];

            foreach ($result as $key => $value) {
                // $ms = new MuetSkor();
                // $ms->tahun      = $tahun;
                // $ms->sidang     = $sidang;
                // $ms->kodnegeri  = $kodnegeri;
                // $ms->kodpusat   = $kodpusat;
                // $ms->jcalon     = $jcalon;
                // $ms->nocalon    = $nocalon;
                // $ms->kodkts     = $key;
                // $ms->mkhbaru    = $value;
                // $ms->save();
                MuetSkor::updateOrCreate([
                    'tahun'      => $tahun,
                    'sidang'     => $sidang,
                    'kodnegeri'  => $kodnegeri,
                    'kodpusat'   => $kodpusat,
                    'jcalon'     => $jcalon,
                    'nocalon'    => $nocalon,
                    'kodkts'     => $key,
                ], [
                    'mkhbaru'    => $value,
                ]);

                Log::info('MuetSkor: ' . $tahun . ' ' . $sidang . ' ' . $kodnegeri . ' ' . $kodpusat . ' ' . $jcalon . ' ' . $nocalon . ' ' . $key . ' ' . $value);
            }

            $muetTarikh = MuetTarikh::updateOrCreate(
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

            // dd($row);
            // $muetPusat = MuetPusat::updateOrCreate(
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

            // $processedCount++;
            // dd($row);
            // }
        }
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
