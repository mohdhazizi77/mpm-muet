<?php

namespace App\Console\Commands;

use App\Models\MuetCalon;
use App\Models\Candidate;

use Illuminate\Console\Command;
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
        $muetCalonRecords = MuetCalon::all();

        foreach ($muetCalonRecords as $record) {
            $identityCardNumber = $record->kp;

            if (strpos($identityCardNumber, '-') !== false) {
                $identityCardNumber = str_replace('-', '', $identityCardNumber); // buang '-' dekat ic
            }
            // Check if the candidate already exists
            $candidate = Candidate::where('identity_card_number', $identityCardNumber)->first();

            if (!$candidate) {
                // If candidate does not exist, create a new candidate record
                $candidate = new Candidate();
                $candidate->name = $record->nama;
                $candidate->identity_card_number = $identityCardNumber;
                $candidate->password = Hash::make($identityCardNumber);
                $candidate->save();

                // Assign role 'Calon' to the new candidate
                $candidate->assignRole('CALON');

                $this->info("New candidate imported: {$candidate->name}");
            } else {
                $this->info("Candidate already exists: {$candidate->name}");
            }
        }

        $this->info('Import completed.');
    }
}
