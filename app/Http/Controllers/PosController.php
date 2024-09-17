<?php

namespace App\Http\Controllers;

use App\Notifications\OrderCompletedNotification;

use Illuminate\Support\Facades\Notification;

use App\Exports\OrdersPosExport;
use App\Imports\OrderPosImport;
use App\Models\ConfigPoslaju;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Http;
// use Yajra\DataTables\DataTables;

use App\Models\Order;
use App\Models\TrackingOrder;
use App\Models\Pos;
use App\Models\User;
use App\Models\MuetCalon;
use App\Models\ModCalon;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

use iio\libmergepdf\Merger;
use iio\libmergepdf\Pages;
use iio\libmergepdf\Exception;

use App\Exports\OrdersExport;
use Carbon\Carbon;
use setasign\Fpdi\Fpdi;
use setasign\Fpdf\Fpdf;
use DataTables;
use stdClass;
use TCPDF;

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
            $pos->whereBetween('updated_at', [$startDate, $endDate]);
        }

        // Apply filtering based on name search if provided
        // if ($request->has('textSearch') && !empty($request->textSearch)) {
        //     $textSearch = $request->textSearch;
        //     $pos->where(function ($query) use ($textSearch) {
        //         $query->where('name', 'LIKE', '%' . $textSearch . '%')
        //             // Add more columns to search in if necessary
        //             ->orWhere('unique_order_id', 'LIKE', '%' . $textSearch . '%')
        //             ->orWhere('type', 'LIKE', '%' . $textSearch . '%');
        //     });
        // }

        // Apply filtering based on muet type
        if ($request->has('examType') && !empty($request->examType)) {
            $examType = $request->examType;
            $pos->where(function ($query) use ($examType) {
                $query->where('type', $examType);
            });
        }

        // Apply filtering for no tracking number
        if ($request->has('noTracking') && !empty($request->noTracking)) {
            if ($request->noTracking) { //true
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
        $posData = $pos->orderBy('updated_at', 'desc')->get();

        // Prepare the data array
        $data = [];
        foreach ($posData as $key => $order) {
            $calon = $order->muet_calon_id != null ? $order->muetCalon : $order->modCalon;

            $arr = [
                'id'         => Crypt::encrypt($order->id),
                'order_id'   => $order->unique_order_id,
                'order_date' => $order->updated_at->format('d/m/Y H:i:s'),
                'order_time' => $order->updated_at->format('H:i:s'),
                'consignment_note' => $order->consignment_note,
                'details'    => $order->type . " | Session " . $calon->sidang . " Year " . $calon->tahun . " | Angka Giliran : " . $calon->index_number($calon),
                'index_number'    => $calon->index_number($calon),
                'candidate_name' => $calon->nama,
                'tracking_number' => (!empty($order->tracking_number) ? $order->tracking_number : ""),
            ];

            // if ($request->type == "PROCESSING") {
            // };

            // if ($request->type == "COMPLETED") {
            //     $arr['tracking_number'] = (!empty($order->tracking_number) ? $order->tracking_number : "");
            // };


            $data[] = $arr;
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

        // Return the data in JSON format for DataTables
        return datatables()->of($data)->toJson();
    }

    public function trackShipping()
    {
        return view('modules.admin.pos.tracking');
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

        try {
            $response = Http::withToken($bearerToken)
                            ->get('https://gateway-usc.pos.com.my/staging/as2corporate/v2trackntracewebapijson/v1/api/Details', [
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
                        'no' => $key+1,
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

    public function getPosDetail(Request $request, $type)
    {

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

        if (!empty($order->muetCalon)) {
            $candidate = $order->muetCalon;
            $candidate->candidate_cryptId = Crypt::encrypt($candidate->id . "-MUET");
        } else {
            $candidate = $order->modCalon;
            $candidate->candidate_cryptId = Crypt::encrypt($candidate->id . "-MOD");
        }
        $candidate->negeri_id = User::getKeyStates(strtoupper($candidate->negeri));

        $data = [
            'success'   => true,
            'order'     => $order,
            'candidate' => $candidate,
        ];

        return response()->json($data);
    }

    public function update(Request $request, $type)
    {
        // If validation fails, return error response
        if (empty($request->ship_trackNum) === "processing") {
            $data = [
                'success' => false,
                'message' => 'Tracking number cannot be empty'
            ];
            return response()->json($data);
        }

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

            if ($connote['success']) { //true

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
            $order->consignment_note = $preAcceptance->pdf;

            $tracking = new TrackingOrder();
            $tracking->order_id = $order->id;
            $tracking->detail = "Transaction completed and Certificate out for shipment";
            $tracking->status = "COMPLETED";
            $tracking->save();

            try {
                Notification::route('mail', $order->email)
                    ->notify(new OrderCompletedNotification($order));
            } catch (\Exception $e) {
                \Log::error('Error sending email notification: ' . $e->getMessage());
            }

        } else {
            $order->name = $request->ship_name;
            $order->phone_num = $request->ship_phoneNum;
            $order->email = $request->ship_email;
            $order->address1 = $request->ship_address;
            $order->postcode = $request->ship_postcode;
            $order->city = $request->ship_city;
            $order->state = $request->ship_state;
            $order->tracking_number = $request->ship_trackNum;
        }
        $order->save();
        $data = [
            'success' => true
        ];

        return response()->json($data);
    }

    public function cancel(Request $request, $type)
    {

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
            $order->current_status = "CANCEL";

            $track = new TrackingOrder();
            $track->order_id = $order->id;
            $track->detail = 'Admin cancel the transaction';
            $track->status = 'CANCEL';
            $track->save();
        }

        $order->save();

        $data = [
            'success' => true
        ];

        return response()->json($data);
    }

    public function updateBulk(Request $request, $type)
    {
        // dd($request->toArray());

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
            // dd($stringOrderID);
            $data['success'] = false;

            if ($type == 'new') {
                $connote = self::getConNote([$stringOrderID]); // return output or error

                if ($connote['success']) { //true

                    $order->tracking_number = $connote['con_note'];
                    // $order->tracking_number = "ER".$order->unique_order_id."MY";
                    $order->current_status = "PROCESSING";

                    $tracking = new TrackingOrder();
                    $tracking->order_id = $order->id;
                    $tracking->detail = "MPM currently processing the certificate for shipping";
                    $tracking->status = "PROCESSING";
                    $tracking->save();
                } else { // if api pos down
                    // $data = [
                    //     'success' => false,
                    //     'message' => $connote['message'],
                    //     'message_detail' => $connote['message_detail'],
                    // ];

                    // return response()->json($data);
                    continue;
                }
            } elseif ($type == 'processing') {

                //bulk update checking no tracking number not process
                if (empty($order->tracking_number))
                    continue;

                // if ($order->tracking_number !== $request->ship_trackNum) {
                //     $order->tracking_number = $request->ship_trackNum;
                // }

                $preAcceptance = self::sendPreAcceptanceSingle($order); // return output or error
                if (!$preAcceptance)
                    return response()->json($data);

                $order->consignment_note = $preAcceptance->pdf;
                $order->current_status = "COMPLETED";

                $tracking = new TrackingOrder();
                $tracking->order_id = $order->id;
                $tracking->detail = "Transaction completed and Certificate out for shipment";
                $tracking->status = "COMPLETED";
                $tracking->save();

                try {
                    Notification::route('mail', $order->email)
                        ->notify(new OrderCompletedNotification($order));
                } catch (\Exception $e) {
                    \Log::error('Error sending email notification: ' . $e->getMessage());
                }

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

    public function cancelBulk(Request $request, $type)
    {

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

                $order->tracking_number = "ER" . $order->unique_order_id . "MY";
                $order->current_status = "CANCEL";
            }

            $order->save();
        }

        $data = [
            'success' => true
        ];

        return response()->json($data);
    }

    function getConNote($orders)
    {

        // Ensure you have a valid session token
        $bearerToken = Session::get('bearer_token');
        if (!$bearerToken) {
            die('Bearer token is not available in the session.');
        }

        // Create a new Guzzle HTTP client
        $client = new Client();
        $ConfigPoslaju = ConfigPoslaju::first();
        try {
            // Send a GET request
            $response = $client->request('GET', $ConfigPoslaju->url . '/as01/gen-connote/v1/api/GConnote', [
                'query' => [
                    'numberOfItem' => count($orders),
                    'Prefix' => $ConfigPoslaju->Prefix,
                    'ApplicationCode' => $ConfigPoslaju->ApplicationCode,
                    'Secretid' => $ConfigPoslaju->Secretid,
                    'Orderid' => implode(', ', $orders),
                    'username' => $ConfigPoslaju->username
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

    function sendPreAcceptanceSingle($order)
    {
        // Ensure you have a valid session token
        $bearerToken = Session::get('bearer_token');
        if (!$bearerToken) {
            die('Bearer token is not available in the session.');
        }

        $ConfigPoslaju = ConfigPoslaju::first();

        $client = new Client();
        $url = $ConfigPoslaju->url . '/as2corporate/preacceptancessingle/v1/Tracking.PreAcceptance.WebApi/api/PreAcceptancesSingle';

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $bearerToken,
        ];

        $body = [
            // "subscriptionCode" => "ECON001",
            "subscriptionCode" => "qaily@mpm.edu.my", //need to confirm back
            "requireToPickup" => false, //need to confirm back
            "requireWebHook" => false, //need to confirm back
            // "accountNo" => 9999999999, //need to confirm back
            "accountNo" => 4681526086,
            "callerName" => "SUB(PSM)",
            "callerPhone" => "0361261600",
            "pickupLocationID" => ".", //Merchants Unique Register ID
            "pickupLocationName" => ".",
            "contactPerson" => ".",
            "phoneNo" => "0361261600",
            "pickupAddress" => "Majlis Peperiksaan Malaysia, Persiaran 1, Bandar Baru Selayang",
            "pickupDistrict" => "Batu Caves",
            "pickupProvince" => "Selangor",
            "pickupCountry" => "MY",
            "pickupLocation" => "",
            "pickupEmail" => "muet@mpm.edu.my",
            "postCode" => 68100,
            "ItemType" => 2,
            "Amount" => "0",
            "totalQuantityToPickup" => 1,
            "totalWeight" => 0.5,
            "ConsignmentNoteNumber" => $order->tracking_number,
            "CreatedDate" => "26052022: 11:47:21",
            "PaymentType" => 2,
            "readyToCollectAt" => "11:30 AM",
            "closeAt" => "05:00 PM",
            "receiverName" => $order->name,
            "receiverID" => "",
            "receiverAddress" => $order->address1,
            "receiverAddress2" => "",
            "receiverDistrict" => $order->city,
            "receiverProvince" => $order->state, //need to check with state array pass id
            "receiverCity" => $order->city,
            "receiverPostCode" => $order->postcode,
            "receiverCountry" => "MY",
            "receiverEmail" => "",
            "receiverPhone01" => $order->phone_num,
            "receiverPhone02" => $order->phone_num,
            "sellerReferenceNo" => "",
            "itemDescription" => "",
            "sellerOrderNo" => "",
            "comments" => ",",
            "packDesc" => "",
            "packVol" => "",
            "packLeng" => "0.1",
            "packWidth" => "0.1",
            "packHeight" => "0.1",
            "packTotalitem" => "1",
            "orderDate" => "",
            "packDeliveryType" => "",
            "ShipmentName" => "PosLaju",
            "pickupProv" => "",
            "deliveryProv" => "",
            "postalCode" => "",
            "currency" => "MYR",
            "countryCode" => "MY",
            "pickupDate" => ""
        ];

        try {
            $response = $client->post($url, [
                'headers' => $headers,
                'json' => $body,
            ]);

            $responseBody = $response->getBody()->getContents();

            return json_decode($responseBody);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $errorResponse = $e->getResponse()->getBody()->getContents();
                return response()->json(['error' => json_decode($errorResponse)], $e->getResponse()->getStatusCode());
            } else {
                return response()->json(['error' => 'Request failed'], 500);
            }
        }
        return true;
    }

    public function generateExcel(Request $request, $type)
    {

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
                ->with('muetCalon', 'modCalon')
                ->when($request->filled('startDate') || $request->filled('endDate'), function ($query) use ($request) {
                    $currentDate = Carbon::now()->format('Y-m-d H:i:s');

                    $startDate = Carbon::parse($request->startDate)->startOfDay()->format('Y-m-d H:i:s');
                    $endDate = $request->has('endDate') && !empty($request->endDate)
                        ? Carbon::parse($request->endDate)->endOfDay()->format('Y-m-d H:i:s')
                        : $currentDate;

                    // Filter based on the date range
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                })
                ->when($request->filled('textSearch'), function ($query) use ($request) {
                    $textSearch = $request->textSearch;
                    $request->where(function ($query) use ($textSearch) {
                        $query->where('name', 'LIKE', '%' . $textSearch . '%')
                            ->orWhere('unique_order_id', 'LIKE', '%' . $textSearch . '%')
                            ->orWhere('type', 'LIKE', '%' . $textSearch . '%');
                    });
                })
                ->when($request->filled('noTracking'), function ($query) use ($request) {
                    if ($request->noTracking) { //true
                        $query->where('tracking_number', "");
                    }
                })
                ->get();

            // Merge the collected orders
            $orders = $orders->merge($order);
        }

        $type = strtolower($type);

        // Return the Excel download with all collected orders
        return Excel::download(new OrdersExport($orders, $type), 'list_pos_' . $type . '.xlsx');

        $arr = []; // Initialize an empty array

        $arr[] = [
            'Date',
            'Reference ID',
            "Detail"
        ];

        foreach ($orders as $key => $order) {

            if ($order->muet_calon_id != null) {
                $calon = $order->muetCalon;
            } else {
                $calon = $order->modCalon;
            }

            $arr[] = [
                $order->created_at->format('d/m/Y H:i:s'),
                $order->unique_order_id,
                $order->type . " | Sesi " . $calon->sidang . " | " . "Angka Giliran : " . $calon->index_number($calon)
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

    public function generateExcelPos(Request $request, $type)
    {

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
                ->with('muetCalon', 'modCalon')
                ->when($request->filled('startDate') || $request->filled('endDate'), function ($query) use ($request) {
                    $currentDate = Carbon::now()->format('Y-m-d H:i:s');

                    $startDate = Carbon::parse($request->startDate)->startOfDay()->format('Y-m-d H:i:s');
                    $endDate = $request->has('endDate') && !empty($request->endDate)
                        ? Carbon::parse($request->endDate)->endOfDay()->format('Y-m-d H:i:s')
                        : $currentDate;

                    // Filter based on the date range
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                })
                ->when($request->filled('textSearch'), function ($query) use ($request) {
                    $textSearch = $request->textSearch;
                    $request->where(function ($query) use ($textSearch) {
                        $query->where('name', 'LIKE', '%' . $textSearch . '%')
                            ->orWhere('unique_order_id', 'LIKE', '%' . $textSearch . '%')
                            ->orWhere('type', 'LIKE', '%' . $textSearch . '%');
                    });
                })
                ->when($request->filled('noTracking'), function ($query) use ($request) {
                    if ($request->noTracking) { //true
                        $query->where('tracking_number', "");
                    }
                })
                ->get();

            // Merge the collected orders
            $orders = $orders->merge($order);
        }

        // Return the Excel download with all collected orders
        return Excel::download(new OrdersPosExport($orders, $type), 'list_pos_' . $type . '.xlsx');
    }

    public function generateImportExcelPos(Request $request, $type)
    {
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

    public function bulkDownloadConnote(Request $request)
    {
        $connote_arr = [];
        foreach ($request->orderIds as $key => $value) {
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
            $connote_arr[] =  $order->consignment_note;
        }
        $filePath = self::processBulkPDFs($connote_arr);
        return $filePath;
    }

    function processBulkPDFs($pdfUrls)
    {
        // Temporary directory to store downloaded PDFs
        $tempDir = storage_path('app/public/temp');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        // Download PDFs from URLs
        $pdfPaths = [];
        foreach ($pdfUrls as $pdfUrl) {
            $pdfPath = self::downloadPDFFromURL($pdfUrl, $tempDir);
            if ($pdfPath) {
                $pdfPaths[] = $pdfPath;
            } else {
                Log::error('Failed to download or validate PDF from: ' . $pdfUrl);
            }
        }

        if (empty($pdfPaths)) {
            return response()->json(['error' => 'No valid PDFs to process.'], 400);
        }
        // Merge downloaded PDFs
        $outputFileName = 'Bulk_Connote_' . date('d_m_Y_His');
        self::mergePDFs($pdfPaths, $outputFileName);

        return asset('storage/temp/'.$outputFileName.'.pdf');

    }

    function mergePDFs($pdfPaths, $outputFileName)
    {
        $tempDir = storage_path('app/public//temp');
        $mergedPdfPath = $tempDir . '/' . $outputFileName . '.pdf';

        // command to run in local
        // $pdftkPath = 'C:\\Program Files (x86)\\PDFtk\\bin\\pdftk.exe'; // Update this to your actual pdftk path
        // $command = '"' . $pdftkPath . '" ' . implode(' ', array_map('escapeshellarg', $pdfPaths)) . ' cat output ' . escapeshellarg($mergedPdfPath);

        // command to run in server
        $pdftkPath = 'pdftk';
        $command = $pdftkPath . ' ' . implode(' ', array_map('escapeshellarg', $pdfPaths)) . ' cat output ' . escapeshellarg($mergedPdfPath);

        // Execute the command
        exec($command, $output, $return_var);

        // Log the output and return value
        Log::info('Command output: ' . implode("\n", $output));
        Log::info('Executing command: ' . $command);
        Log::info('Return var: ' . $return_var);

        // Check if PDFtk succeeded
        if ($return_var !== 0) {
            Log::error('PDFtk failed to merge PDFs: ' . implode("\n", $output));
            return false;
        }
        return $outputFileName;
    }

    function downloadPDFFromURL($pdfUrl, $tempDir)
    {
        $client = new Client(['verify' => false]); // Disable SSL verification if necessary
        $response = $client->request('GET', $pdfUrl);
        $fileName = uniqid() . '.pdf';
        $filePath = $tempDir . '/' . $fileName;

        // Save the PDF content
        file_put_contents($filePath, $response->getBody());

        // Verify that the downloaded file is a valid PDF
        if (!file_exists($filePath) || !mime_content_type($filePath) === 'application/pdf') {
            Log::error('Invalid PDF file downloaded from: ' . $pdfUrl);
            return null;
        }

        return $filePath;
    }

}
