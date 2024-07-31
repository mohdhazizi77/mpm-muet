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

        // Excel::import(new ImportMuetCandidate, resource_path('excel/importExcelFiles/MUET.xlsx'));
        // Excel::import(new ImportModCandidate, resource_path('excel/importExcelFiles/MOD.xlsx'));

        $arr = [
            // 2022,2023,2024
            // 2023
            // 2024
        ];

        // foreach ($arr as $key => $year) {
        //     Excel::import(new ImportMuetCandidate, resource_path('excel/importExcelFiles/Data Sijil MUET/data sijil MUET '.$year.'.csv'));
        // }

        // for ($i=1; $i < 10; $i++) {
        // for ($i=10; $i < 20; $i++) {
        // for ($i=20; $i < 33; $i++) {
            // Excel::import(new ImportMuetCandidate, resource_path('excel/importExcelFiles/MUET_2022-2023_chunks/MUET 2022-2023('.$i.').csv'));
        // }

        // Excel::import(new ImportMuetCandidate, resource_path('excel/importExcelFiles/First_10000.csv'));
        // Excel::import(new ImportMuetCandidate, resource_path('excel/importExcelFiles/MUET 2022-2023.xlsx'));

        $this->info('Script completed successfully. everything looks good. ['.date('Y-m-d H:i:s').']');
    }
}
