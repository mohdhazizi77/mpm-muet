<?php

namespace App\Console\Commands;

use App\Models\MuetCalon;
use App\Models\ModCalon;
use App\Models\Candidate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ImportCandidatesDBCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mpm:import_db_candidate_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update candidate data from Modul MuetCalon and ModCalon';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // DB::beginTransaction();

        try {
            $this->importFromMuetCalon();
            $this->importFromModCalon();

            // DB::commit();
            $this->info('Import completed successfully.');
        } catch (\Exception $e) {
            // DB::rollBack();
            $this->error('Import failed: ' . $e->getMessage());
        }
    }

    private function importFromMuetCalon()
    {
        $this->info('Import Candidate from MuetCalon Started.');

        MuetCalon::chunk(1000, function ($muetCalonRecords) {
            $this->bulkInsertCandidates($muetCalonRecords);
        });

        $this->info('Import Candidate from MuetCalon Completed.');
    }

    private function importFromModCalon()
    {
        $this->info('Import Candidate from ModCalon Started.');

        ModCalon::chunk(100000, function ($modCalonRecords) {
            $this->bulkInsertCandidates($modCalonRecords);
        });

        $this->info('Import Candidate from ModCalon Completed.');
    }

    private function bulkInsertCandidates($records)
    {
        $candidates = [];

        foreach ($records as $record) {
            $identityCardNumber = str_replace('-', '', $record->kp); // Remove '-' from IC number

            // Check if the candidate already exists
            $existingCandidate = Candidate::where('identity_card_number', $identityCardNumber)->exists();

            if (!$existingCandidate) {
                $candidates[] = [
                    // 'id' => '',
                    'name' => $record->nama,
                    'identity_card_number' => $identityCardNumber,
                    'password' => Hash::make($identityCardNumber),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                // $this->info("Candidate inserted: {$record->nama}");
            } else {
                $this->info("Candidate already exists: {$record->nama}");
            }
        }

        // Debugging: Output the $candidates array
        // $this->info('Candidates to be inserted:');
        // $this->info(print_r($candidates, true));

        // Perform bulk insert
        if (!empty($candidates)) {
            try {
                $check = Candidate::insert($candidates);
                $this->info(count($candidates) . " new candidates imported.");

            } catch (\Exception $e) {
                $this->error('Bulk insert failed: ' . $e->getMessage());
            }
        } else {
            $this->info('No new candidates to insert.');
        }
    }

}
