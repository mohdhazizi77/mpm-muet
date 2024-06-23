<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportModCandidate;

use Storage;


class ImportCandidateModExcelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mpm:import_excel_mod_candidate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import MOD candidate from excel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Script starting ['.date('Y-m-d H:i:s').']');
        Excel::import(new ImportModCandidate, Storage::path('importExcelFiles/MOD.xlsx'));
        $this->info('Script completed successfully. everything looks good. ['.date('Y-m-d H:i:s').']');
    }
}
