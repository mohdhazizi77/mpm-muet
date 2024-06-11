<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

// use Yajra\DataTables\DataTables;

use App\Models\Order;
use App\Models\TrackingOrder;
use App\Models\Pos;
use App\Models\User;
use App\Models\MuetCalon;
use App\Models\ModCalon;


use App\Exports\OrdersExport;

use DataTables;
use stdClass;

class PosController extends Controller
{
    public function index($type)
    {
        $user = Auth::User() ? Auth::User() : abort(403);

        return view('modules.admin.pos.'.$type.'.index',
            compact([
                'user',
            ]));

    }

    public function getAjax(Request $request, $type)
    {
        // dd($type, $request->toArray());
        $pos = Order::where([
            'payment_for' => 'MPM_PRINT',
            'payment_status' => 'SUCCESS',
            "current_status" => $request->type
        ])->get();

        $data = [];
        foreach ($pos as $key => $pos) {

            if($pos->muet_calon_id != null){
                $calon = $pos->muetCalon;
            } else {
                $calon = $pos->modCalon;
            }

            $data[] = [
                'id'         => Crypt::encrypt($pos->id),
                'order_id'   => $pos->unique_order_id,
                'order_date' => $pos->created_at->format('d/m/Y'),
                'order_time' => $pos->created_at->format('H:i:s'),
                'details'    => $pos->type . " | Sesi ".$calon->sidang." | " . "Angka Giliran : " . $calon->index_number($calon)
            ];
        }
        return datatables($data)->toJson();
    }

    public function getPosDetail(Request $request, $type){
        // sleep(5);

        $user = Auth::User() ? Auth::User() : abort(403);

        try {
            $id = Crypt::decrypt($request->id);
        } catch (DecryptException $e) {
            // Log the exception
            Log::error('Decryption error: ' . $e->getMessage());

            // Return a custom error view
            $data = [
                'error'   => 'Decryption error: ' . $e->getMessage(), // The error message
                'success' => false,
            ];
            return response()->json($data);
        }

        $order = Order::find($id);
        $order->order_id = Crypt::encrypt($order->id);
        $order->state_name = User::getStates($order->state);

        $candidate = $order->muetCalon;
        $candidate->candidate_cryptId = Crypt::encrypt($candidate->id . "-MUET");
        $candidate->negeri_id = User::getKeyStates(strtoupper($candidate->negeri));

        $data = [
            'success'   => true,
            'order'     => $order,
            'candidate' => $candidate,
        ];

        return response()->json($data);
    }

    public function update(Request $request, $type){

        // If validation fails, return error response
        if (empty($request->ship_trackNum) === "processing") {
            $data = [
                'success' => false,
                'message' => 'Tracking number cannot be empty'
            ];
            return response()->json($data);
        }

        // dd($request->toArray());
        try {
            $id = Crypt::decrypt($request->order_id);
        } catch (DecryptException $e) {
            // Log the exception
            Log::error('Decryption error: ' . $e->getMessage());

            // Return a custom error view
            $data = [
                'error'   => 'Decryption error: ' . $e->getMessage(), // The error message
                'success' => false,
            ];
            return response()->json($data);
        }

        $order = Order::find($id);

        $data['success'] = false;

        if ($type == 'new') {

            // $connote = self::getConNote($order); // return output or error

            // $order->tracking_number = $connote->ConnoteNo;
            $order->tracking_number = "ER".$order->unique_order_id."MY";
            $order->current_status = "PROCESSING";

            $tracking = new TrackingOrder();
            $tracking->order_id = $order->id;
            $tracking->detail = "MPM currently processing the certificate for shipping";
            $tracking->status = "PROCESSING";
            $tracking->save();

        } elseif ($type == 'processing') {

            if ($order->tracking_number !== $request->ship_trackNum) {
                $order->tracking_number = $request->ship_trackNum;
            }

            $preAcceptance = self::sendPreAcceptanceSingle($order); // return output or error

            if (!$preAcceptance)
                return response()->json($data);


            $order->current_status = "COMPLETED";


            $tracking = new TrackingOrder();
            $tracking->order_id = $order->id;
            $tracking->detail = "Tracking number : ";
            $tracking->status = "COMPLETED";
            $tracking->save();
        } else {
            // Default case
            // You can add code here if needed
        }
        $order->save();

        $data = [
            'success' => true
        ];

        return response()->json($data);
    }

