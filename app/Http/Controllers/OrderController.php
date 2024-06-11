<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Order;
use App\Models\TrackingOrder;
use DataTables;


class OrderController extends Controller
{
    public function index($cryptId){

        return view('modules.candidates.order-history', compact([
            'cryptId'
        ]));
    }

    public function getAjax(Request $request){
        try {
            $string = Crypt::decrypt($request->candidate_id);
            $data = explode('-', $string);
            $id = $data[0];
            $exam_type = $data[1];
        } catch (Illuminate\Contracts\Encryption\DecryptException $e) {

        };

        if ($exam_type == "MUET") {
            $orders = Order::where('muet_calon_id', $id)->latest()->get();
        } else { //MOD
            $orders = Order::where('mod_calon_id', $id)->latest()->get();
        }

        // dd($orders);
        $datas = [];
        foreach ($orders as $key => $value) {
            $datas[] = [
                'no' => $key+1,
                'uniqueOrderId' => $value->unique_order_id,
                'orderDate' => $value->created_at->format('d-m-Y H:i:s'),
                'orderFor' => $value->payment_for,
                'status' =>  $value->payment_status,
                'id' => Crypt::encrypt($value->id),
            ];
        }
        
        return datatables($datas)->toJson();

    }

    public function getAjaxTrackOrder(Request $request){
        try {
            $orderId = Crypt::decrypt($request->order_id);
        } catch (Illuminate\Contracts\Encryption\DecryptException $e) {

        };

        $order = 
        $tracks = TrackingOrder::where('order_id',$orderId)->latest()->get();

        $datas = [];
        foreach ($tracks as $key => $value) {
            $datas[] = [
                'no' => $key+1,
                'date' => $value->created_at->format('d-m-Y H:i:s'),
                'detail' =>  $value->status == "COMPLETED" ? "" : $value->detail,
                'status' =>  $value->status,
                'color'  =>  $value->statusColor($value->status),
                'tracking_number' => !empty($value->tracking_number) ? $value->tracking_number : ''
            ];
        }
        
        return datatables($datas)->toJson();

    }
}
