<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Order;
use App\Models\Payment;
use App\Models\ConfigGeneral;
use App\Models\Courier;

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
        // dd($payment->where('amount','=', 60.0));
        $orderNewMUET = $order->where('current_status','NEW')->where('type', 'MUET')->where('payment_for', 'MPM_PRINT')->count();
        $orderProcessingMUET = $order->where('current_status','PROCESSING')->where('type', 'MUET')->where('payment_for', 'MPM_PRINT')->count();
        $orderCompleteMUET = $order->where('current_status','COMPLETED')->where('type', 'MUET')->where('payment_for', 'MPM_PRINT')->count();

        $orderNewMOD = $order->where('current_status','NEW')->where('type', 'MOD')->where('payment_for', 'MPM_PRINT')->count();
        $orderProcessingMOD = $order->where('current_status','PROCESSING')->where('type', 'MOD')->where('payment_for', 'MPM_PRINT')->count();
        $orderCompleteMOD = $order->where('current_status','COMPLETED')->where('type', 'MOD')->where('payment_for', 'MPM_PRINT')->count();

        // $totalMUET_mpmprint = $payment->where('amount','=', ($rateMpmPrint+$rateCourier))->where('type', 'MUET')->sum('amount');
        $records = $payment->where('amount','=', ($rateMpmPrint+$rateCourier))->where('type', 'MUET')->pluck('amount');
        // dd($totalMUET_mpmprint);
        $totalMUET_mpmprint = 0;
        foreach ($records as $key => $value) {
            $totalMUET_mpmprint += $value - $rateCourier;
        }
        $totalMUET_selfprint = $payment->where('amount','=', $rateSelfPrint)->where('type', 'MUET')->sum('amount');
        $totalMUET   = $totalMUET_mpmprint + $totalMUET_selfprint;

        $totalMOD_mpmprint = $payment->where('amount','=', ($rateMpmPrint+$rateCourier))->where('type', 'MOD')->sum('amount');
        $totalMOD_selfprint = $payment->where('amount','=', $rateSelfPrint)->where('type', 'MOD')->sum('amount');
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

        return view('modules.admin.dashboard',
            compact([
                'user','count','rateMpmPrint', 'rateSelfPrint'
            ]));
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

            if ($label == 'RM '.$rateSelfPrint) {
                $muetData = $this->getMuetCountByLabel($value, 'MUET');
            } else {
                $muetData = $this->getMuetCountByLabel($value+$rateCourier, 'MUET');
            }
            
            $data[] = [
                'label' => $label,
                'value' => $muetData
            ];
        }

        return response()->json($data);
    }

    private function getMuetCountByLabel($value, $type)
    {
        return Payment::where('type', $type)->where('amount', $value)->count();
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
            ->groupByRaw('MONTH(payment_date)')
            ->pluck('total', 'month');

        $modData = Payment::selectRaw('MONTH(payment_date) as month, COUNT(*) as total')
            ->whereYear('payment_date', $currentYear)
            ->where('type', 'MOD')
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
}
