<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Order;
use App\Models\Payment;
use App\Models\ConfigGeneral;
use App\Models\Courier;
use App\Models\CandidateActivityLog;

use App\Models\Candidate;
use App\Models\MuetCalon;
use App\Models\MuetSkor;
use App\Models\MuetTarikh;

use App\Imports\SenaraiCalonExcelImport;
use App\Jobs\ImportCandidateDBJob;
use App\Models\ModCalon;
use App\Models\ModTarikh;
use Carbon\Carbon;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use Maatwebsite\Excel\Facades\Excel;



class AdminController extends Controller
{
    public function index()
    {
        $config = ConfigGeneral::first();
        $courier = Courier::first();
        $rateCourier = $courier->rate;
        $rateMpmPrint = $config->rate_mpmprint;
        $rateSelfPrint = $config->rate_selfprint;
        $user = Auth::User() ? Auth::User() : abort(403);

        $order = Order::get();
        $payment = Payment::get();

        $orderNewMUET = $order->where('current_status', 'NEW')->where('type', 'MUET')->where('payment_for', 'MPM_PRINT')->where('payment_status', 'SUCCESS')->count();
        $orderProcessingMUET = $order->where('current_status', 'PROCESSING')->where('type', 'MUET')->where('payment_for', 'MPM_PRINT')->where('payment_status', 'SUCCESS')->count();
        $orderCompleteMUET = $order->where('current_status', 'COMPLETED')->where('type', 'MUET')->where('payment_for', 'MPM_PRINT')->where('payment_status', 'SUCCESS')->count();

        $orderNewMOD = $order->where('current_status', 'NEW')->where('type', 'MOD')->where('payment_for', 'MPM_PRINT')->where('payment_status', 'SUCCESS')->count();
        $orderProcessingMOD = $order->where('current_status', 'PROCESSING')->where('type', 'MOD')->where('payment_for', 'MPM_PRINT')->where('payment_status', 'SUCCESS')->count();
        $orderCompleteMOD = $order->where('current_status', 'COMPLETED')->where('type', 'MOD')->where('payment_for', 'MPM_PRINT')->where('payment_status', 'SUCCESS')->count();

        $totalMUET_mpmprint = $payment->where('status', 'SUCCESS')->where('amount', '=', $rateMpmPrint)->where('type', 'MUET')->sum('amount');
        $totalMUET_selfprint = $payment->where('status', 'SUCCESS')->where('amount', '=', $rateSelfPrint)->where('type', 'MUET')->sum('amount');
        $totalMUET   = $totalMUET_mpmprint + $totalMUET_selfprint;

        $totalMOD_mpmprint = $payment->where('status', 'SUCCESS')->where('amount', '=', $rateMpmPrint)->where('type', 'MOD')->sum('amount');
        $totalMOD_selfprint = $payment->where('status', 'SUCCESS')->where('amount', '=', $rateSelfPrint)->where('type', 'MOD')->sum('amount');
        $totalMOD   = $totalMOD_mpmprint + $totalMOD_selfprint;

        $count = [
            "orderNewMUET" => $orderNewMUET,
            "orderProcessingMUET" => $orderProcessingMUET,
            "orderCompleteMUET" => $orderCompleteMUET,
            "orderNewMOD" => $orderNewMOD,
            "orderProcessingMOD" => $orderProcessingMOD,
            "orderCompleteMOD" => $orderCompleteMOD,
            "totalMUET_mpmprint" => $totalMUET_mpmprint,
            "totalMUET_selfprint" => $totalMUET_selfprint,
            "totalMUET" => $totalMUET,
            "totalMOD_mpmprint" => $totalMOD_mpmprint,
            "totalMOD_selfprint" => $totalMOD_selfprint,
            "totalMOD" => $totalMOD,
        ];

        $dailyCounts = $this->getDailyActivityCounts();
        // $monthlyCounts = $this->getMonthlyActivityCounts();
        // dd($dailyCounts);
        return view(
            'modules.admin.dashboard',
            compact([
                'user',
                'count',
                'rateMpmPrint',
                'rateSelfPrint',
                'dailyCounts'
            ])
        );
    }

