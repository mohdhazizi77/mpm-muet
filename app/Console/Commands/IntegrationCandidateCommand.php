<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class IntegrationCandidateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:integration-candidate-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Integration Candidate';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //connect mysql-muet-integration 
        $connection = 'mysql-muet-integration';
        // $table = 'muet_resultn_devsijil';
        $table = 'muet_resultn';
        $result = DB::connection($connection)->table($table)->limit(1)->get();
        dd($result);
    }
}
