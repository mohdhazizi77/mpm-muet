<?php

namespace App\Imports;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Candidate;
use App\Models\MuetCalon;
use App\Models\MuetSkor;
use App\Models\MuetTarikh;
use App\Models\MuetPusat;

class ImportMuetCandidate implements ToModel, WithChunkReading, WithBatchInserts, WithHeadingRow
{
    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (empty($row[0])) {
            return null;
        }

        $tahun = $row[0];
        $sidang = $row[1];
        $sesi = $row[3];
        $nama = $row[4];
        $kp = $row[5];
        $pusat = $row[6];
        $angka_giliran = $row[7];
        $tarikh_isu = $row[8];
        $tarikh_exp = $row[9];
        $listening = $row[10];
        $speaking = $row[11];
        $reading = $row[12];
        $writing = $row[13];
        $skor_agregat = $row[14];
        $band = $row[15];

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
            MuetSkor::create([
                'tahun'      => $tahun,
                'sidang'     => $sidang,
                'kodnegeri'  => $kodnegeri,
                'kodpusat'   => $kodpusat,
                'jcalon'     => $jcalon,
                'nocalon'    => $nocalon,
                'kodkts'     => $key,
                'mkhbaru'    => $value,
            ]);
        }

        MuetTarikh::updateOrCreate(
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

        MuetPusat::updateOrCreate(
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

        return $calon;
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

    /**
     * Specify the batch size for inserts.
     *
     * @return int
     */
    public function batchSize(): int
    {
        return 1000; // Insert 1000 rows at a time
    }
}
