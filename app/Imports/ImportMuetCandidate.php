<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use App\Models\Candidate;
use App\Models\MuetCalon;
use App\Models\MuetSkor;
use App\Models\MuetTarikh;
use App\Models\MuetPusat;

class ImportMuetCandidate implements ToCollection, WithChunkReading
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $totalCount = count($rows);
        $processedCount = 0;

        foreach ($rows as $key => $row) {
            if ($key == 0)
            // if ($key == 0 || $key == 1)
                continue;

            if ($row[7] == "ANGKA GILIRAN")
                continue;
            
            if (empty($row[0])) {
                break;
            }

            $tahun          = $row[0];
            $sidang         = $row[1];
            $sesi           = $row[3];
            $nama           = $row[4];
            $kp             = $row[5];
            $pusat          = $row[6];
            $angka_giliran  = $row[7];
            $tarikh_isu     = $row[8];
            $tarikh_exp     = $row[9];
            $listening      = $row[10];
            $speaking       = $row[11];
            $reading        = $row[12];
            $writing        = $row[13];
            $skor_agregat   = $row[14];
            $band           = $row[15];

            if (strpos($kp, '-') !== false) {
                $kp = str_replace('-', '', $kp);
            }

            $user = Candidate::updateOrCreate(
                [
                    'identity_card_number' => $kp,
                ],
                [
                    'name'     => $nama,
                    'password' => Hash::make($kp),
                ]
            );

            $user->assignRole('CALON');

            $parts = explode("/", $angka_giliran);
            $part1 = $parts[0];
            $kodnegeri = substr($part1, 0, 2);
            $kodpusat = substr($part1, 2, 4);
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
                $ms = new MuetSkor();
                $ms->tahun      = $tahun;
                $ms->sidang     = $sidang;
                $ms->kodnegeri  = $kodnegeri;
                $ms->kodpusat   = $kodpusat;
                $ms->jcalon     = $jcalon;
                $ms->nocalon    = $nocalon;
                $ms->kodkts     = $key;
                $ms->mkhbaru    = $value;
                $ms->save();
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

            $muetPusat = MuetPusat::updateOrCreate(
                [
                    'tahun'     => $tahun,
                    'sidang'    => $sidang,
                    'kodnegeri' => $kodnegeri,
                    'kodpusat'  => $kodpusat,
                ],
                [
                    'namapusat'        => $pusat,
                ]
            );

            $processedCount++;
        }

        Log::info('Processed '.$processedCount.' out of '.$totalCount.' rows');
        Log::info('Script completed successfully. Everything looks good ['.date('Y-m-d H:i:s').']');
    }

    /**
    * Specify the chunk size for reading.
    *
    * @return int
    */
    public function chunkSize(): int
    {
        return 1000; // Process 1000 rows at a time
    }
}
