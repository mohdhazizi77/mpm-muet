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
        $orderProcessingMUET = $order->where('current_status','PROCESSSING')->where('type', 'MUET')->count();
        $orderCompleteMUET = $order->where('current_status','COMPLETE')->where('type', 'MUET')->count();

        $orderNewMOD = $order->where('current_status','NEW')->where('type', 'MOD')->count();
        $orderProcessingMOD = $order->where('current_status','PROCESSSING')->where('type', 'MOD')->count();
        $orderCompleteMOD = $order->where('current_status','COMPLETE')->where('type', 'MOD')->count();

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
}
