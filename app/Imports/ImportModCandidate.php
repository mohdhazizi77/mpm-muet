<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use App\Models\User;
use App\Models\Candidate;
use App\Models\Certificate;
use App\Models\ExamSession;

use App\Models\ModCalon;
use App\Models\ModSkor;
use App\Models\ModTarikh;
use App\Models\ModPusat;


use App\Models\Kodkts;

class ImportModCandidate implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {

        $totalCount = count($rows);
        $processedCount = 0;

        // TAHUN	SIDANG	CID	NAMA_SESI	NAMA	KP	SEKOLAH/INSTITUSI	ANGKA_GILIRAN	TARIKH_ISU	TARIKH_EXPIRED	LISTENING	SPEAKING	READING	WRITING SKOR_AGREGAT BAND

        foreach ($rows as $key => $row) {
            if ($key == 0 || $key == 1)
                continue;
            // if (empty($row[0]))

            // Break the loop if the first column is empty
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
                $kp = str_replace('-', '', $kp); // buang '-' dekat ic
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

            // // year and session
            // $seperator = " ";
            // $year_session = explode(" ", $row[1]);

            // $sesi = $year_session[1];
            // $year = $year_session[2];

            // Split the string by "/"
            $parts = explode("/", $angka_giliran);
            // echo(print_r($parts, 1));
            Log::info(print_r($parts, 1));

            // Process the first part
            $part1 = $parts[0];
            $kodnegeri = substr($part1, 0, 2); // "MW"
            $kodpusat = substr($part1, 2, 4); // "3101"

            // Process the second part
            $reg_id = $parts[1];
            $nocalon = $parts[1];

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


            $skor = new ModSkor();

            $result = [
                1 => $listening, //listening
                2 => $speaking, //speaking
                3 => $reading, //reading
                4 => $writing, //writing
            ];

            foreach ($result as $key => $value) {
                $ms = new ModSkor();
                $ms->tahun      = $tahun;
                $ms->sidang     = $sidang;
                $ms->kp         = $kp;
                $ms->kodnegeri  = $kodnegeri;
                $ms->kodpusat   = $kodpusat;
                $ms->reg_id     = $reg_id;
                $ms->nocalon    = $nocalon;
                $ms->kodkts     = $key;
                $ms->skorbaru    = $value;
                $ms->save();
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

            $ModPusat = ModPusat::updateOrCreate(
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
}

