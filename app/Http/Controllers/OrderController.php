<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

use App\Models\Order;
use App\Models\TrackingOrder;
use Carbon\Carbon;
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
                'status' =>  $value->current_status,
                'color'  =>  $value->statusColor($value->current_status),
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

    public function getAjaxTrackShipping(Request $request){

        //$track_no = $request->trackNo
        // Call POS API DO tracking

        $datas = [];
        return datatables($datas)->toJson();

    }

    public function indexAdmin(){
        $user = Auth::User() ? Auth::User() : abort(403);

        return view('modules.admin.report.transaction.index',
            compact([
                'user',
            ]));
    }

    public function getAjaxAdmin(Request $request){
        $transaction = Order::latest();

        // Get the current date in the desired format
        $currentDate = Carbon::now()->format('Y-m-d H:i:s');

        // Apply date range filtering
        if ($request->has('startDateTrx') && !empty($request->startDateTrx)) {
            // Convert startDate and endDate to Carbon instances
            $startDate = Carbon::parse($request->startDateTrx)->startOfDay()->format('Y-m-d H:i:s');
            $endDate = $request->has('endDateTrx') && !empty($request->endDateTrx)
                        ? Carbon::parse($request->endDateTrx)->endOfDay()->format('Y-m-d H:i:s')
                        : $currentDate;

            // Filter based on the date range
            $transaction->whereBetween('created_at', [$startDate, $endDate]);
        }

        if ($request->has('exam_type') && !empty($request->exam_type)) {
            $transaction->where('type', $request->exam_type);
        }

        if ($request->has('payment_for') && !empty($request->payment_for)) {
            $transaction->where('payment_for', $request->payment_for);
        }

        if ($request->has('status') && !empty($request->status)) {
            $transaction->where('current_status', $request->status);
        }

        // Apply filtering based on name search if provided
        if ($request->has('textSearchTrx') && !empty($request->textSearchTrx)) {
            $textSearch = $request->textSearchTrx;
            $transaction->where(function ($query) use ($textSearch) {
                $query->where('unique_order_id', 'LIKE', '%' . $textSearch . '%')
                    // Add more columns to search in if necessary
                    ->orWhere('payment_ref_no', 'LIKE', '%' . $textSearch . '%');
            });
        }

        // list by transaction by role
        switch (Auth::User()->getRoleNames()[0]) {
            case 'PSM':
                // $transaction->where('type', 'MUET');
                $transaction->when($request->filled('exam_type'), function ($query) use ($request) {
                        return $query->where('type', $request->input('exam_type'));
                    }, function ($query) {
                        return $query->where('type', 'MUET');
                    });
                break;
            case 'BPKOM':
                // $transaction->where('type', 'MOD');
                $transaction->when($request->filled('exam_type'), function ($query) use ($request) {
                        return $query->where('type', $request->input('exam_type'));
                    }, function ($query) {
                        return $query->where('type', 'MOD');
                    });
                break;
        }

        // Retrieve the filtered results
        $transaction = $transaction->get();
        // dd($transaction);
        $data = [];
        foreach ($transaction as $key => $value) {
            $data[] = [
                "created_at" => $value->order?->created_at->format('d/m/y H:i:s'),
                "order_id" => $value->order_id,
                "reference_id" => $value->order?->unique_order_id,
                "candidate_name" => $value->order?->candidate?->name,
                "candidate_nric" => $value->order?->candidate?->identity_card_number,
                "cert_type" => $value->type,
                "txn_type" => $value->payment_for,
                "status" => $value->order?->payment_status,

                "payment_date" => $value->payment_date,
                "txn_id" => $value->txn_id,
                "method" => $value->method,
                "amount" => $value->amount,
                "receipt" =>  $value->receipt,
                "receipt_number" =>  $value->receipt_number,
                "ref_no" =>  $value->ref_no
            ];
        }

        return datatables($data)->toJson();
    }
}
