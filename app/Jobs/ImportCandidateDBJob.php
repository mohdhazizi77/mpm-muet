<?php

namespace App\Jobs;

use App\Models\Candidate;
use App\Models\ModCalon;
use App\Models\ModSkor;
use App\Models\ModTarikh;
use App\Models\MuetCalon;
use App\Models\MuetSkor;
use App\Models\MuetTarikh;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ImportCandidateDBJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $year;
    private $session;
    private $type;
    /**
     * Create a new job instance.
     */
    public function __construct($year, $session, $type)
    {
        $this->year = $year;
        $this->session = $session;
        $this->type = $type;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->batch()->cancelled()) {
            // Determine if the batch has been cancelled...
            return;
        }
        // $table = 'muet_resultn_devsijil';
        $table = 'muet_resultn';
        $results = DB::connection('pull-' . strtolower($this->type))->table($table);
        $results = $results->where('tahun', $this->year)
            ->where('sesi', $this->session)
            ->get();
        // Log::info("Importing " . $this->type . " Candidates: " . json_encode($results));
        foreach ($results as $row) {
            if (strtolower($this->type) == 'mod') {
                $this->importModCandidate($row);
                Log::info('Importing MOD Candidate: ' . json_encode($row));
            } elseif (strtolower($this->type) == 'muet') {
                $this->importMuetCandidate($row);
                Log::info('Importing MUET Candidate: ' . json_encode($row));
            }
        }
    }
    private function importModCandidate($row)
    {
        if (!empty($row->indexNo)) {
            $tahun          = $row->tahun;
            $sidang         = $row->sesi;
            $sesi           = $row->namasesi;
            $nama           = $row->nama;
            $kp             = $row->kp;
            $angka_giliran  = $row->indexNo;
            $tarikh_isu     = $row->tarikh_isu;
            $tarikh_exp     = $row->tarikh_exp;
            $listening      = $row->listening;
            $speaking       = $row->speaking;
            $reading        = $row->reading;
            $writing        = $row->writing;
            $skor_agregat   = $row->agg_score;
            $band           = $row->band;

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


            $parts = explode("/", $angka_giliran);
            $part1 = $parts[0];
            $kodnegeri = substr($part1, 0, 2); // "MW"
            $kodpusat = substr($part1, 2, 4); // "3101"

            // Process the second part
            $reg_id = $parts[1];
            $nocalon = substr($parts[1], -4);

            // $sesi = str_replace("MUET", "MOD", $row[3]);
            ModCalon::updateOrCreate(
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

            ModTarikh::updateOrCreate(
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
        }
    }
    private function importMuetCandidate($row)
    {
        if (!empty($row->indexNo)) {

            $tahun          = $row->tahun;
            $sidang         = $row->sesi;
            $sesi           = $row->namasesi;
            $nama           = $row->nama;
            $kp             = $row->kp;
            $angka_giliran  = $row->indexNo;
            $tarikh_isu     = $row->tarikh_isu;
            $tarikh_exp     = $row->tarikh_exp;
            $listening      = $row->listening;
            $speaking       = $row->speaking;
            $reading        = $row->reading;
            $writing        = $row->writing;
            $skor_agregat   = $row->agg_score;
            $band           = $row->band;

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

            MuetCalon::updateOrCreate(
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
        }
    }
}
