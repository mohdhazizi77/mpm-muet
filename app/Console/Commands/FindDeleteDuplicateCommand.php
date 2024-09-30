<?php

namespace App\Console\Commands;

use App\Models\MuetCalon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FindDeleteDuplicateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:find-delete-duplicate-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find and Delete MUET Calon & MOD Calon duplications';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        DB::statement("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
        $finds = MuetCalon::select('id', 'nama', 'kp', 'tahun', 'sidang', 'angka_giliran', 'nocalon', 'kodpusat', 'kodnegeri', 'jcalon', DB::raw('count(*) as total'))
            ->groupBy('nama', 'kp', 'tahun', 'sidang', 'angka_giliran', 'nocalon', 'kodpusat', 'kodnegeri', 'jcalon')
            ->havingRaw('count(*) > 1')
            // ->where('kp', '931011065682')
            ->get();
        $deleteIds = [];
        foreach ($finds as $index => $row) {
            if ($row->total > 1) {
                $find2 = MuetCalon::where('kp', $row->kp)
                    ->where('tahun', $row->tahun)
                    ->where('sidang', $row->sidang)
                    ->where('angka_giliran', $row->angka_giliran)
                    ->where('nocalon', $row->nocalon)
                    ->where('kodpusat', $row->kodpusat)
                    ->where('kodnegeri', $row->kodnegeri)
                    ->where('jcalon', $row->jcalon)
                    ->get();

                foreach ($find2 as $index2 => $row2) {
                    if ($index2 > 0) {
                        $deleteIds[] = $row2->id;
                    }
                }
                // dd($find2, $deleteIds);
            }
        }
        $this->info("Total Rows: " . count($finds));
        $this->info("Delete Ids Count: " . count($deleteIds));
        $this->info("Deleting...");
        MuetCalon::whereIn('id', $deleteIds)->delete();
        $this->info("Deleted");
    }
}