    public function getDailyActivityCounts()
    {
        $today = Carbon::today();

        $loginsCount = CandidateActivityLog::where('activity_type', 'login')
            ->whereDate('created_at', $today)
            ->count();

        $viewsCountMUET = CandidateActivityLog::where('activity_type', 'view_result')
            ->whereDate('created_at', $today)
            ->where('type', 'MUET')
            ->count();

        $downloadsCountMUET = CandidateActivityLog::where('activity_type', 'download_result')
            ->whereDate('created_at', $today)
            ->where('type', 'MUET')
            ->count();

        $viewsCountMOD = CandidateActivityLog::where('activity_type', 'view_result')
            ->whereDate('created_at', $today)
            ->where('type', 'MOD')
            ->count();

        $downloadsCountMOD = CandidateActivityLog::where('activity_type', 'download_result')
            ->whereDate('created_at', $today)
            ->where('type', 'MOD')
            ->count();

        return [
            'logins' => $loginsCount,
            'viewsMUET' => $viewsCountMUET,
            'downloadsMUET' => $downloadsCountMUET,
            'viewsMOD' => $viewsCountMOD,
            'downloadsMOD' => $downloadsCountMOD
        ];
    }

    public function getMonthlyActivityCounts()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $loginsCount = CandidateActivityLog::where('activity_type', 'login')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        $viewsCountMUET = CandidateActivityLog::where('activity_type', 'view_result')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('type', 'MUET')
            ->count();

        $downloadsCountMUET = CandidateActivityLog::where('activity_type', 'download_result')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('type', 'MUET')
            ->count();

        $viewsCountMOD = CandidateActivityLog::where('activity_type', 'view_result')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('type', 'MOD')
            ->count();

        $downloadsCountMOD = CandidateActivityLog::where('activity_type', 'download_result')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('type', 'MOD')
            ->count();

