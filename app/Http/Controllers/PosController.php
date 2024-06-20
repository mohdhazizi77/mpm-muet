<?php

namespace App\Http\Controllers;

use App\Exports\OrdersPosExport;
use App\Imports\OrderPosImport;
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

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

use App\Exports\OrdersExport;
use Carbon\Carbon;

use DataTables;
use stdClass;


class PosController extends Controller
{
    public function index($type)
    {
        if (!in_array($type, ['new', 'processing', 'completed'])) {
            abort(404);
        }
        $user = Auth::user() ?? abort(403);
        return view('modules.admin.pos.' . $type . '.index', compact('user'));
    }

    public function getAjax(Request $request, $type)
    {
        // Initialize the query with fixed conditions
        $pos = Order::where([
            'payment_for' => 'MPM_PRINT',
            'payment_status' => 'SUCCESS',
            'current_status' => $request->type
        ]);

        // Get the current date in the desired format
        $currentDate = Carbon::now()->format('Y-m-d H:i:s');

        // Apply date range filtering
        if ($request->has('startDate') && !empty($request->startDate)) {
            // Convert startDate and endDate to Carbon instances
            $startDate = Carbon::parse($request->startDate)->startOfDay()->format('Y-m-d H:i:s');
            $endDate = $request->has('endDate') && !empty($request->endDate)
                        ? Carbon::parse($request->endDate)->endOfDay()->format('Y-m-d H:i:s')
                        : $currentDate;

            // Filter based on the date range
            $pos->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Apply filtering based on name search if provided
        if ($request->has('textSearch') && !empty($request->textSearch)) {
            $textSearch = $request->textSearch;
            $pos->where(function ($query) use ($textSearch) {
                $query->where('name', 'LIKE', '%' . $textSearch . '%')
                    // Add more columns to search in if necessary
                    ->orWhere('unique_order_id', 'LIKE', '%' . $textSearch . '%')
                    ->orWhere('type', 'LIKE', '%' . $textSearch . '%');
            });
        }

        // Apply filtering for no tracking number
        if ($request->has('noTracking') && !empty($request->noTracking)) {
            if($request->noTracking){//true
                $pos->where('tracking_number', "");
            }
        }

        // list by transaction by role
        switch (Auth::User()->getRoleNames()[0]) {
            case 'PSM':
                $pos->where('type', 'MUET');
                break;
            case 'BPKOM':
                $pos->where('type', 'MOD');
                break;
        }

        // Fetch the data
        $posData = $pos->get();

        // Prepare the data array
        $data = [];
        foreach ($posData as $key => $order) {
            $calon = $order->muet_calon_id != null ? $order->muetCalon : $order->modCalon;
            $arr = [
                'id'         => Crypt::encrypt($order->id),
                'order_id'   => $order->unique_order_id,
                'order_date' => $order->created_at->format('d/m/Y'),
                'order_time' => $order->created_at->format('H:i:s'),
                'details'    => $order->type . " | Sesi " . $calon->sidang . " | Angka Giliran : " . $calon->index_number($calon)
            ];

            if ($request->type == "PROCESSING") {
                $arr['tracking_number'] = (!empty($order->tracking_number) ? $order->tracking_number : "") ;
            };

            $data[] = $arr;
        }

        // Return the data in JSON format for DataTables
        return datatables()->of($data)->toJson();
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
        $stringOrderID = $order->unique_order_id;

        $data['success'] = false;

        if ($type == 'new') {

            $connote = self::getConNote([$stringOrderID]); // return output or error

            if($connote['success']){ //true

                $order->tracking_number = $connote['con_note'];
                // $order->tracking_number = "ER".$order->unique_order_id."MY";
                $order->current_status = "PROCESSING";

                $tracking = new TrackingOrder();
                $tracking->order_id = $order->id;
                $tracking->detail = "MPM currently processing the certificate for shipping";
                $tracking->status = "PROCESSING";
                $tracking->save();

            } else { // if api pos down
                $data = [
                    'success' => false,
                    'message' => $connote['message'],
                    'message_detail' => $connote['message_detail'],
                ];

                return response()->json($data);
            }


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

    public function cancel(Request $request, $type){

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

            $order->tracking_number = "ER".$order->unique_order_id."MY";
            $order->current_status = "CANCEL";
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
            $stringOrderID = $order->unique_order_id;

            $data['success'] = false;

            if ($type == 'new') {
                 $connote = self::getConNote([$stringOrderID]); // return output or error

                if($connote['success']){ //true

                    // $order->tracking_number = $connote->ConnoteNo;
                    $order->tracking_number = "ER".$order->unique_order_id."MY";
                    $order->current_status = "PROCESSING";

                    $tracking = new TrackingOrder();
                    $tracking->order_id = $order->id;
                    $tracking->detail = "MPM currently processing the certificate for shipping";
                    $tracking->status = "PROCESSING";
                    $tracking->save();
                } else { // if api pos down
                    $data = [
                        'success' => false,
                        'message' => $connote['message'],
                        'message_detail' => $connote['message_detail'],
                    ];

                    return response()->json($data);
                }


            } elseif ($type == 'processing') {

                //bulk update checking no tracking number not process
                if(empty($order->tracking_number))
                    continue;

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

                $order->tracking_number = "ER".$order->unique_order_id."MY";
                $order->current_status = "CANCEL";
            }

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

    function getConNote($orders){

        // Ensure you have a valid session token
        $bearerToken = Session::get('bearer_token');
        if (!$bearerToken) {
            die('Bearer token is not available in the session.');
        }

        // Create a new Guzzle HTTP client
        $client = new Client();

        try {
            // Send a GET request
            $response = $client->request('GET', 'https://gateway-usc.pos.com.my/staging/as01/gen-connote/v1/api/GConnote', [
                'query' => [
                    'numberOfItem' => count($orders),
                    'Prefix' => 'ER',
                    'ApplicationCode' => 'StagingPos',
                    'Secretid' => 'StagingPos@1234',
                    'Orderid' => implode(', ', $orders),
                    'username' => 'StagingPos'
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . $bearerToken,
                ]
            ]);

            // Output the response body
            $response = json_decode($response->getBody()->getContents());
            if ($response->StatusCode == "01") {
                return [
                    'success' => true,
                    'con_note' => $response->ConnoteNo,
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $response->Message,
                    'message_detail' => '',
                ];
            }

        } catch (ConnectException $e) {
            // Handle connection errors (e.g., DNS issues, server not reachable)
            return [
                'success' => false,
                'error' => 'Connection error',
                'message' => 'The POS API is not reachable. Please check your network connection or try again later.',
                'message_detail' => '',
                'details' => $e->getMessage()
            ];
        } catch (ServerException $e) {
            // Handle server errors (e.g., 500 Internal Server Error)
            return [
                'error' => 'Server error',
                'success' => false,
                'message' => 'The POS API encountered an unexpected condition. Please try again later.',
                'message_detail' => 'Please contact POS IT Team for more info.',
                'details' => $e->getResponse()->getBody()->getContents()
            ];
        } catch (RequestException $e) {
            // Handle other request errors
            if ($e->hasResponse()) {
                $statusCode = $e->getResponse()->getStatusCode();
                if ($statusCode == 503) {
                    return [
                            'success' => false,
                            'error' => 'Service unavailable',
                            'message' => 'API POS is temporarily down for maintenance. Please try again later.',
                            'message_detail' => 'Please contact POS IT Team for more info.',
                            'details' => $e->getResponse()->getBody()->getContents()
                        ];
                } else {
                    return [
                            'success' => false,
                            'error' => 'Request error',
                            'message' => 'An error occurred while processing your request.',
                            'message_detail' => 'Please contact POS IT Team for more info.',
                            'details' => $e->getResponse()->getBody()->getContents()
                        ];
                }
            } else {
                return [
                    'success' => false,
                    'error' => 'Request error',
                    'message' => 'Have error when connection to POS API. No response received from the server.',
                    'message_detail' => 'Please contact POS IT Team for more info.',
                    'details' => $e->getMessage()
                ];
            }
        }
    }

    function sendPreAcceptanceSingle(){
        // return false;
        return true;
    }

    public function generateExcel(Request $request, $type){

        $orderIDs = array_filter($request->orderID, function ($value) {
            return !is_null($value);
        });

        $orders = collect();

        // Gather all orders matching the given criteria
        foreach ($orderIDs as $value) {
            $id = Crypt::decrypt($value);

            $order = Order::where([
                    "current_status" => $type,
                    'id' => $id
                ])
                ->with('muetCalon','modCalon')
                ->get();

            // Merge the collected orders
            $orders = $orders->merge($order);
        }

        // Return the Excel download with all collected orders
        return Excel::download(new OrdersExport($orders, $type), 'list_pos_' . $type . '.xlsx');

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

    public function generateExcelPos(Request $request, $type){

        $orderIDs = array_filter($request->orderID, function ($value) {
            return !is_null($value);
        });

        $orders = collect();

        // Gather all orders matching the given criteria
        foreach ($orderIDs as $value) {
            $id = Crypt::decrypt($value);

            $order = Order::where([
                    "current_status" => $type,
                    'id' => $id
                ])
                ->with('muetCalon','modCalon')
                ->get();

            // Merge the collected orders
            $orders = $orders->merge($order);
        }

        // Return the Excel download with all collected orders
        return Excel::download(new OrdersPosExport($orders, $type), 'list_pos_' . $type . '.xlsx');
    }

    public function generateImportExcelPos(Request $request,$type){
        $this->validate($request, [
            'file' => 'nullable|mimes:xls,xlsx'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $validationResult = Excel::toCollection(new OrderPosImport, $file);

            $sheet = $validationResult[0];
            if (!$sheet->first()->has(18)) {
                return response('Sila gunakan templat senarai order yang betul.', 422);
            }

            $parcelNoteValues = [];
            $consinmentteValues = [];
            $nonExistentOrders = []; // Initialize an empty array to store non-existent orders

            foreach ($validationResult as $orders) {
                foreach ($orders as $index => $row) {
                    // dd($row[18] == 'Parcel Notes' && $row[2] == 'Consignment Note');
                    if ($index === 0 && $row[18] !== 'Parcel Notes' && $row[2] !== 'Consignment Note') {
                        return response('Column Parcel Notes and/or Consignment Note is not Exist.', 422);
                    }

                    // Proceed if the headers match the expected values and data is valid
                    if ($index > 0 && isset($row[18]) && isset($row[2]) && $row[18] !== null && $row[18] !== '') {
                        $parcelNoteValues[] = $row[18]; //explode(" ", $row[18])[0];
                        $consinmentteValues[] = $row[2];
                    }
                }
            }

            // Check existence of all unique_order_id values first
            foreach ($parcelNoteValues as $parcelNote) {
                $order = Order::where('unique_order_id', $parcelNote)->exists();

                if (!$order) {
                    $nonExistentOrders[] = $parcelNote; // Store non-existent unique_order_id
                }
            }

            // If there are any non-existent unique_order_id values, return an error response
            if (!empty($nonExistentOrders)) {
                return response('Orders with unique_order_id ' . implode(', ', $nonExistentOrders) . ' do not exist.', 422);
            }

            // All unique_order_id values exist, proceed with updating tracking_number
            foreach ($parcelNoteValues as $key => $parcelNote) {
                $consinment = $consinmentteValues[$key];

                $order = Order::where('unique_order_id', $parcelNote)->first();

                // Update tracking_number if order exists
                if ($order) {
                    $order->tracking_number = $consinment;
                    $order->save();
                }
            }

            return response('Successfully processed the Excel file.', 200);
        }

        return response()->json(['error' => 'Tiada fail yang disediakan.']);
    }

    public function printBulk(Request $request){
        $orderIds = $request->query('orderIds', []);

        dd($orderIds);
    }
}
