<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ProcessImport;
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
        $this->info('Script starting [' . date('Y-m-d H:i:s') . ']');
        ProcessImport::dispatch(resource_path('excel/importExcelFiles/MUET 2022-2023.xlsx'));
        $this->info('Import job dispatched. [' . date('Y-m-d H:i:s') . ']');
    }
}
