<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportMuetCandidateCsv;

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
        $this->info('Script starting [' . date('Y-m-d H:i:s') . ']');
        Excel::import(new ImportMuetCandidateCsv, resource_path('excel/importExcelFiles/MUET/MUET-S2-2024-markah-sijil-online-berubah-19-calon.csv'));
        Excel::import(new ImportMuetCandidateCsv, resource_path('excel/importExcelFiles/MUET/MUET-S2-2024-tambahan-1-calon.csv'));
        // Excel::import(new ImportMuetCandidate, resource_path('excel/importExcelFiles/MUET.xlsx'));

        $this->info('Script completed successfully. everything looks good. [' . date('Y-m-d H:i:s') . ']');
    }
}
