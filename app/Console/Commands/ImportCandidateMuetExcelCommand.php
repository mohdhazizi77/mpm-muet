<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportMuetCandidate;

use Storage;


class ImportCandidateMuetExcelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mpm:import_excel_muet_candidate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import MUET candidate from excel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Script starting ['.date('Y-m-d H:i:s').']');
        Excel::import(new ImportMuetCandidate, Storage::path('importExcelFiles/MUET.xlsx'));
        $this->info('Script completed successfully. everything looks good. ['.date('Y-m-d H:i:s').']');
    }
}
