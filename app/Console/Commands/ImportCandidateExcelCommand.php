<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportMuetCandidate;
use App\Imports\ImportModCandidate;

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
        Excel::import(new ImportMuetCandidate, resource_path('excel/importExcelFiles/MUET.xlsx'));
        Excel::import(new ImportModCandidate, resource_path('excel/importExcelFiles/MOD.xlsx'));

        $this->info('Script completed successfully. everything looks good. ['.date('Y-m-d H:i:s').']');
    }
}
