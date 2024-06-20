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

use App\Models\MuetCalon;
use App\Models\MuetSkor;
use App\Models\ModCalon;
use App\Models\ModSkor;

use App\Models\Kodkts;

class ImportCandidate implements ToCollection
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
                continue;

            $nric = $row[3];
            if (strpos($nric, '-') !== false) {
                $nric = str_replace('-', '', $nric); // buang '-' dekat ic
            }

            $user = Candidate::updateOrCreate(
                [
                    'identity_card_number' => $nric
                ],
                [
                    'name'     => $row[2],
                    'password' => Hash::make($nric),
                ]
            );

            $user->assignRole('CALON');

            // year and session
            $seperator = " ";
            $year_session = explode(" ", $row[1]);

            $sesi = $year_session[1];
            $year = $year_session[2];

            $index_number = $row[9];
            // Split the string by "/"
            $parts = explode("/", $index_number);

            // Process the first part
            $part1 = $parts[0];
            $kodnegeri = substr($part1, 0, 2); // "MW"
            $kodpusat = substr($part1, 2, 4); // "3101"

            // Process the second part
            $part2 = $parts[1];
            $jcalon = substr($part2, 0, 1); // "3"
            $nocalon = substr($part2, 1, 3); // "001"

            $calon = new MuetCalon();
            $calon->tahun           = $year;
            $calon->sidang          = $sesi;
            $calon->nama            = $row[2];
            $calon->kp              = $nric;
            $calon->kodnegeri       = $kodnegeri;
            $calon->kodpusat        = $kodpusat;
            $calon->jcalon          = $jcalon;
            $calon->nocalon         = $nocalon;
            $calon->alamat1         = $row[4];
            $calon->alamat2         = $row[5];
            $calon->poskod          = $row[6];
            $calon->bandar          = $row[7];
            $calon->negeri          = $row[8];
            $calon->skor_agregat    = $row[16];
            $calon->band            = $row[17];
            $calon->angka_giliran   = $index_number;
            $calon->save();

            $skor = new MuetSkor();

            $result = [
                1 => $row[12], //listening
                2 => $row[13], //speaking
                3 => $row[14], //reading
                4 => $row[15], //writing
            ];

            foreach ($result as $key => $value) {
                $ms = new MuetSkor();
                $ms->tahun = $year;
                $ms->sidang = $sesi;
                $ms->kodnegeri = $kodnegeri;
                $ms->kodpusat = $kodpusat;
                $ms->jcalon = $jcalon;
                $ms->nocalon = $nocalon;
                $ms->kodkts = $key;
                $ms->mkhbaru = $value;
                $ms->save();
            }

            $processedCount++;
        }

        Log::info('Processed '.$processedCount.' out of '.$totalCount.' rows');
        Log::info('Script completed successfully. Everything looks good ['.date('Y-m-d H:i:s').']');


    }
}

