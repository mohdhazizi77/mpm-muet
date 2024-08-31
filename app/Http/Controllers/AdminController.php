<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Order;
use App\Models\Payment;
use App\Models\ConfigGeneral;
use App\Models\Courier;
use App\Models\CandidateActivityLog;
use Carbon\Carbon;


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

        $orderNewMUET = $order->where('current_status','NEW')->where('type', 'MUET')->where('payment_for', 'MPM_PRINT')->where('payment_status', 'SUCCESS')->count();
        $orderProcessingMUET = $order->where('current_status','PROCESSING')->where('type', 'MUET')->where('payment_for', 'MPM_PRINT')->where('payment_status', 'SUCCESS')->count();
        $orderCompleteMUET = $order->where('current_status','COMPLETED')->where('type', 'MUET')->where('payment_for', 'MPM_PRINT')->where('payment_status', 'SUCCESS')->count();

        $orderNewMOD = $order->where('current_status','NEW')->where('type', 'MOD')->where('payment_for', 'MPM_PRINT')->where('payment_status', 'SUCCESS')->count();
        $orderProcessingMOD = $order->where('current_status','PROCESSING')->where('type', 'MOD')->where('payment_for', 'MPM_PRINT')->where('payment_status', 'SUCCESS')->count();
        $orderCompleteMOD = $order->where('current_status','COMPLETED')->where('type', 'MOD')->where('payment_for', 'MPM_PRINT')->where('payment_status', 'SUCCESS')->count();

        $totalMUET_mpmprint = $payment->where('status', 'SUCCESS')->where('amount','=', $rateMpmPrint)->where('type', 'MUET')->sum('amount');
        $totalMUET_selfprint = $payment->where('status', 'SUCCESS')->where('amount','=', $rateSelfPrint)->where('type', 'MUET')->sum('amount');
        $totalMUET   = $totalMUET_mpmprint + $totalMUET_selfprint;

        $totalMOD_mpmprint = $payment->where('status', 'SUCCESS')->where('amount','=', $rateMpmPrint)->where('type', 'MOD')->sum('amount');
        $totalMOD_selfprint = $payment->where('status', 'SUCCESS')->where('amount','=', $rateSelfPrint)->where('type', 'MOD')->sum('amount');
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
        return view('modules.admin.dashboard',
            compact([
                'user','count','rateMpmPrint', 'rateSelfPrint', 'dailyCounts'
            ]));
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

    public function muetPieChart(){
        $courier = Courier::first();
        $rateCourier = $courier->rate;

        $config = ConfigGeneral::first();
        $rateMpmPrint = $config->rate_mpmprint;
        $rateSelfPrint = $config->rate_selfprint;

        $muetLabels = [
            'RM '.$rateMpmPrint => $rateMpmPrint,
            'RM '.$rateSelfPrint => $rateSelfPrint
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
        return Payment::where('status','SUCCESS')->where('type', $type)->where('amount', $value)->count();
    }

    public function modPieChart(){
        $config = ConfigGeneral::first();
        $rateMpmPrint = $config->rate_mpmprint;
        $rateSelfPrint = $config->rate_selfprint;

        $muetLabels = [
            'RM '.$rateMpmPrint => $rateMpmPrint,
            'RM '.$rateSelfPrint => $rateSelfPrint
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

    public function lineChart(){
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

    public function lineChartViewMuetMod(){
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

    public function lineChartDownloadMuetMod(){
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

    public function viewPullDB(){
        return view('modules.admin.administration.pull-db.index');
    }

    public function pullDatabase(Request $request){
        sleep(5);

        $data = [
            'success' => true,
        ];

        return response()->json($data);
    }
}
