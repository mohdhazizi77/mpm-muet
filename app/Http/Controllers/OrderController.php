<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;


use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\TransactionExport;
use App\Models\Order;
use App\Models\Payment;
use App\Models\ConfigMpmBayar;
use App\Models\ConfigPoslaju;

use App\Models\TrackingOrder;
use Carbon\Carbon;
use DataTables;


class OrderController extends Controller
{
    public function index($cryptId)
    {

        return view('modules.candidates.order-history', compact([
            'cryptId'
        ]));
    }

    public function getAjax(Request $request)
    {
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
                'no' => $key + 1,
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

    public function getAjaxTrackOrder(Request $request)
    {
        try {
            $orderId = Crypt::decrypt($request->order_id);
        } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
        };

        $tracks = TrackingOrder::where('order_id', $orderId)->latest()->get();

        $datas = [];
        foreach ($tracks as $key => $value) {
            $datas[] = [
                'no' => $key + 1,
                'date' => $value->created_at->format('d-m-Y H:i:s'),
                'detail' =>  $value->detail,
                'status' =>  $value->status,
                'color'  =>  $value->statusColor($value->status),
                'tracking_number' => !empty($value->tracking_number) ? $value->tracking_number : ''
            ];
        }

        return datatables($datas)->toJson();
    }

