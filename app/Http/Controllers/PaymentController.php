<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

use App\Http\Requests\PaymentRequest;
use App\Models\Candidate;
use App\Models\Courier;
use App\Models\Order;
use App\Models\Payment;
use App\Models\TrackingOrder;
use Ramsey\Uuid\Uuid;

use DataTables;


class PaymentController extends Controller
{


    public function index()
    {
        $user = Auth::User() ? Auth::User() : abort(403);

        return view('modules.admin.report.transaction.index',
            compact([
                'user',
            ]));
    }

    public function getAjax(Request $request)
    {

        $transaction = Payment::latest()->get();
        // dd($transaction);
        // if ($request->ajax()) {

        //     $query = Pos::query()->where('id', '<>', '0')
        //         ->orderBy('date', 'asc');

        //     $data = !empty($query) ? $query->get() : [];

        //     return DataTables::of($data)->addIndexColumn()->toJson();
        // }
        $data = [];
        foreach ($transaction as $key => $value) {
            $data[] = [
                "order_id" => $value->order_id,
                "payment_date" => $value->payment_date,
                "status" => $value->status,
                "txn_id" => $value->txn_id,
                "method" => $value->method,
                "amount" => $value->amount,
                "receipt" =>  $value->receipt,
                "receipt_number" =>  $value->receipt_number
            ];
        }

        return datatables($data)->toJson();

    }

    public function makepayment(PaymentRequest $request)
    // public function makepayment(Request $request)
    {
        try {
            $string = Crypt::decrypt($request->crypt_id);
            $data = explode('-', $string);
            $id = $data[0];
            $exam_type = $data[1];
        } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
            dd($e);
        };


        $url = 'https://ebayar-lab.mpm.edu.my/api/payment/create';
        $token = 'a2aWmIGjPSVZ8F3OvS2BtppKM2j6TKvKXE7u8W7MwbkVyZjwZfSYdNP5ACem';
        $secret_key = '1eafc1e9-df86-4c8c-a3de-291ada259ab0';

        $extra_data = [
            'pay_for' => $request->pay_for, // SELF_PRINT or MPM_PRINT
            'exam_type' => $exam_type, // MUET or MOD
            'courier' => !empty($request->courier) ? $request->courier : '', // N/A or courier_ID
        ];

        $data = [
            "full_name" => $request->name,
            "phone_number" => $request->phone_num,
            "email_address" => $request->email,
            "nric" => $request->nric,
            "extra_data" => json_encode($extra_data),
        ];

        //kalau MPM_PRINT amount courier atau SELF_PRINT get .env value SELFPRINT_AMOUNT
        $data['amount'] = empty($request->courier) ? env('SELFPRINT_AMOUNT', 20.00) : Courier::find($request->courier)->rate;
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

        // Create new order
        $order = new Order();
        // $order->unique_order_id = Uuid::uuid4()->toString();
        $order->unique_order_id = self::generateShortId(8);
        $order->payment_ref_no = $output->ref_no;
        $order->candidate_id = Auth::User()->id;
        $order->name = $request->name;
        $order->email = $request->email;
        $order->phone_num = $request->phone_num;
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

        $secret_key = '1eafc1e9-df86-4c8c-a3de-291ada259ab0';
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

    public function getpayment(Request $request){

        // dd($request->toArray());
        // update order
        $order = Order::where('payment_ref_no',$request->ref_no)->first();

        if (!$order) {
            // dd("no order found");
            // show return to view
            return redirect()->back();
        }

        // add payment record
        if($request->status == "SUCCESS"){

            $order->payment_status = 'SUCCESS';

            $data = json_decode($request->extra_data,1);

            try {
                $payment = new Payment();
                $payment->order_id = $order->id;
                $payment->payment_date = $request->txn_time;
                $payment->method = $request->type;
                $payment->amount = $request->amount;
                $payment->status = $request->status;
                $payment->txn_id = $request->txn_id;
                $payment->ref_no = $request->ref_no;
                $payment->cust_info = serialize(array("full_name"=>$request->full_name, "email"=>$request->email, "phoneNum"=>$request->phone));
                $payment->receipt = $request->receipt;
                $payment->receipt_number = $request->receipt_number;
                $payment->error_message = "";
                $payment->save();

                if ($order->payment_for == 'MPM_PRINT') {

                    $track = new TrackingOrder();
                    $track->order_id = $order->id;
                    $track->detail = 'Payment made';
                    $track->status = 'PAID';
                    $track->save();

                    $track = new TrackingOrder();
                    $track->order_id = $order->id;
                    $track->detail = 'Admin received order';
                    $track->status = 'NEW';
                    $track->save();
                } elseif($order->payment_for == 'SELF_PRINT'){

                    $track = new TrackingOrder();
                    $track->order_id = $order->id;
                    $track->detail = 'Payment made';
                    $track->status = 'PAID';
                    $track->save();
                }
            } catch (\Illuminate\Database\QueryException $e) {
                // Check if the error is a duplicate entry error
                if ($e->getCode() != 23000) {
                    throw $e;
                }
            }

        } else {
            // Payment failed
            $order->payment_status = 'FAILED';
        }

        $order->save();

        $user = Candidate::where('identity_card_number',$request->nric)->first();
        $status = $request->status;
        $ref_no = $request->ref_no;
        $txn_id = $request->txn_id;
        $secret_key = '1eafc1e9-df86-4c8c-a3de-291ada259ab0';
        $hashed = hash_hmac('SHA256', urlencode($secret_key) . urlencode($request->full_name) . urlencode($request->phone) . urlencode($request->email) . urlencode($request->amount), $secret_key);
        $show_result = true;

        if ($request->hash != $hashed) {
            die("Hash tidak sah.");
        } else {
            if ($request->status == 'SUCCESS') {
                return view('modules.candidates.print-mpm-return', compact([
                    'user',
                    'status',
                    'ref_no',
                    'txn_id',
                    'show_result',
                ]));
            } elseif ($request->status == 'FAILED') {
                $show_result = false;
                return view('modules.candidates.print-mpm-return', compact([
                    'user',
                    'status',
                    'ref_no',
                    'txn_id',
                    'show_result',
                ]));
            }
        }

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

    function generateShortId() {
        // $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // $charactersLength = strlen($characters);
        // $shortId = '';

        // for ($i = 0; $i < $length; $i++) {
        //     $shortId .= $characters[rand(0, $charactersLength - 1)];
        // }

        // return $shortId;

        $prefix = substr(md5(uniqid()), 0, 8); // Generate a unique prefix
        $suffix = substr(md5(uniqid()), -4); // Generate a unique suffix

        return $prefix . '-' . $suffix;
    }
}