    public function updateBulk(Request $request, $type){

        foreach ($request->orderID as $key => $value) {

            if (empty($value))
                continue;
            // If validation fails, return error response
            if (empty($request->ship_trackNum) === "processing") {
                $data = [
                    'success' => false,
                    'message' => 'Tracking number cannot be empty'
                ];
                return response()->json($data);
            }

            try {
                $id = Crypt::decrypt($value);
            } catch (DecryptException $e) {
                // Log the exception
                Log::error('Decryption error: ' . $e->getMessage());

                // Return a custom error view
                $data = [
                    'error'   => 'Decryption error: ' . $e->getMessage(), // The error message
                    'success' => false,
                ];
                return response()->json($data);
            }

            $order = Order::find($id);

            $data['success'] = false;

            if ($type == 'new') {

                // $connote = self::getConNote($order); // return output or error

                // $order->tracking_number = $connote->ConnoteNo;
                $order->tracking_number = "ER".$order->unique_order_id."MY";
                $order->current_status = "PROCESSING";

                $tracking = new TrackingOrder();
                $tracking->order_id = $order->id;
                $tracking->detail = "MPM currently processing the certificate for shipping";
                $tracking->status = "PROCESSING";
                $tracking->save();

            } elseif ($type == 'processing') {

                if ($order->tracking_number !== $request->ship_trackNum) {
                    $order->tracking_number = $request->ship_trackNum;
                }

                $preAcceptance = self::sendPreAcceptanceSingle($order); // return output or error

                if (!$preAcceptance)
                    return response()->json($data);


                $order->current_status = "COMPLETED";


                $tracking = new TrackingOrder();
                $tracking->order_id = $order->id;
                $tracking->detail = "Tracking number : ";
                $tracking->status = "COMPLETED";
                $tracking->save();
            } else {
                // Default case
                // You can add code here if needed
            }
            $order->save();
        }

        $data = [
            'success' => true
        ];

        return response()->json($data);
    }

    public function cancelBulk(Request $request, $type){

        foreach ($request->orderID as $key => $value) {

            if (empty($value))
                continue;

            try {
                $id = Crypt::decrypt($value);
            } catch (DecryptException $e) {
                // Log the exception
                Log::error('Decryption error: ' . $e->getMessage());

                // Return a custom error view
                $data = [
                    'error'   => 'Decryption error: ' . $e->getMessage(), // The error message
                    'success' => false,
                ];
                return response()->json($data);
            }

            $order = Order::find($id);

            $data['success'] = false;

            if ($type == 'new') {

                // $connote = self::getConNote($order); // return output or error

                // $order->tracking_number = $connote->ConnoteNo;
                $order->tracking_number = "ER".$order->unique_order_id."MY";
                $order->current_status = "CANCEL";

                // $tracking = new TrackingOrder();
                // $tracking->order_id = $order->id;
                // $tracking->detail = "MPM currently processing the certificate for shipping";
                // $tracking->status = "CANCEL";
                // $tracking->save();

            }
            // elseif ($type == 'processing') {

            //     if ($order->tracking_number !== $request->ship_trackNum) {
            //         $order->tracking_number = $request->ship_trackNum;
            //     }

            //     $preAcceptance = self::sendPreAcceptanceSingle($order); // return output or error

            //     if (!$preAcceptance)
            //         return response()->json($data);


            //     $order->current_status = "COMPLETED";


            //     $tracking = new TrackingOrder();
            //     $tracking->order_id = $order->id;
            //     $tracking->detail = "Tracking number : ";
            //     $tracking->status = "COMPLETED";
            //     $tracking->save();
            // } else {
            //     // Default case
            //     // You can add code here if needed
            // }
            $order->save();
        }

        $data = [
            'success' => true
        ];

        return response()->json($data);
    }

