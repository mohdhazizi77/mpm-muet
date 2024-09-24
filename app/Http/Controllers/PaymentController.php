<?php

namespace App\Http\Controllers;

use App\Exports\TransactionExport;
use App\Notifications\OrderReceivedNotification;
use App\Notifications\OrderConfirmedNotification;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\PaymentRequest;
use App\Models\Candidate;
use App\Models\Courier;
use App\Models\Order;
use App\Models\Payment;
use App\Models\TrackingOrder;
use App\Models\ConfigGeneral;
use App\Models\ConfigMpmBayar;
use App\Models\ConfigPoslaju;


use Maatwebsite\Excel\Facades\Excel;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;

use DataTables;

class PaymentController extends Controller
{


    public function index()
    {
        $user = Auth::User() ? Auth::User() : abort(403);

        return view(
            'modules.admin.report.transaction.index',
            compact([
                'user',
            ])
        );
    }

    public function getAjax(Request $request)
    {
        $transaction = Payment::latest();

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
            $transaction->whereBetween('payment_date', [$startDate, $endDate]);
        }

        if ($request->has('exam_type') && !empty($request->exam_type)) {
            $transaction->where('type', $request->exam_type);
        }

        if ($request->has('payment_for') && !empty($request->payment_for)) {
            $transaction->where('payment_for', $request->payment_for);
        }

        if ($request->has('status') && !empty($request->status)) {
            $transaction->where('status', $request->status);
        }