        return [
            'logins' => $loginsCount,
            'viewsMUET' => $viewsCountMUET,
            'downloadsMUET' => $downloadsCountMUET,
            'viewsMOD' => $viewsCountMOD,
            'downloadsMOD' => $downloadsCountMOD
        ];
    }

    public function muetPieChart()
    {
        $courier = Courier::first();
        $rateCourier = $courier->rate;

        $config = ConfigGeneral::first();
        $rateMpmPrint = $config->rate_mpmprint;
        $rateSelfPrint = $config->rate_selfprint;

        $muetLabels = [
            'RM ' . $rateMpmPrint => $rateMpmPrint,
            'RM ' . $rateSelfPrint => $rateSelfPrint
        ];

        $data = [];

        foreach ($muetLabels as $label => $value) {

            $muetData = $this->getMuetCountByLabel($value, 'MUET');

            $data[] = [
                'label' => $label,
                'value' => $muetData
            ];
        }

        return response()->json($data);
    }

    private function getMuetCountByLabel($value, $type)
    {
        return Payment::where('status', 'SUCCESS')->where('type', $type)->where('amount', $value)->count();
    }

    public function modPieChart()
    {
        $config = ConfigGeneral::first();
        $rateMpmPrint = $config->rate_mpmprint;
        $rateSelfPrint = $config->rate_selfprint;

        $muetLabels = [
            'RM ' . $rateMpmPrint => $rateMpmPrint,
            'RM ' . $rateSelfPrint => $rateSelfPrint
        ];

        $data = [];

        foreach ($muetLabels as $label => $value) {
            $muetData = $this->getMuetCountByLabel($value, 'MOD');
            $data[] = [
                'label' => $label,
                'value' => $muetData
            ];
        }

        return response()->json($data);
    }

    public function lineChart()
    {
        $currentYear = now()->year;

        $muetData = Payment::selectRaw('MONTH(payment_date) as month, COUNT(*) as total')
            ->whereYear('payment_date', $currentYear)
            ->where('type', 'MUET')
            ->where('status', 'SUCCESS')
            ->groupByRaw('MONTH(payment_date)')
            ->pluck('total', 'month');

        $modData = Payment::selectRaw('MONTH(payment_date) as month, COUNT(*) as total')
            ->whereYear('payment_date', $currentYear)
            ->where('type', 'MOD')
            ->where('status', 'SUCCESS')
            ->groupByRaw('MONTH(payment_date)')
            ->pluck('total', 'month');

        // Initialize arrays for each month
        $muetCounts = array_fill(1, 12, 0);
        $modCounts = array_fill(1, 12, 0);

        // Fill the arrays with data
        foreach ($muetData as $month => $count) {
            $muetCounts[$month] = $count;
        }
        foreach ($modData as $month => $count) {
            $modCounts[$month] = $count;
        }

        return response()->json([
            'muet' => array_values($muetCounts),
            'mod' => array_values($modCounts),
        ]);
    }

    public function lineChartViewMuetMod()
    {
        $currentYear = now()->year;

        $muetData = CandidateActivityLog::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->where('activity_type', 'view_result')
            ->where('type', 'MUET')
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'month');

        $modData = CandidateActivityLog::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->where('activity_type', 'view_result')
            ->where('type', 'MOD')
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'month');

        // Initialize arrays for each month
        $muetCounts = array_fill(1, 12, 0);
        $modCounts = array_fill(1, 12, 0);

        // Fill the arrays with data
        foreach ($muetData as $month => $count) {
            $muetCounts[$month] = $count;
        }
        foreach ($modData as $month => $count) {
            $modCounts[$month] = $count;
        }

        return response()->json([
            'muet' => array_values($muetCounts),
            'mod' => array_values($modCounts),
        ]);
    }

    public function lineChartDownloadMuetMod()
    {
        $currentYear = now()->year;

        $muetData = CandidateActivityLog::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->where('activity_type', 'download_result')
            ->where('type', 'MUET')
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'month');

        $modData = CandidateActivityLog::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->where('activity_type', 'download_result')
            ->where('type', 'MOD')
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'month');

        // Initialize arrays for each month
        $muetCounts = array_fill(1, 12, 0);
        $modCounts = array_fill(1, 12, 0);

        // Fill the arrays with data
        foreach ($muetData as $month => $count) {
            $muetCounts[$month] = $count;
        }
        foreach ($modData as $month => $count) {
            $modCounts[$month] = $count;
        }

        return response()->json([
            'muet' => array_values($muetCounts),
            'mod' => array_values($modCounts),
        ]);
    }

    public function viewPullDB(Request $request)
    {
        $table = 'muet_resultn';
        $results = 0;
        $results_local = 0;
        // dd($table);
        if (!empty($request->type)) {
            $results = DB::connection('pull-' . strtolower($request->type))->table($table);

            if (!empty($request->year)) {
                $results = $results->where('tahun', $request->year);
            }
            if (!empty($request->session) && strtolower($request->type) == 'muet') {
                $results = $results->where('sesi', $request->session);
            } elseif (!empty($request->session) && strtolower($request->type) == 'mod') {
                $monthName = date('F', mktime(0, 0, 0, $request->session, 1));
                $results = $results->where('namasesi', 'like', '%' . $monthName . '%');
            }

            $results = $results->count();

            $sidang_ = [
                1 => 'JANUARY',
                2 => 'FEBRUARY',
                3 => 'MARCH',
                4 => 'APRIL',
                5 => 'MAY',
                6 => 'JUNE',
                7 => 'JULY',
                8 => 'AUGUST',
                9 => 'SEPTEMBER',
                10 => 'OCTOBER',
                11 => 'NOVEMBER',
                12 => 'DECEMBER',
            ];
            if (strtolower($request->type) == 'muet') {
                $sidangs = MuetTarikh::where('tahun', $request->year)->where('sesi', 'like', '%' . $sidang_[$request->session] . '%')->pluck('sidang')->toArray();
                $results_local = MuetCalon::where('tahun', $request->year)->whereIn('sidang', $sidangs)->count();
            } elseif (strtolower($request->type) == 'mod') {
                $sidangs = ModTarikh::where('tahun', $request->year)->where('sesi', 'like', '%' . $sidang_[$request->session] . '%')->pluck('sidang')->toArray();
                $results_local = ModCalon::where('tahun', $request->year)->whereIn('sidang', $sidangs)->count();
            }
        }
        //get db batch
        $batch = DB::table('job_batches')->where('name', 'PullDBImport')->where('pending_jobs', 1)->whereNull('finished_at')->count();
        return view('modules.admin.administration.pull-db.index', compact('batch', 'results', 'request', 'results_local'));
    }

    public function pullDatabasePost(Request $request)
    {

        // dd($request);
        //pagination datatable with start and length
        // $start = $request->input('start');
        // $length = $request->input('length');
        // $search = $request->input('search.value');

        $data = [];
        // $table = 'muet_resultn_devsijil';
        $table = 'muet_resultn';
        // dd($table);
        if (!empty($request->type)) {
            $results = DB::connection('pull-' . strtolower($request->type))->table($table);

            if (!empty($request->year)) {
                $results = $results->where('tahun', $request->year);
            }
            if (!empty($request->session) && strtolower($request->type) == 'muet') {
                $results = $results->where('sesi', $request->session);
            } elseif (!empty($request->session) && strtolower($request->type) == 'mod') {
                $monthName = date('F', mktime(0, 0, 0, $request->session, 1));
                $results = $results->where('namasesi', 'like', '%' . $monthName . '%');
            }

            $results = $results->count();

            dd($results);
            //based on $start, $length and $search
            // $results = $results->skip($start)->take($length);
            // $results2 = $results->get();

            // //show results by pagination start and length
            // $results = $results2->slice($start, $length);
            // // dd($results);


            // $results = DB::connection('pull-muet')->table($table)->get();
            // foreach ($results as $row) {
            //     if (strtolower($request->type) == 'muet') {
            //         $data[] = [
            //             "muet_id" => $row->muet_id,
            //             "tahun" => $row->tahun,
            //             "sesi" => $row->sesi,
            //             "namasesi" => $row->namasesi,
            //             "nama" => $row->nama,
            //             "kp" => $row->kp,
            //             "indexNo" => $row->indexNo,
            //             "tarikh_isu" => $row->tarikh_isu,
            //             "tarikh_exp" => $row->tarikh_exp,
            //             "listening" => $row->listening,
            //             "speaking" => $row->speaking,
            //             "reading" => $row->reading,
            //             "writing" => $row->writing,
            //             "agg_score" => $row->agg_score,
            //             "band" => $row->band,
            //             "sch_code" => null,
            //             "statusflag" => null,
            //             "status" => $row->status,
            //             "tarload" => $row->tarload ?? null,
            //             "uploaddt" => $row->tarload,
            //         ];
            //     } elseif (strtolower($request->type) == 'mod') {
            //         $data[] = [
            //             "muet_id" => $row->muet_id,
            //             "tahun" => $row->tahun,
            //             "sesi" => $row->sesi,
            //             "namasesi" => $row->namasesi,
            //             "nama" => $row->nama,
            //             "kp" => $row->kp,
            //             "indexNo" => $row->indexNo,
            //             "tarikh_isu" => $row->tarikh_isu,
            //             "tarikh_exp" => $row->tarikh_exp,
            //             "listening" => $row->listening,
            //             "speaking" => $row->speaking,
            //             "reading" => $row->reading,
            //             "writing" => $row->writing,
            //             "agg_score" => $row->agg_score,
            //             "band" => $row->band,
            //             "sch_code" => '',
            //             "statusflag" => 0,
            //             "status" => $row->status,
            //             "uploaddt" => $row->uploaddt,
            //             "tarload" => $row->uploaddt ?? null,
            //         ];
            //     }
            // }
            // return response()->json([
            //     "draw" => $request->input('draw'),
            //     "recordsTotal" => count($results2),
            //     "recordsFiltered" => count($results2),
            //     "data" => $data
            // ]);
        }

        return response()->json([
            "draw" => $request->input('draw'),
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => []
        ]);


        // return datatables($data)->toJson();
    }
    public function pullDatabaseImport(Request $request)
    {
        // $batch = Bus::batch([
        //     new ImportCandidateDBJob($request->year, $request->session, $request->type),
        // ])->name('PullDBImport')->dispatch();

        //dispatch job
        ImportCandidateDBJob::dispatch($request->year, $request->session, $request->type);

        //return json
        // return response()->json($batch);
        return redirect()->route('admin.pullDB')->with('success', 'Importing data from ' . strtoupper($request->type) . ' database has been started.');
    }

    public function indexUpload()
    {
        return view('modules.admin.administration.upload.index');
    }

    public function upload(Request $request)
    {
        // Validate the file
        $validator = Validator::make($request->all(), [
            'examType' => 'required',
            'excelFile' => 'required|file|mimes:xlsx,xls|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $importedData = Excel::toArray(new SenaraiCalonExcelImport, $request->file('excelFile'));
        // data must follow this column => tahun,sesi,namasesi,nama,kp,angkagiliran,tarikh_isu,tarikh_exp,listening,speaking,reading,writing,skor_agregat,band
        $flag = true;
        $flag_msg = '';
        $processArray = [];

        foreach ($importedData[0] as $key => $value) {

            if ($key == 0)
                continue;

            if (empty($value[0]))
                break;

            //checking each column is correct data or not
            $response = $this->checkingColumnExcel($value);

            $value[14] = $response['flag'];
            $value[15] = $response['flag_msg'];

            $message = "";

            if ($value[14]) {
                if ($request->examType == "MUET") {
                    $tahun = $value[0];
                    $sidang = $value[1];
                    $sesi = $value[2];
                    $nama = $value[3];
                    $kp = $value[4];
                    $angka_giliran = $value[5];
                    $tarikh_isu = $value[6];
                    $tarikh_exp = $value[7];
                    $listening = isset($value[8]) ? $value[8] : null;
                    $speaking = isset($value[9]) ? $value[9] : null;
                    $reading = isset($value[10]) ? $value[10] : null;
                    $writing = isset($value[11]) ? $value[11] : null;
                    $skor_agregat = $value[12];
                    $band = $value[13];

                    if (strpos($kp, '-') !== false) {
                        $kp = str_replace('-', '', $kp);
                    }

                    $user = Candidate::updateOrCreate(
                        [
                            'identity_card_number' => $kp,
                        ],
                        [
                            'name'     => $nama,
                            'password' => Hash::make(123456),
                        ]
                    );

                    if (!$user->hasRole('CALON')) {
                        $user->assignRole('CALON');
                    }


                    if ($user->wasRecentlyCreated) {
                        // The record was created
                        $message .= "\nNew Candidate created.";
                    } elseif ($user->wasChanged()) {
                        // Get the updated columns
                        $updatedColumns = $user->getChanges(); // This returns an array of changed attributes
                        foreach ($updatedColumns as $column => $newValue) {
                            if (in_array($column, ['password', 'updated_at']))
                                continue;
                            $message .= "\nData Candidate Updated ['$column' was updated to '$newValue']";
                        }
                    } else {
                        // No changes were made because the values were the same
                        $message .= "\nCandidate no changes";
                    }

                    $parts = explode("/", $angka_giliran);
                    $part1 = $parts[0];
                    $kodnegeri = substr($part1, 0, 2);
                    $kodpusat = substr($part1, 2, 4);
                    $part2 = $parts[1];
                    $jcalon = substr($part2, 0, 1);
                    $nocalon = substr($part2, 1, 3);

                    $calon = MuetCalon::updateOrCreate(
                        [
                            'tahun'           => $tahun,
                            'sidang'          => $sidang,
                            'angka_giliran'   => $angka_giliran,
                        ],
                        [
                            'nama'            => $nama,
                            'kp'              => $kp,
                            'kodnegeri'       => $kodnegeri,
                            'kodpusat'        => $kodpusat,
                            'jcalon'          => $jcalon,
                            'nocalon'         => $nocalon,
                            'alamat1'         => '-',
                            'alamat2'         => '-',
                            'poskod'          => '-',
                            'bandar'          => '-',
                            'negeri'          => '-',
                            'skor_agregat'    => $skor_agregat,
                            'band'            => $band,
                        ]
                    );

                    if ($calon->wasRecentlyCreated) {
                        // The record was created
                        $message .= "\nNew Record MuetCalon created.";
                    } elseif ($calon->wasChanged()) {
                        // Get the updated columns
                        $updatedColumns = $calon->getChanges(); // This returns an array of changed attributes
                        foreach ($updatedColumns as $column => $newValue) {
                            if (in_array($column, ['password', 'updated_at']))
                                continue;

                            $message .= "\nData MuetCalon Updated ['$column' was updated to '$newValue']";
                        }
                    } else {
                        // No changes were made because the values were the same
                        $message .= "\nMuetCalon no changes";
                    }

                    $result = [
                        1 => $listening,
                        2 => $speaking,
                        3 => $reading,
                        4 => $writing,
                    ];

                    foreach ($result as $key => $v) {
                        $ms = MuetSkor::updateOrCreate(
                            [
                                'tahun'      => $tahun,
                                'sidang'     => $sidang,
                                'kodnegeri'  => $kodnegeri,
                                'kodpusat'   => $kodpusat,
                                'jcalon'     => $jcalon,
                                'nocalon'    => $nocalon,
                                'kodkts'     => $key,
                            ],
                            [
                                'mkhbaru'    => $v,
                            ]
                        );

                        if ($ms->wasRecentlyCreated) {
                            // The record was created
                            $message .= "\nNew Record MuetSkor created.[" . $key . "]";
                        } elseif ($ms->wasChanged()) {
                            // Get the updated columns
                            $updatedColumns = $ms->getChanges(); // This returns an array of changed attributes
                            foreach ($updatedColumns as $column => $newValue) {
                                if (in_array($column, ['password', 'updated_at']))
                                    continue;
                                $message .= "\nData MuetSkor Updated ['$column' was updated to '$newValue']";
                            }
                        } else {
                            // No changes were made because the values were the same
                            $message .= "\nMuetSkor no changes";
                        }
                    }

                    $mt = MuetTarikh::updateOrCreate(
                        [
                            'tahun' => $tahun,
                            'sidang' => $sidang,
                            'sesi'              => $sesi,
                        ],
                        [
                            'tarikh_isu'        => $tarikh_isu,
                            'tarikh_exp'        => $tarikh_exp,
                        ]
                    );

                    if ($mt->wasRecentlyCreated) {
                        // The record was created
                        $message .= "\nNew Record MuetTarikh created.[" . $key . "]";
                    } elseif ($mt->wasChanged()) {
                        // Get the updated columns
                        $updatedColumns = $mt->getChanges(); // This returns an array of changed attributes
                        foreach ($updatedColumns as $column => $newValue) {
                            if (in_array($column, ['password', 'updated_at']))
                                continue;
                            $message .= "\nData MuetTarikh Updated ['$column' was updated to '$newValue']";
                        }
                    } else {
                        // No changes were made because the values were the same
                        $message .= "\nMuetTarikh no changes";
                    }

                    // dd($message, $value);
                    $value[15] .= $message;
                } else if ($request->examType == "MOD") {
                } else {
                    $value[15] .= "\n Invalid Exam Type. No processes been done";
                }
            } else {
            }
            $processArray[] = $value;
        }
        // dd($processArray);
        return view('modules.admin.administration.upload.finish', compact('processArray'));
    }

    private function checkingColumnExcel($row)
    {
        $flag = true; // By default is true, will set to false if any column doesn't follow the rules
        $flag_msg = '';

        // Checking each column with validation rules
        // Column 0 => "tahun" (required, must be numeric)
        if (empty($row[0]) || !is_numeric($row[0])) {
            $flag = false;
            $flag_msg .= "\nInvalid 'Tahun'. ";
        }

        // Column 1 => "sesi" (required, must be numeric)
        if (empty($row[1]) || !is_numeric($row[1])) {
            $flag = false;
            $flag_msg .= "\nInvalid 'Sesi'. ";
        }

        // Column 2 => "nama sesi" (required)
        if (empty($row[2])) {
            $flag = false;
            $flag_msg .= "\nInvalid 'Nama Sesi'. ";
        }

        // Column 3 => "nama" (required)
        if (empty($row[3])) {
            $flag = false;
            $flag_msg .= "\nInvalid 'Nama'. ";
        }

        // Column 4 => "kp" (required)
        if (empty($row[4])) {
            $flag = false;
            $flag_msg .= "\nInvalid 'KP'. ";
        }

        // Column 5 => "angka giliran" (required)
        if (empty($row[5])) {
            $flag = false;
            $flag_msg .= "\nInvalid 'Angka Giliran'. ";
        }

        // Column 6 => "tarikh_isu" (required, must be a date)
        if (empty($row[6])) {
            $flag = false;
            $flag_msg .= "\nInvalid 'Tarikh Isu'. ";
        }

        // Column 7 => "tarikh_exp" (required, must be a date)
        if (empty($row[7])) {
            $flag = false;
            $flag_msg .= "\nInvalid 'Tarikh Exp'. ";
        }

        // Column 8 => "listening" (required, must be numeric)
        if (empty($row[8]) || !is_numeric($row[8])) {
            $flag = false;
            $flag_msg .= "\nInvalid 'Listening'. ";
        }

        // Column 9 => "speaking" (required, must be numeric)
        if (empty($row[9]) || !is_numeric($row[9])) {
            $flag = false;
            $flag_msg .= "\nInvalid 'Speaking'. ";
        }

        // Column 10 => "reading" (required, must be numeric)
        if (empty($row[10]) || !is_numeric($row[10])) {
            $flag = false;
            $flag_msg .= "\nInvalid 'Reading'. ";
        }

        // Column 11 => "writing" (required, must be numeric)
        if (empty($row[11]) || !is_numeric($row[11])) {
            $flag = false;
            $flag_msg .= "\nInvalid 'Writing'. ";
        }

        // Column 12 => "skor_agregat" (required, must be numeric)
        if (empty($row[12]) || !is_numeric($row[12])) {
            $flag = false;
            $flag_msg .= "\nInvalid 'Skor Agregat'. ";
        }

        // Column 13 => "band" (required)
        if (empty($row[13])) {
            $flag = false;
            $flag_msg .= "\nInvalid 'Band'. ";
        }

        // Return the result
        return [
            'flag' => $flag,
            'flag_msg' => $flag_msg
        ];
    }
}