    public function getBearerToken(){
        // $url = "https://gateway-usc.pos.com.my/security/connect/token";
        // $data = [
        //     'client_id' => "6652e0d504a9d7000e8a878a",
        //     'client_secret' => "pOJY4eHX6fvKjBcpyP1jQtqCwi3ImC2qiDPPKJlodc8=",
        //     'grant_type' => "client_credentials",
        //     'scope' => "as01.gen-connote.all"
        // ];

        // $output = '';
        // $curl = curl_init();
        // curl_setopt($curl, CURLOPT_URL, $url);
        // curl_setopt($curl, CURLOPT_POST, 1);
        // curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        //     'Accept: application/json',
        // ));
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        // $output = curl_exec($curl);
        // $output = json_decode($output);
        // // dd($output);

        // if (curl_errno($curl)) {
        //     $error_msg = curl_error($curl);
        //     error_log("cURL error: " . $error_msg); // Log the error
        //     curl_close($curl);
        //     return "An error occurred while connecting to the courier API. Please try again later.";
        // }

        // $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        // if ($http_status != 200) {
        //     $error_msg = "HTTP Status Code: " . $http_status;
        //     error_log("cURL error: " . $error_msg); // Log the error
        //     curl_close($curl);
        //     return "An error occurred with the courier API. Please try again later.";
        // }

        // if (!empty($output)) {
        //     curl_close($curl);
        //     return $output;
        // } else {
        //     $error_msg = "Failed to connect to the payment gateway. URL or TOKEN may be incorrect.";
        //     error_log("Connection error: " . $error_msg); // Log the error
        //     curl_close($curl);
        //     return "An error occurred while processing your request. Please try again later.";
        // }
    }

    function getConNote(){
        $url = "https://gateway-usc.pos.com.my/security/connect/token";
        $data = [
            'client_id' => "665b49e6f304bd000e908742",
            'client_secret' => "8FfMy7W3e4BYsSs4y1y50jshkLr6oVHd4nh3TKES1lY=",
            'grant_type' => "client_credentials",
            'scope' => "as01.gen-connote.all as2corporate.preacceptancessingle.all as01.routing-code.all as2corporate.v2trackntracewebapijson.all"
        ];

        $output = '';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($curl);
        $output = json_decode($output);
        // dd($output);

        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            error_log("cURL error: " . $error_msg); // Log the error
            curl_close($curl);
            return "An error occurred while connecting to the courier API. Please try again later.";
        }

        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($http_status != 200) {
            $error_msg = "HTTP Status Code: " . $http_status;
            error_log("cURL error: " . $error_msg); // Log the error
            curl_close($curl);
            return "An error occurred with the courier API. Please try again later.";
        }

        if (!empty($output)) {
            curl_close($curl);
            return $output;
        } else {
            $error_msg = "Failed to connect to the pos api. URL or TOKEN may be incorrect.";
            error_log("Connection error: " . $error_msg); // Log the error
            curl_close($curl);
            return "An error occurred while processing your request. Please try again later.";
        }
    }

    function sendPreAcceptanceSingle(){
        // return false;
        return true;
    }

    public function generateExcel($type){

        $orders = Order::where([
            "current_status" => $type
        ])->get();

        return Excel::download(new OrdersExport($orders), 'list_pos_' . $type . '.xlsx');

        $arr = []; // Initialize an empty array

        $arr[] = [
            'Date',
            'Reference ID',
            "Detail"
        ];

        foreach ($orders as $key => $order) {

            if($order->muet_calon_id != null){
                $calon = $order->muetCalon;
            } else {
                $calon = $order->modCalon;
            }

            $arr[] = [
                $order->created_at->format('d/m/Y H:i:s'),
                $order->unique_order_id,
                $order->type . " | Sesi ".$calon->sidang." | " . "Angka Giliran : " . $calon->index_number($calon)
            ];
        }

        // // Define the file name for your Excel file
        // $fileName = 'list pos '.$type.'.csv';

        // // Generate and download the Excel file
        // return Excel::download(function($excel) use ($arr) {
        //     // Set the title of the sheet
        //     $excel->setTitle('List Pos');

        //     // Set the headers for each column
        //     $excel->sheet('Sheet1', function($sheet) use ($arr) {
        //         $sheet->fromArray($arr, null, 'A1', false, false);
        //     });

        // }, $fileName);

        // Pass the order data array to the OrdersExport class
        $export = new OrdersExport($arr);
        // Download the Excel file
        return Excel::download($export, 'orders.xlsx');
    }
}
