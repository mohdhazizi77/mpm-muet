<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportCandidate;

use Storage;


class ImportCandidateExcelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mpm:import_excel_candidate_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import candidate data from excel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Script starting ['.date('Y-m-d H:i:s').']');
        Excel::import(new ImportMuetCandidate, storage_path('app/public/importExcelFiles/SenaraiCalon.xlsx'));
        $this->info('Script completed successfully. everything looks good. ['.date('Y-m-d H:i:s').']');
    }
}
