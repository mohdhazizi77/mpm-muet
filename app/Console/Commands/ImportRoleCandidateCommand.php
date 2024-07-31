<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

use App\Models\Candidate;

class ImportRoleCandidateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mpm:import_candidate_role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userCount = Candidate::count();
        $progressBar = $this->output->createProgressBar($userCount);

        $progressBar->start();

        Candidate::chunk(100, function ($users) use ($progressBar) {
            foreach ($users as $user) {
                try {
                    $user->assignRole('CALON');
                } catch (\Exception $e) {
                    Log::error('Failed to assign role to user ID ' . $user->id . ': ' . $e->getMessage());
                }
                $progressBar->advance();
            }
        });

        $progressBar->finish();
    }
}