    public function getAjaxTrackShipping(Request $request)
    {

        $track_no = $request->trackNo;
        if (empty($track_no)) {
            return datatables([])->toJson();
        }

        // Replace these with actual values or retrieve from config/environment
        $culture = 'EN';
        $bearerToken = Session::get('bearer_token');;

        $ConfigPoslaju = ConfigPoslaju::first();

        try {
            $response = Http::withToken($bearerToken)
                ->get($ConfigPoslaju->url . '/as2corporate/v2trackntracewebapijson/v1/api/Details', [
                    'id' => $track_no,
                    'Culture' => $culture,
                ]);
            if ($response->successful()) {
                $data = [];
                $response = json_decode($response->getBody()->getContents());
                foreach ($response as $key => $value) {

                    if ($value->type == "Invalid Request/Empty Connote") {
                        continue;
                    }
                    $data[] = [
                        'no' => $key + 1,
                        'date' => $value->date,
                        'detail' => $value->process
                    ];
                }
                return datatables($data)->toJson();
            } else {
                return response()->json(['error' => 'Failed to fetch data'], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function indexAdmin()
    {
        $user = Auth::User() ? Auth::User() : abort(403);

        return view(
            'modules.admin.report.transaction.index',
            compact([
                'user',
            ])
        );
    }

    public function getAjaxAdmin(Request $request)
    {
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
        $data = [];
        $session = '-'; // Default value
        if ($value->muet_calon_id != null) {
            if (isset($value->muetCalon->getTarikh->sesi)) {
                $session = $value->muetCalon->getTarikh->sesi;
            } elseif (isset($value->modCalon->getTarikh->sesi)) {
                $session = $value->modCalon->getTarikh->sesi;
            }
        }
        foreach ($transaction as $key => $value) {
            $data[] = [
                'id'         => Crypt::encrypt($value->id),
                "created_at" => $value->created_at->format('d/m/y H:i:s'),
                "order_id" => $value->order_id,
                "reference_id" => $value->unique_order_id,
                "candidate_name" => $value->candidate->name,
                "candidate_nric" => $value->candidate->identity_card_number,
                "session" => $session,
                "cert_type" => $value->type,
                "txn_type" => $value->payment_for,
                // "status" => $value->order?->payment_status,
                "status" => $value->current_status,

                "payment_date" => $value->payment_date,
                "txn_id" => $value->txn_id,
                "method" => $value->method,
                "amount" => $value->amount,
                "receipt" =>  $value->receipt,
                "receipt_number" =>  $value->receipt_number,
                "ref_no" =>  $value->ref_no
            ];

            // if ($value->muet_calon_id != null) {
            //     $data[]['session'] = $value->muetCalon->getTarikh->sesi;
            // } else {
            //     $data[]['session'] = $value->modCalon->getTarikh->sesi;
            // }
        }

        // Apply text search after building the array
        if ($request->has('textSearch') && !empty($request->textSearch)) {
            $textSearch = $request->textSearch;
            $data = array_filter($data, function ($item) use ($textSearch) {
                return stripos($item['tracking_number'], $textSearch) !== false ||
                    stripos($item['index_number'], $textSearch) !== false ||
                    stripos($item['candidate_name'], $textSearch) !== false ||
                    stripos($item['order_id'], $textSearch) !== false;
            });
        }

        return datatables($data)->toJson();
    }

    public function generateExcelAdmin(Request $request)
    {

        $currentDate = Carbon::now()->format('Y-m-d H:i:s');
        $transactions = Order::latest();
        // list by transaction by role
        switch (Auth::User()->getRoleNames()[0]) {
            case 'PSM':
                // $transactions->where('type', 'MUET');
                $transactions->when($request->filled('exam_type'), function ($query) use ($request) {
                    return $query->where('type', $request->input('exam_type'));
                }, function ($query) {
                    return $query->where('type', 'MUET');
                });
                break;
            case 'BPKOM':
                // $transactions->where('type', 'MOD');
                $transactions->when($request->filled('exam_type'), function ($query) use ($request) {
                    return $query->where('type', $request->input('exam_type'));
                }, function ($query) {
                    return $query->where('type', 'MOD');
                });
                break;
        }

        if (filled($request->startDate) || filled($request->endDate)) {
            $startDate = Carbon::parse($request->startDate)->startOfDay()->format('Y-m-d H:i:s');
            $endDate = $request->has('endDateTrx') && !empty($request->endDate)
                ? Carbon::parse($request->endDate)->endOfDay()->format('Y-m-d H:i:s')
                : $currentDate;

            // Filter based on the date range
            $transactions->whereBetween('created_at', [$startDate, $endDate]);
        }

        if ($request->has('exam_type') && !empty($request->exam_type)) {
            $transactions->where('type', $request->exam_type);
        }

        if ($request->has('payment_for') && !empty($request->payment_for)) {
            $transactions->where('payment_for', $request->payment_for);
        }

        if ($request->has('status_trx') && !empty($request->status_trx)) {
            $transactions->where('current_status', $request->status_trx);
        }

        if (filled($request->textSearch)) {
            $textSearch = $request->textSearch;
            $transactions->where(function ($query) use ($textSearch) {
                $query->where('unique_order_id', 'LIKE', '%' . $textSearch . '%');
                // Add more columns to search in if necessary
                // ->orWhere('ref_no', 'LIKE', '%' . $textSearch . '%');
            });
        }

        $transactions = $transactions->get();

        return Excel::download(new TransactionExport($transactions), 'transaction_' . now() . '.xlsx');
    }

    public function generatePdfAdmin(Request $request)
    {

        $currentDate = Carbon::now()->format('Y-m-d H:i:s');

        $transactions = Order::latest();
        // list by transaction by role
        switch (Auth::User()->getRoleNames()[0]) {
            case 'PSM':
                // $transactions->where('type', 'MUET');
                $transactions->when($request->filled('type'), function ($query) use ($request) {
                    return $query->where('type', $request->input('type'));
                }, function ($query) {
                    return $query->where('type', 'MUET');
                });
                break;
            case 'BPKOM':
                // $transactions->where('type', 'MOD');
                $transactions->when($request->filled('type'), function ($query) use ($request) {
                    return $query->where('type', $request->input('type'));
                }, function ($query) {
                    return $query->where('type', 'MOD');
                });
                break;
        }
        if (filled($request->startDate) || filled($request->endDate)) {
            $startDate = Carbon::parse($request->startDate)->startOfDay()->format('Y-m-d H:i:s');
            $endDate = $request->has('endDateTrx') && !empty($request->endDate)
                ? Carbon::parse($request->endDate)->endOfDay()->format('Y-m-d H:i:s')
                : $currentDate;

            // Filter based on the date range
            $transactions->whereBetween('created_at', [$startDate, $endDate]);
        }

        if ($request->has('exam_type') && !empty($request->exam_type)) {
            $transactions->where('type', $request->exam_type);
        }

        if ($request->has('payment_for') && !empty($request->payment_for)) {
            $transactions->where('payment_for', $request->payment_for);
        }

        if ($request->has('status_trx') && !empty($request->status_trx)) {
            $transactions->where('current_status', $request->status_trx);
        }

        if (filled($request->textSearch)) {
            $textSearch = $request->textSearch;
            $transactions->where(function ($query) use ($textSearch) {
                $query->where('unique_order_id', 'LIKE', '%' . $textSearch . '%');
                // Add more columns to search in if necessary
                // ->orWhere('ref_no', 'LIKE', '%' . $textSearch . '%');
            });
        }

        $transactions = $transactions->get();

        $pdf = PDF::loadView('modules.admin.report.transaction.pdf.transaction', ['transactions' => $transactions])
            ->setPaper('a4', 'landscape');  // Set paper size to A4 and orientation to landscape

        return $pdf->stream('ListTransaction.pdf');
    }

    public function checkpaymentAdmin(Request $request)
    {

        $order = Order::where('payment_ref_no', $request->ref_no)->first();
        $payment = Payment::where('ref_no', $request->ref_no)->first();

        // $url = 'https://ebayar-lab.mpm.edu.my/api/payment/status';
        // $token = 'a2aWmIGjPSVZ8F3OvS2BtppKM2j6TKvKXE7u8W7MwbkVyZjwZfSYdNP5ACem';
        // $secret_key = '1eafc1e9-df86-4c8c-a3de-291ada259ab0';

        $url = ConfigMpmBayar::first()->url . '/api/payment/status';
        $token = ConfigMpmBayar::first()->token;
        $secret_key = ConfigMpmBayar::first()->secret_key;

        $data = [
            "ref_no" => $request->ref_no,
        ];

        $output = '';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'MPMToken: ' . $token
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($curl);
        $output = json_decode($output);

        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            // var_dump($error_msg);
            // exit();
            curl_close($curl);

            $arr = [
                'success' => false,
                'message' => $error_msg->message
            ];

            return response()->json($arr);
        }
        if (!empty($output->data)) {
            curl_close($curl);
            if (in_array($output->data->txn_status, ['FAILED'])) {
                $order->update(
                    [
                        'payment_status' => $output->data->txn_status,
                        'current_status' => $output->data->txn_status,
                        'payment_ref_no' => $output->data->ref_no,
                    ]
                );
            }else{
                $order->update(
                    [
                        'payment_status' => $output->data->txn_status,
                        // 'current_status' => $output->data->txn_status,
                        'payment_ref_no' => $output->data->ref_no,
                    ]
                );
            }

            $cust_info = [
                'full_name' => $output->data->full_name,
                'nric'      => $output->data->nric,
                'email'     => $output->data->email_address,
                'phoneNum'  => $output->data->phone_number,
            ];

            $payment->update(
                [
                    'status' => $output->data->txn_status,
                    'method' => $output->data->txn_type,
                    'txn_id' => $output->data->txn_id,
                    'cust_info' => serialize($cust_info),
                    'receipt' => $output->data->receipt_url,
                    'receipt_number' => $output->data->receipt_no,
                    'payment_for' => json_decode($output->data->extra_data)->pay_for,
                    'payment_date' => $output->data->txn_time,
                ]
            );
        } else {
            // echo "Payment Gateway tidak dapat disambung. Pastikan URL dan TOKEN adalah betul.";
            curl_close($curl);

            $arr = [
                'success' => false,
                'message' => "Payment Gateway tidak dapat disambung. Pastikan URL dan TOKEN adalah betul."
            ];

            return response()->json($arr);
        }

        $arr = [
            'success' => true,
            'message' => "Payment status updated"
        ];

        return response()->json($arr);
    }
}