        // Apply filtering based on name search if provided
        if ($request->has('textSearchTrx') && !empty($request->textSearchTrx)) {
            $textSearch = $request->textSearchTrx;
            $transaction->where(function ($query) use ($textSearch) {
                $query->where('txn_id', 'LIKE', '%' . $textSearch . '%')
                    // Add more columns to search in if necessary
                    ->orWhere('ref_no', 'LIKE', '%' . $textSearch . '%');
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
        foreach ($transaction as $key => $value) {
            $calon = $value->order?->muet_calon_id != null ? $value->order?->muetCalon : $value->order?->modCalon;
            $data[] = [
                "created_at" => $value->order?->created_at->format('d/m/y H:i:s'),
                "order_id" => $value->order_id,
                "reference_id" => $value->order?->unique_order_id,
                "candidate_name" => $value->order?->candidate?->name,
                "candidate_nric" => $value->order?->candidate?->identity_card_number,
                "cert_type" => $value->type,
                "txn_type" => $value->payment_for,
                "status" => $value->order?->payment_status,
                // "session" => $calon->getTarikh->sesi,
                "session" => "SESSION " . $calon->sidang . " YEAR " . $calon->tahun,

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

    public function makepayment(PaymentRequest $request)
    {
        try {
            $string = Crypt::decrypt($request->crypt_id);
            $data = explode('-', $string);
            $id = $data[0];
            $exam_type = $data[1];
        } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
            dd($e);
        };

        //sanitize name
        $name = preg_replace('/[^A-Za-z0-9 ]/', '', $request->name);
        $phone_num = '0' . $request->phone_num;

        // $url = 'https://ebayar-lab.mpm.edu.my/api/payment/create';
        // $token = 'a2aWmIGjPSVZ8F3OvS2BtppKM2j6TKvKXE7u8W7MwbkVyZjwZfSYdNP5ACem';
        // $secret_key = '1eafc1e9-df86-4c8c-a3de-291ada259ab0';

        $url = ConfigMpmBayar::first()->url . '/api/payment/create';
        $token = ConfigMpmBayar::first()->token;
        $secret_key = ConfigMpmBayar::first()->secret_key;

        $extra_data = [
            'pay_for' => $request->pay_for, // SELF_PRINT or MPM_PRINT
            'exam_type' => $exam_type, // MUET or MOD
            'courier' => !empty($request->courier) ? $request->courier : '', // N/A or courier_ID
        ];

        $data = [
            "full_name" => $name,
            "phone_number" => $phone_num,
            "email_address" => $request->email,
            "nric" => $request->nric,
            "extra_data" => json_encode($extra_data),
        ];

        $config = ConfigGeneral::get()->first();

        //kalau MPM_PRINT amount courier atau SELF_PRINT get .env value SELFPRINT_AMOUNT
        $data['amount'] = empty($request->courier) ? $config->rate_selfprint : $config->rate_mpmprint;
        $hash = hash_hmac('SHA256', urlencode($secret_key) . urlencode($data['full_name']) . urlencode($data['phone_number']) . urlencode($data['email_address']) . urlencode($data['amount']), $secret_key);
        $data['hash'] = $hash;

        // $pendingOrder = Order::where(function ($query) use ($exam_type, $id) {
        //     if ($exam_type == "MUET") {
        //         $query->where('muet_calon_id', $id);
        //     } elseif ($exam_type == "MOD") {
        //         $query->where('mod_calon_id', $id);
        //     }
        // })->where('payment_for', $request->pay_for)
        // ->where('payment_status', 'PENDING')
        // ->latest()
        // ->first();

        // if ($pendingOrder) {
        //     $ref_no = $pendingOrder->payment_ref_no;
        //     $url = "https://ebayar-lab.mpm.edu.my/payments/" .$ref_no. "/gateway";
        //     header("Location: " . $url);
        //     exit();
        // }

        $output = $this->createPayment($url, $data, $token);

        if (isset($output->ref_no) !== true) {
            Session::flash('error', $output);
            return redirect()->back();
        }

        // Create new order
        $order = new Order();
        // $order->unique_order_id = Uuid::uuid4()->toString();
        $order->unique_order_id = self::generateOrderId($exam_type);
        $order->payment_ref_no = $output->ref_no;
        $order->candidate_id = Auth::User()->id;
        $order->name = $name;
        $order->email = $request->email;
        $order->phone_num = $phone_num;
        $order->payment_for = $request->pay_for;
        $order->address1 = $request->address;
        $order->postcode = $request->postcode;
        $order->city = $request->city;
        $order->state = $request->state;
        $order->type = $exam_type;
        $order->payment_status = 'PENDING';
        if ($exam_type == "MUET")
            $order->muet_calon_id = $id;
        else
            $order->mod_calon_id = $id;

        $order->save();

        // Store the order ID in the session
        Session::put('payment_ref_no', $order->payment_ref_no);

        $payment = new Payment();
        $payment->order_id = $order->id;
        $payment->status = 'PENDING';
        $payment->ref_no = $output->ref_no;
        $payment->type = $exam_type;
        $payment->payment_date = date('d-m-y H:i:s');
        $payment->amount = $data['amount'];
        $payment->save();

        header("Location: " . $output->url);
        exit();
    }

    public function paymentstatus(Request $request)
    {
        if (!empty($_GET['full_name'])) {
            $full_name = $_GET['full_name'];
            $email = $_GET['email'];
            $amount = $_GET['amount'];
            $phone = $_GET['phone'];
            $status = $_GET['status'];
            $ref_no = $_GET['ref_no'];
            $type = $_GET['type'];
            $txn_id = $_GET['id_transaction'];
            $txn_time = $_GET['txn_time'];
            $nric = $_GET['nric'];
            $extra_data = explode("-", $_GET['extra_data']);
            $hash = $_GET['hash'];
        } elseif (!empty($_POST['full_name'])) {
            $full_name = $_POST['full_name'];
            $email = $_POST['email'];
            $amount = $_POST['amount'];
            $phone = $_POST['phone'];
            $status = $_POST['status'];
            $ref_no = $_POST['ref_no'];
            $type = $_POST['type'];
            $txn_id = $_POST['id_transaction'];
            $txn_time = $_POST['txn_time'];
            $nric = $_POST['nric'];
            $extra_data = explode("-", $_POST['extra_data']);
            $hash = $_POST['hash'];
        }

        // $secret_key = '1eafc1e9-df86-4c8c-a3de-291ada259ab0';
        $secret_key = ConfigMpmBayar::first()->secret_key;
        $hashed = hash_hmac('SHA256', urlencode($secret_key) . urlencode($full_name) . urlencode($phone) . urlencode($email) . urlencode($amount), $secret_key);

        if ($hash != $hashed) {
            die("Hash tidak sah.");
        } else {
            if ($status == 'SUCCESS') {
                return view('modules.candidates.print-mpm-return', compact([
                    'status',
                    'ref_no',
                    'txn_id',
                ]));
            } elseif ($status == 'FAILED') {
                return view('modules.candidates.print-mpm', compact([
                    'status',
                    'ref_no',
                    'txn_id',
                ]));
            }
        }
    }

    public function getpayment(Request $request)
    {

        $configGeneral = ConfigGeneral::get()->first();

        // update order
        $order = Order::where('payment_ref_no', $request->ref_no)->first();

        if (!$order) {
            // show return to view
            return redirect()->back();
        }

        $secret_key = ConfigMpmBayar::first()->secret_key;
        $hashed = hash_hmac('SHA256', urlencode($secret_key) . urlencode($request->full_name) . urlencode($request->phone) . urlencode($request->email) . urlencode($request->amount), $secret_key);
        //check for valid data only can pass
        if ($request->hash != $hashed) {
            die("Hash tidak sah.");
        }

        // dd($request->toArray());
        // add payment record
        if ($request->status == "SUCCESS") {

            $order->payment_status = 'SUCCESS';
            // $order->current_status = 'SUCCESS';
            // SELF_PRINT
            // MPM_PRINT
            $data = json_decode($request->extra_data, 1);

            try {
                // $payment = new Payment();
                // $payment->order_id = $order->id;
                // $payment->payment_date = $request->txn_time;
                // $payment->method = $request->type;
                // $payment->amount = $request->amount;
                // $payment->status = $request->status;
                // $payment->txn_id = $request->txn_id;
                // $payment->ref_no = $request->ref_no;
                // $payment->cust_info = serialize(array("full_name" => $request->full_name, "email" => $request->email, "phoneNum" => $request->phone));
                // $payment->receipt = $request->receipt;
                // $payment->receipt_number = $request->receipt_number;
                // $payment->error_message = "";
                // $payment->payment_for = $order->payment_for;
                // $payment->type = $order->type;
                // $payment->save();
                sleep(3);
                $payment = Payment::updateOrCreate(
                    ['ref_no' => $request->ref_no],
                    [
                        'order_id' => $order->id,
                        'payment_date' => $request->txn_time,
                        'method' => $request->type,
                        'amount' => $request->amount,
                        'status' => $request->status,
                        'txn_id' => $request->txn_id,
                        'cust_info' => serialize(array("full_name" => $request->full_name, "email" => $request->email, "phoneNum" => $request->phone)),
                        'receipt' => $request->receipt,
                        'receipt_number' => $request->receipt_number,
                        'error_message' => "",
                        'payment_for' => $order->payment_for,
                        'type' => $order->type,
                    ]
                );

                // $payment = Payment::updateOrCreate(
                //     [
                //         'order_id' => $order->id,
                //     ],
                //     [
                //         'payment_date' =>$request->txn_time,
                //         'method' => $request->type,
                //         'amount' => $request->amount,
                //         'status' => $request->status,
                //         'txn_id' => $request->txn_id,
                //         'ref_no' => $request->ref_no,
                //         'cust_info' => serialize(array("full_name"=>$request->full_name, "email"=>$request->email, "phoneNum"=>$request->phone)),
                //         'receipt' => $request->receipt,
                //         'receipt_number' =>$request->receipt_number,
                //         'error_message' => "",
                //         'payment_for' => $order->payment_for,
                //         'type' => $order->type,
                //     ]
                // );

                if ($order->payment_for == 'MPM_PRINT') {

                    // $track = new TrackingOrder();
                    // $track->order_id = $order->id;
                    // $track->detail = 'Payment made';
                    // $track->status = 'PAID';
                    // $track->save();

                    TrackingOrder::firstOrCreate(
                        ['order_id' => $order->id, 'status' => 'PAID'],
                        ['detail' => 'Payment made']
                    );

                    // $track = new TrackingOrder();
                    // $track->order_id = $order->id;
                    // $track->detail = 'Admin received order';
                    // $track->status = 'NEW';
                    // $track->save();

                    TrackingOrder::firstOrCreate(
                        ['order_id' => $order->id, 'status' => 'NEW'],
                        ['detail' => 'Admin received order']
                    );

                    $order->current_status = 'NEW';
                } elseif ($order->payment_for == 'SELF_PRINT') {

                    // $track = new TrackingOrder();
                    // $track->order_id = $order->id;
                    // $track->detail = 'Payment made';
                    // $track->status = 'PAID';
                    // $track->save();

                    TrackingOrder::firstOrCreate(
                        ['order_id' => $order->id, 'status' => 'PAID'],
                        ['detail' => 'Payment made']
                    );

                    $order->current_status = 'PAID';
                    $order->completed_at = Carbon::now();
                }

                try {
                    Notification::route('mail', $order->email)
                        ->notify(new OrderConfirmedNotification($order));
                } catch (\Exception $e) {
                    \Log::error('Error sending email notification: ' . $e->getMessage());
                }

            } catch (\Illuminate\Database\QueryException $e) {

                // Check if the error is a duplicate entry error
                if ($e->getCode() != 23000) {
                    throw $e;
                }
            }
            // dd($order, $payment);

            //order received once payment success
            try {
                Notification::route('mail', $configGeneral->email_alert_order)
                    ->notify(new OrderReceivedNotification($order));
            } catch (\Exception $e) {
                \Log::error('Error sending email notification: ' . $e->getMessage());
            }

        } else {
            // Payment failed
            $order->payment_status = 'FAILED';
        }

        $order->save();

        $user = Candidate::where('identity_card_number', $request->nric)->first();
        $status = $request->status;
        $ref_no = $request->ref_no;
        $txn_id = $request->txn_id;
        // $secret_key = '1eafc1e9-df86-4c8c-a3de-291ada259ab0';
        $secret_key = ConfigMpmBayar::first()->secret_key;
        $hashed = hash_hmac('SHA256', urlencode($secret_key) . urlencode($request->full_name) . urlencode($request->phone) . urlencode($request->email) . urlencode($request->amount), $secret_key);
        $show_result = true;

        if ($request->hash != $hashed) {
            die("Hash tidak sah.");
        } else {
            if ($order->payment_for == 'MPM_PRINT') {
                if ($request->status == 'SUCCESS') {
                    return view('modules.candidates.print-mpm-return', compact([
                        'payment',
                        'user',
                        'status',
                        'ref_no',
                        'txn_id',
                        'show_result',
                        'order'
                    ]));
                } elseif ($request->status == 'FAILED') {
                    $show_result = false;
                    return view('modules.candidates.print-mpm-return', compact([
                        'payment',
                        'user',
                        'status',
                        'ref_no',
                        'txn_id',
                        'show_result',
                        'order'
                    ]));
                }
            } else {
                if ($request->status == 'SUCCESS') {
                    return view('modules.candidates.print-mpm-return', compact([
                        'payment',
                        'user',
                        'status',
                        'ref_no',
                        'txn_id',
                        'show_result',
                        'order'
                    ]));
                } elseif ($request->status == 'FAILED') {
                    $show_result = false;
                    return view('modules.candidates.self-print-return', compact([
                        'payment',
                        'user',
                        'status',
                        'ref_no',
                        'txn_id',
                        'show_result',
                        'order'
                    ]));
                }
            }
        }
    }

    public function checkpayment(Request $request)
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
            $order->update(['payment_status' => $output->data->txn_status]);
            $payment->update(['status' => $output->data->txn_status]);
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

    public function generateExcel(Request $request)
    {

        $currentDate = Carbon::now()->format('Y-m-d H:i:s');
        $transactions = Payment::latest();
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
            $transactions->where('status', $request->status_trx);
        }

        if (filled($request->textSearch)) {
            $textSearch = $request->textSearch;
            $transactions->where(function ($query) use ($textSearch) {
                $query->where('txn_id', 'LIKE', '%' . $textSearch . '%')
                    // Add more columns to search in if necessary
                    ->orWhere('ref_no', 'LIKE', '%' . $textSearch . '%');
            });
        }

        $transactions = $transactions->get();

        return Excel::download(new TransactionExport($transactions), 'transaction_' . now() . '.xlsx');
    }

    public function generatePdf(Request $request)
    {

        $currentDate = Carbon::now()->format('Y-m-d H:i:s');

        $transactions = Payment::latest();

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
            $transactions->where('status', $request->status_trx);
        }

        if (filled($request->textSearch)) {
            $textSearch = $request->textSearch;
            $transactions->where(function ($query) use ($textSearch) {
                $query->where('txn_id', 'LIKE', '%' . $textSearch . '%')
                    // Add more columns to search in if necessary
                    ->orWhere('ref_no', 'LIKE', '%' . $textSearch . '%');
            });
        }

        $transactions = $transactions->get();

        $pdf = PDF::loadView('modules.admin.report.transaction.pdf.transaction', ['transactions' => $transactions]);

        return $pdf->stream('ListTransaction.pdf');
    }

    function createPayment($url, $data, $token)
    {
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
            error_log("cURL error: " . $error_msg); // Log the error
            curl_close($curl);
            return "An error occurred while connecting to the payment gateway. Please try again later.";
        }

        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($http_status != 200) {
            $error_msg = "HTTP Status Code: " . $http_status;
            error_log("cURL error: " . $error_msg); // Log the error
            curl_close($curl);
            return "An error occurred with the payment gateway. Please try again later.";
        }

        if (!empty($output)) {
            curl_close($curl);
            return $output;
        } else {
            $error_msg = "Failed to connect to the payment gateway. URL or TOKEN may be incorrect.";
            error_log("Connection error: " . $error_msg); // Log the error
            curl_close($curl);
            return "An error occurred while processing your request. Please try again later.";
        }
    }

    function generateOrderId($type)
    {

        if ($type == "MUET") {
            $prefix = "MUET";
        } else {
            $prefix = "MOD";
        }

        $suffix = substr(md5(uniqid()), 0, 8); // Generate a unique prefix

        return $prefix . '-' . $suffix;
    }
}
