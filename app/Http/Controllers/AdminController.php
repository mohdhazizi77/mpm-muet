<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Order;
use App\Models\Payment;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::User() ? Auth::User() : abort(403);

        $order = Order::get();
        $payment = Payment::get();
        // dd($payment->where('amount','=', 60.0));
        $orderNewMUET = $order->where('current_status','NEW')->where('type', 'MUET')->count();
        $orderProcessingMUET = $order->where('current_status','PROCESSING')->where('type', 'MUET')->count();
        $orderCompleteMUET = $order->where('current_status','COMPLETED')->where('type', 'MUET')->count();

        $orderNewMOD = $order->where('current_status','NEW')->where('type', 'MOD')->count();
        $orderProcessingMOD = $order->where('current_status','PROCESSING')->where('type', 'MOD')->count();
        $orderCompleteMOD = $order->where('current_status','COMPLETED')->where('type', 'MOD')->count();

        $totalMUET60 = $payment->where('amount','=', 60.0)->where('type', 'MUET')->sum('amount');
        $totalMUET20 = $payment->where('amount','=', 20.0)->where('type', 'MUET')->sum('amount');
        $totalMUET   = $totalMUET60 + $totalMUET20;

        $totalMOD60 = $payment->where('amount','=', 60.0)->where('type', 'MOD')->sum('amount');
        $totalMOD20 = $payment->where('amount','=', 20.0)->where('type', 'MOD')->sum('amount');
        $totalMOD   = $totalMOD60 + $totalMOD20;

        $count = [
            "orderNewMUET" => $orderNewMUET,
            "orderProcessingMUET" => $orderProcessingMUET,
            "orderCompleteMUET" => $orderCompleteMUET,
            "orderNewMOD" => $orderNewMOD,
            "orderProcessingMOD" => $orderProcessingMOD,
            "orderCompleteMOD" => $orderCompleteMOD,
            "totalMUET60" => $totalMUET60,
            "totalMUET20" => $totalMUET20,
            "totalMUET" => $totalMUET,
            "totalMOD60" => $totalMOD60,
            "totalMOD20" => $totalMOD20,
            "totalMOD" => $totalMOD,
        ];

        return view('modules.admin.dashboard',
            compact([
                'user','count'
            ]));
    }

    public function muetPieChart(){
        $muetLabels = [
            'RM 20' => 20.0,
            'RM 60' => 60.0
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
        return Payment::where('type', $type)->where('amount', $value)->count();
    }

    public function modPieChart(){
        $muetLabels = [
            'RM 20' => 20.0,
            'RM 60' => 60.0
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
