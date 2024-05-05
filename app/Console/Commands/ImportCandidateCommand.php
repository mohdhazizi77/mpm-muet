<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportCandidate;

use Storage;


class ImportCandidateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:candidate_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import candidate data from excel import to excel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Script starting ['.date('Y-m-d H:i:s').']');
        Excel::import(new ImportCandidate, Storage::path('importExcelFiles/SenaraiCalon.xlsx'));
        $this->info('Script completed successfully. everything looks good. ['.date('Y-m-d H:i:s').']');
    }
}
