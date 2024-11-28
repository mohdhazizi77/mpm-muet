<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\BandDescriptionsHeader;
use App\Models\CefrConfig;
use App\Models\User;
use App\Models\Candidate;
use App\Models\MuetCalon;
use App\Models\MuetSkor;
use App\Models\ModCalon;
use App\Models\ModSkor;
use App\Models\Certificate;
use App\Models\Courier;
use App\Models\Order;
use App\Models\TrackingOrder;
use App\Models\Payment;
use App\Models\ConfigGeneral;
use App\Models\ConfigMpmBayar;
use App\Models\CandidateActivityLog;
use App\Models\AuditLog;
use App\Services\AuditLogService;

use Carbon\Carbon;
use setasign\Fpdi\Fpdi;
use setasign\Fpdf\Fpdf;
use Exception;
use DataTables;

class CandidateController extends Controller
{

    public function index()
    {
        $user = Auth::User() ? Auth::User() : abort(403);
        $muets = $user->muetCalon;
        $mods = $user->modCalon;
        $config = ConfigGeneral::get()->first();

        return view(
            'modules.candidates.index',
            compact([
                'user',
                'config',
            ])
        );
    }

    public function getAjax()
    {
        $candidate = Auth::User() ? Auth::User() : abort(403);

        $muets = $candidate->muetCalon;
        // dd($muets);
        $mods = $candidate->modCalon;

        $cert_datas = [];
        $cutoffTime = Carbon::now()->subDay(2); // Get the current time and subtract 24 hours to get the cutoff time
        foreach ($muets as $key => $muet) {

            $is_more2year = self::checkYear($muet->getTarikh->tahun); //check cert if already 2 years
            $is_selfPrintPaid = false;
            $is_mpmPrintPaid = false;
            if ($is_more2year) {
                // $res = $muet->getOrder->where('payment_status','SUCCESS')->where('payment_for', 'SELF_PRINT')->toArray();

                $res = $muet->getOrder()
                    ->where('payment_status', 'SUCCESS')
                    // ->where(function ($query) {
                    //     $query->where('payment_for', 'SELF_PRINT')
                    //         ->orWhere('payment_for', 'MPM_PRINT');
                    // })
                    ->where('payment_for', 'SELF_PRINT')
                    ->where('created_at', '>=', $cutoffTime)
                    ->get()
                    ->toArray();

                $is_selfPrintPaid = count($res) > 0 ? true : false;

                $res = $muet->getOrder->where('payment_status', 'SUCCESS')
                    ->where('payment_for', 'MPM_PRINT')
                    ->where('created_at', '>=', $cutoffTime)
                    ->toArray();
                $is_mpmPrintPaid = count($res) > 0 ? true : false;
            } else {
                $res = $muet->getOrder->where('payment_status', 'SUCCESS')->where('payment_for', 'SELF_PRINT')->toArray();
                $is_selfPrintPaid = count($res) > 0 ? true : false;

                $res = $muet->getOrder->where('payment_status', 'SUCCESS')->where('payment_for', 'MPM_PRINT')->toArray();
                $is_mpmPrintPaid = count($res) > 0 ? true : false;
            }

            $cert_datas[] = [
                "no"                => ++$key,
                "id"                => Crypt::encrypt($muet->id . "-MUET"), // xxx-MUET or xxx-MOD
                // "id"                => $muet->id . "-MUET", // xxx-MUET or xxx-MOD
                "type"              => 'MUET',
                "year"              => $muet->tahun,
                "session"           => str_replace('MUET ', '', $muet->getTarikh->sesi),
                "band"              => "Band " . self::formatNumber($muet->band, $muet->tahun),
                "is_more2year"      => $is_more2year,
                "is_selfPrintPaid"  => $is_selfPrintPaid,
                "is_mpmPrintPaid"   => $is_mpmPrintPaid,
            ];
        }

        foreach ($mods as $key => $mod) {

            $is_more2year = self::checkYear($mod->getTarikh->tahun); //check cert if already 2 years
            $is_selfPrintPaid = false;
            $is_mpmPrintPaid = false;
            if ($is_more2year) {
                // $res = $muet->getOrder->where('payment_status','SUCCESS')->where('payment_for', 'SELF_PRINT')->toArray();

                $res = $mod->getOrder()
                    ->where('payment_status', 'SUCCESS')
                    ->where('payment_for', 'SELF_PRINT')
                    ->where('created_at', '>=', $cutoffTime)
                    ->get()
                    ->toArray();
                $is_selfPrintPaid = count($res) > 0 ? true : false;

                $res = $mod->getOrder->where('payment_status', 'SUCCESS')
                    ->where('payment_for', 'MPM_PRINT')
                    ->where('created_at', '>=', $cutoffTime)
                    ->toArray();
                $is_mpmPrintPaid = count($res) > 0 ? true : false;
            } else {
                $res = $mod->getOrder->where('payment_status', 'SUCCESS')->where('payment_for', 'SELF_PRINT')->toArray();
                $is_selfPrintPaid = count($res) > 0 ? true : false;

                $res = $mod->getOrder->where('payment_status', 'SUCCESS')->where('payment_for', 'MPM_PRINT')->toArray();
                $is_mpmPrintPaid = count($res) > 0 ? true : false;
            }

            $cert_datas[] = [
                "no"                => ++$key,
                "id"                => Crypt::encrypt($mod->id . "-MOD"), // xxx-MUET or xxx-MOD
                // "id"                => $muet->id . "-MUET", // xxx-MUET or xxx-MOD
                "type"              => 'MOD',
                "year"              => $mod->tahun,
                "session"           => str_replace('MOD ', '', $mod->getTarikh->sesi),
                "band"              => "Band " . $mod->band,
                "is_more2year"      => $is_more2year,
                "is_selfPrintPaid"  => $is_selfPrintPaid,
                "is_mpmPrintPaid"   => $is_mpmPrintPaid,
            ];
        }

        return datatables($cert_datas)->toJson();
    }

    function formatNumber($number, $year = null)
    {
        // List of disallowed values
        $disallowed = ["-1", "-2", "-3", "-4", "-5", "X"];

        // Check if the number is in the disallowed list
        if (in_array($number, $disallowed)) {
            return $number;
        }

        // Check if the number contains a '+'
        if (strpos($number, '+') !== false) {
            return $number;
        }

        if ($year <= 2020) {
            return $number;
        }
        // Convert to float and format to one decimal place
        $formattedNumber = number_format((float)$number, 1);

        return $formattedNumber;
    }

    public function verifyIndexNumber(Request $request)
    {
        try {
            $certID = Crypt::decrypt($request->certID);
        } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
        }

        $value = explode('-', $certID);
        $certID = $value[0];
        $type = $value[1];

        if ($type == "MUET") {
            $candidate = MuetCalon::find($certID);
        } else {
            $candidate = ModCalon::find($certID);
        }

        $user = Auth::user();
        // $current_time = Carbon::now();
        // $lockout_time = 60; // Lockout time in minutes (1 hour)

        // // Parse the date_verify_index_number into a Carbon instance
        // $dateVerifyIndexNumber = Carbon::parse($user->date_verify_index_number);

        // // Check if the user has exceeded retry attempts within the lockout time
        // if ($user->retry_verify_index_number > 2 && $dateVerifyIndexNumber->diffInMinutes($current_time) < $lockout_time) {
        //     $minutes_left = $lockout_time - $dateVerifyIndexNumber->diffInMinutes($current_time);
        //     $timer = $minutes_left . ' minute' . ($minutes_left > 1 ? 's' : '');

        //     $data = [
        //         'success' => false,
        //         'message' => 'Your account has been locked due to repeated attempts to enter an index number. Please wait for ' . $timer . ' before trying again.'
        //     ];

        //     return response()->json($data);
        // }

        // // If more than 1 hour has passed since the last attempt, reset the retry counter
        // if ($dateVerifyIndexNumber->diffInMinutes($current_time) >= $lockout_time) {
        //     $user->retry_verify_index_number = 0;
        // }

        $current_time = Carbon::now();
        $lockout_time = 5; // Lockout time in seconds (5 seconds)

        // Parse the date_verify_index_number into a Carbon instance
        $dateVerifyIndexNumber = Carbon::parse($user->date_verify_index_number);

        // Check if the user has exceeded retry attempts within the lockout time
        if ($user->retry_verify_index_number > 1 && $dateVerifyIndexNumber->diffInSeconds($current_time) < $lockout_time) {
            $seconds_left = $lockout_time - $dateVerifyIndexNumber->diffInSeconds($current_time);

            $data = [
                'success' => false,
                'message' => 'Your account has been locked due to repeated attempts to enter an index number. Please wait for ' . $seconds_left . ' seconds before trying again.'
            ];

            return response()->json($data);
        }

        // If more than 5 seconds have passed since the last attempt, reset the retry counter
        if ($dateVerifyIndexNumber->diffInSeconds($current_time) >= $lockout_time) {
            $user->retry_verify_index_number = 0;
        }

        // Retrieve index numbers
        $arr_index_number = $user->getIndexNumber($user->id);
        // dd($arr_index_number );
        $res = array_search($request->indexNumber, $arr_index_number);

        if ($res !== false) {
            // Correct index number
            $user->retry_verify_index_number = 0;
            $data = [
                'success' => true,
                'id' => $request->certID,
            ];
        } else {
            // Incorrect index number
            $user->retry_verify_index_number++;
            $data = [
                'success' => false,
                'message' => 'Incorrect index number'
            ];
        }

        // Update date_verify_index_number and save user
        $user->date_verify_index_number = $current_time->format('Y-m-d H:i:s');
        $user->save();

        return response()->json($data);
    }

    public function show(Candidate $candidate)
    {
        $user = Auth::User() ? Auth::User() : abort(403);
        return view('candidates.show');
    }

    public function printpdf($cryptId)
    {
        try {
            $id = Crypt::decrypt($cryptId);
        } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
            return redirect()->back();
        }

        $value = explode('-', $id);
        $certID = $value[0];
        $type = $value[1];

        if ($type == "MUET") {
            $candidate = MuetCalon::find($certID);
        } else {
            $candidate = ModCalon::find($certID);
        }
        $result = $candidate->getResult($candidate);

        $cert = '';
        $user = Auth::user();
        if ($result['year'] >= 2021) {
            $scheme = [
                "listening" => 90,
                "speaking" => 90,
                "reading" => 90,
                "writing" => 90,
                "agg_score" => 360,
            ];
        } else if ($result['year'] > 2008 && $result['year'] < 2021) {
            $scheme = [
                "listening" => 45,
                "speaking" => 45,
                "reading" => 120,
                "writing" => 90,
                "agg_score" => 300,
            ];
        } else { // lees than 2008
            $scheme = [
                "listening" => 45,
                "speaking" => 45,
                "reading" => 135,
                "writing" => 75,
                "agg_score" => 300,
            ];
        }

        // Log result view activity
        CandidateActivityLog::create([
            'candidate_id' => Auth::guard('candidate')->id(),
            'activity_type' => 'view_result',
            'type'          => $type
        ]);

        AuditLog::create([
            // 'user_id' => Auth::guard('candidate')->id(),
            'candidate_id' => Auth::guard('candidate')->id(),
            'activity' => 'View Result Index Number :' . $candidate->angka_giliran,
            'summary' => serialize(['View Result', $candidate, $result]),
            'device' => AuditLog::getDeviceDetail(),
        ]);

        return view('modules.candidates.print-pdf', compact(['user', 'scheme', 'result', 'cryptId']));
    }

    public function qrscan()
    {
        return view('candidates.qr-scan');
    }

    public function downloadpdf($cryptId)
    {
        try {
            $id = Crypt::decrypt($cryptId);
        } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
            dd($e);
        }

        try {

            $value = explode('-', $id);
            $certID = $value[0];
            $type = $value[1];

            if ($type == "MUET") {
                $candidate = MuetCalon::find($certID);
            } else {
                $candidate = ModCalon::find($certID);
            }
            // $pusat = $candidate->getPusat->first();
            $tarikh = $candidate->getTarikh;
            $result = $candidate->getResult($candidate);
            if ($result['year'] >= 2021) {
                $scheme = [
                    "listening" => 90,
                    "speaking" => 90,
                    "reading" => 90,
                    "writing" => 90,
                    "agg_score" => 360,
                ];
            } else if ($result['year'] > 2008 && $result['year'] < 2021) {
                $scheme = [
                    "listening" => 45,
                    "speaking" => 45,
                    "reading" => 120,
                    "writing" => 90,
                    "agg_score" => 300,
                ];
            } else { // lees than 2008
                $scheme = [
                    "listening" => 45,
                    "speaking" => 45,
                    "reading" => 135,
                    "writing" => 75,
                    "agg_score" => 300,
                ];
            }

            $url = config('app.url') . '/verify/result/' . $cryptId; // Replace with your URL or data /verify/result/{id}
            $qr = QrCode::size(50)->style('round')->generate($url);
            $pdf = PDF::loadView('modules.candidates.download-pdf', [
                'tarikh' => $tarikh,
                'qr' => $qr,
                'type' => $type,
                'result' => $result,
                'candidate' => $candidate,
                'scheme' => $scheme,
                // 'pusat' => $pusat,
                'image1Data' => config('base64_images.jataNegara'),
                'image2Data' => config('base64_images.logoMPM'),
                'image3Data' => config('base64_images.sign'),
            ])
                ->setPaper('a4', 'portrait')
                ->setOptions(['isRemoteEnabled' => true]);
            // return $pdf->download($result['index_number'].' '.$type.' RESULT.pdf');

            AuditLog::create([
                // 'user_id' => Auth::guard('candidate')->id(),
                'candidate_id' => Auth::guard('candidate')->id(),
                'activity' => 'Download Result Index Number :' . $candidate->angka_giliran,
                'summary' => serialize(['View Result', $candidate, $result]),
                'device' => AuditLog::getDeviceDetail(),
            ]);

            return $pdf->stream($result['index_number'] . ' ' . $type . ' RESULT.pdf');
        } catch (Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    // public function downloadpdfCandidate($id, $type)
    // {
    //     try {

    //         if ($type == "MUET") {
    //             $candidate = MuetCalon::find($id);
    //         } else {
    //             $candidate = ModCalon::find($id);
    //         }
    //         $pusat = $candidate->getPusat->first();
    //         $tarikh = $candidate->getTarikh;
    //         $result = $candidate->getResult($candidate);
    //         if ($result['year'] >= 2021) {
    //             $scheme = [
    //                 "listening" => 90,
    //                 "speaking" => 90,
    //                 "reading" => 90,
    //                 "writing" => 90,
    //                 "agg_score" => 360,
    //             ];
    //         } else if ($result['year'] > 2008 && $result['year'] < 2021) {
    //             $scheme = [
    //                 "listening" => 45,
    //                 "speaking" => 45,
    //                 "reading" => 120,
    //                 "writing" => 90,
    //                 "agg_score" => 300,
    //             ];
    //         } else { // lees than 2008
    //             $scheme = [
    //                 "listening" => 45,
    //                 "speaking" => 45,
    //                 "reading" => 135,
    //                 "writing" => 75,
    //                 "agg_score" => 300,
    //             ];
    //         }

    //         $cryptId = Crypt::encrypt($id . "-" . $type);
    //         $url = config('app.url') . '/verify/result/' . $cryptId; // Replace with your URL or data /verify/result/{id}
    //         $qr = QrCode::size(50)->style('round')->generate($url);
    //         $pdf = PDF::loadView('modules.candidates.download-pdf', [
    //             'tarikh' => $tarikh,
    //             'qr' => $qr,
    //             'type' => $type,
    //             'result' => $result,
    //             'candidate' => $candidate,
    //             'scheme' => $scheme,
    //             'pusat' => $pusat,
    //             'image1Data' => config('base64_images.jataNegara'),
    //             'image2Data' => config('base64_images.logoMPM'),
    //             'image3Data' => config('base64_images.sign'),
    //         ])
    //             ->setPaper('a4', 'portrait')
    //             ->setOptions(['isRemoteEnabled' => true]);
    //         // return $pdf->download($type.' RESULT.pdf');

    //         AuditLog::create([
    //             // 'user_id' => Auth::guard('candidate')->id(),
    //             'candidate_id' => Auth::guard('candidate')->id(),
    //             'activity' => 'Download Result Index Number :'.$candidate->angka_giliran,
    //             'summary' => serialize(['View Result', $candidate, $result]),
    //             'device' => AuditLog::getDeviceDetail(),
    //         ]);

    //         return $pdf->stream($result['index_number'].' '.$type.' RESULT.pdf');
    //     } catch (Exception $e) {
    //         return back()->withError($e->getMessage());
    //     }
    // }

    public function singleDownloadPdf($cryptId)
    {
        //single download pdf pos

        try {
            $id = Crypt::decrypt($cryptId);
        } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
            dd($e);
        }

        try {

            $value = explode('-', $id);
            $certID = $value[0];
            $type = $value[1];

            if ($type == "MUET") {
                $candidate = MuetCalon::find($certID);
            } else {
                $candidate = ModCalon::find($certID);
            }
            // $pusat = $candidate->getPusat->first();
            $tarikh = $candidate->getTarikh;
            $result = $candidate->getResult($candidate);
            if ($result['year'] >= 2021) {
                $scheme = [
                    "listening" => 90,
                    "speaking" => 90,
                    "reading" => 90,
                    "writing" => 90,
                    "agg_score" => 360,
                ];
            } else if ($result['year'] > 2008 && $result['year'] < 2021) {
                $scheme = [
                    "listening" => 45,
                    "speaking" => 45,
                    "reading" => 120,
                    "writing" => 90,
                    "agg_score" => 300,
                ];
            } else { // lees than 2008
                $scheme = [
                    "listening" => 45,
                    "speaking" => 45,
                    "reading" => 135,
                    "writing" => 75,
                    "agg_score" => 300,
                ];
            }
            $url = config('app.url') . '/verify/result/' . $cryptId; // Replace with your URL or data /verify/result/{id}

            $qr = QrCode::size(50)->style('round')->generate($url);


            $pdf = PDF::loadView('modules.candidates.mpmPrint-download-pdf', [
                'tarikh' => $tarikh,
                'qr' => $qr,
                'type' => $type,
                'result' => $result,
                'candidate' => $candidate,
                'scheme' => $scheme,
                // 'pusat' => $pusat,
                'image1Data' => config('base64_images.jataNegara'),
                'image2Data' => config('base64_images.logoMPM'),
                'image3Data' => config('base64_images.sign'),
            ])
                ->setPaper('a4', 'portrait')
                ->setOptions(['isRemoteEnabled' => true]);

            // try {
            //     AuditLog::create([
            //         'user_id' => Auth::User()->id,
            //         'activity' => 'Download Result Index Number :'.$candidate->angka_giliran,
            //         'summary' => serialize(['View Result', $candidate, $result]),
            //         'device' => AuditLog::getDeviceDetail(),
            //     ]);
            // } catch (Exception $e) {
            //     Log::error($e);
            // }

            return $pdf->download($result['index_number'] . ' ' . $type . ' RESULT.pdf');
            // return $pdf->stream($result['index_number'].' '.$type.' RESULT.pdf');


        } catch (Exception $e) {
            dd($e);
            return back()->withError($e->getMessage());
        }
    }

    public function bulkDownloadPdf(Request $request)
    {
        // dd($request->toArray());
        $arr_calon = [];
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
            if ($order->muet_calon_id != null) { //MUET
                $arr_calon[] =  $order->muet_calon_id . '-MUET';
            } else { //MOD
                $arr_calon[] = $order->mod_calon_id . '-MOD';
            }
        }

        return self::processBulkPDF($arr_calon);
    }

    public function printmpm($cryptId)
    {

        try {
            $string = Crypt::decrypt($cryptId);
            $data = explode('-', $string);
            $id = $data[0];
            $exam_type = $data[1];
        } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
        };
        $config = ConfigGeneral::get()->first();
        $user = Auth::User();
        if ($exam_type == "MUET") {
            $candidate = MuetCalon::find($id);
        } else {
            $candidate = ModCalon::find($id);
        }
        $status = 0;
        $couriers = Courier::get();

        $result = $candidate->getResult($candidate);
        if ($result['year'] >= 2021) {
            $scheme = [
                "listening" => 90,
                "speaking" => 90,
                "reading" => 90,
                "writing" => 90,
                "agg_score" => 360,
            ];
        } else if ($result['year'] > 2008 && $result['year'] < 2021) {
            $scheme = [
                "listening" => 45,
                "speaking" => 45,
                "reading" => 120,
                "writing" => 90,
                "agg_score" => 300,
            ];
        } else { // lees than 2008
            $scheme = [
                "listening" => 45,
                "speaking" => 45,
                "reading" => 135,
                "writing" => 75,
                "agg_score" => 300,
            ];
        }

        // $muet = $candidate->muetCalon;
        // dd($candidate);
        //show result untuk tak lebih 2 tahun
        $is_more2year = self::checkYear($candidate->getTarikh->tahun);

        $cutoffTime = Carbon::now()->subDay(); // Get the current time and subtract 24 hours to get the cutoff time

        if ($is_more2year) {
            $res = $candidate->getOrder()
                ->where('payment_status', 'SUCCESS')
                // ->where('payment_for', 'SELF_PRINT')
                // ->orWhere('payment_for', 'MPM_PRINT')
                ->where('created_at', '>=', $cutoffTime)
                ->get()
                ->toArray();

            $show_result = count($res) > 0 ? true : false;
        } else {
            $show_result = true;
        }

        return view('modules.candidates.print-mpm', compact([
            'show_result',
            'result',
            'scheme',
            'status',
            'id',
            'user',
            'cryptId',
            'couriers',
            'config'
        ]));
    }

    public function selfprint($cryptId)
    {
        try {
            $string = Crypt::decrypt($cryptId);
            $data = explode('-', $string);
            $id = $data[0];
            $exam_type = $data[1];
        } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
        };

        if ($exam_type == "MUET") {
            $candidate = MuetCalon::find($id);
        } else {
            $candidate = ModCalon::find($id);
        }

        $candidate->cryptId = $cryptId;

        return view('modules.candidates.self-print', compact([
            'candidate',
            'exam_type',
        ]));
    }

    public function muetstatus($cryptId)
    {
        try {
            $orderId = Crypt::decrypt($cryptId);
        } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
        };


        $payment = Payment::where('order_id', $orderId)->first();

        $order = Order::find($orderId);
        $tracks = TrackingOrder::where('order_id', $orderId)->latest()->get();

        if ($payment->status == 'PENDING') {
            $url = ConfigMpmBayar::first()->url . '/api/payment/status';
            $token = ConfigMpmBayar::first()->token;
            $secret_key = ConfigMpmBayar::first()->secret_key;

            $data = [
                "ref_no" => $payment->ref_no,
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
                var_dump($error_msg);
                exit();
            }
            // dd($output->data);
            // echo(print_r($output->data,1));
            if (!empty($output->data)) {
                curl_close($curl);
                $order->update(['payment_status' => $output->data->txn_status, 'current_status' => $output->data->txn_status]);
                $payment = Payment::updateOrCreate(
                    [
                        'ref_no' => $payment->ref_no,
                    ],
                    [
                        'payment_date' => $output->data->txn_time,
                        'method' => $output->data->payment_provider,
                        'amount' => $output->data->txn_final_amount,
                        'status' => $output->data->txn_status,
                        'txn_id' => $output->data->txn_id,
                        'ref_no' => $output->data->ref_no,
                        'cust_info' => serialize(array("full_name" => $output->data->full_name, "email" => $output->data->email_address, "phoneNum" => $output->data->phone_number)),
                        'receipt' => $output->data->receipt_url,
                        'receipt_number' => $output->data->receipt_no,
                        'error_message' => "",
                        'payment_for' => $order->payment_for,
                        'type' => $order->type,
                    ]
                );
            } else {
                echo "Payment Gateway tidak dapat disambung. Pastikan URL dan TOKEN adalah betul.";
                curl_close($curl);
            }
        }

        return view('modules.candidates.muet-status', compact([
            'order',
            'tracks',
            'payment',
            'cryptId',
        ]));
    }

    public function checkYear($year)
    {
        // Get the current year
        $currentYear = Carbon::now()->year;

        // Check if the given year is more than 2 years ago from the current year
        if ($currentYear - $year >= 3) {
            return true; // Given year is more than 2 years ago
        } else {
            return false; // Given year is less than 2 years ago
        }
    }

    public function verifyResult($cryptId)
    {
        try {
            $id = Crypt::decrypt($cryptId);
        } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
            return redirect()->back();
        }

        $value = explode('-', $id);
        $certID = $value[0];
        $type = $value[1];

        if ($type == "MUET") {
            $candidate = MuetCalon::find($certID);
        } else {
            $candidate = ModCalon::find($certID);
        }

        $result = $candidate->getResult($candidate);
        $cert = '';
        $user = Auth::user();
        if ($result['year'] >= 2021) {
            $scheme = [
                "listening" => 90,
                "speaking" => 90,
                "reading" => 90,
                "writing" => 90,
                "agg_score" => 360,
            ];
        } else if ($result['year'] > 2008 && $result['year'] < 2021) {
            $scheme = [
                "listening" => 45,
                "speaking" => 45,
                "reading" => 120,
                "writing" => 90,
                "agg_score" => 300,
            ];
        } else { // lees than 2008
            $scheme = [
                "listening" => 45,
                "speaking" => 45,
                "reading" => 135,
                "writing" => 75,
                "agg_score" => 300,
            ];
        }

        // dd($candidate->getResult($candidate));
        return view('modules.candidates.verify-result', compact(['candidate', 'scheme', 'result', 'cryptId']));
    }

    function generatePDF($id)
    {
        //bulk download pdf pos
        $value = explode('-', $id);
        $certID = $value[0];
        $type = $value[1];

        if ($type == "MUET") {
            $candidate = MuetCalon::find($certID);
        } else {
            $candidate = ModCalon::find($certID);
        }
        // $pusat = $candidate->getPusat->first();
        $tarikh = $candidate->getTarikh;
        $result = $candidate->getResult($candidate);
        if ($result['year'] >= 2021) {
            $scheme = [
                "listening" => 90,
                "speaking" => 90,
                "reading" => 90,
                "writing" => 90,
                "agg_score" => 360,
            ];
        } else if ($result['year'] > 2008 && $result['year'] < 2021) {
            $scheme = [
                "listening" => 45,
                "speaking" => 45,
                "reading" => 120,
                "writing" => 90,
                "agg_score" => 300,
            ];
        } else { // lees than 2008
            $scheme = [
                "listening" => 45,
                "speaking" => 45,
                "reading" => 135,
                "writing" => 75,
                "agg_score" => 300,
            ];
        }

        $cryptId = Crypt::encrypt($certID);
        $url = config('app.url') . '/verify/result/' . Crypt::encrypt($id);
        $qr = QrCode::size(50)->style('round')->generate($url);

        $pdf = PDF::loadView('modules.candidates.mpmPrint-download-pdf', [
            'tarikh' => $tarikh,
            'qr' => $qr,
            'type' => $type,
            'result' => $result,
            'candidate' => $candidate,
            'scheme' => $scheme,
            // 'pusat' => $pusat,
            'image1Data' => config('base64_images.jataNegara'),
            'image2Data' => config('base64_images.logoMPM'),
            'image3Data' => config('base64_images.sign'),
        ])
            ->setPaper('a4', 'portrait')
            ->setOptions(['isRemoteEnabled' => true]);

        $pdfPath = storage_path('app/temp/' . $id . '.pdf');
        AuditLog::create([
            'user_id' => Auth::User()->id,
            'activity' => 'Bulk Download Result Index Number :' . $candidate->angka_giliran,
            'summary' => serialize(['View Result', $candidate, $result]),
            'device' => AuditLog::getDeviceDetail(),
        ]);

        $pdf->save($pdfPath);

        return $pdfPath;
    }

    function mergePDFs($pdfPaths)
    {
        $pdf = new Fpdi();

        foreach ($pdfPaths as $pdfPath) {
            $pageCount = $pdf->setSourceFile($pdfPath);
            for ($i = 1; $i <= $pageCount; $i++) {
                $templateId = $pdf->importPage($i);
                $size = $pdf->getTemplateSize($templateId);

                $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $pdf->useTemplate($templateId);
            }
        }

        $mergedPdfPath = storage_path('app/temp/merged_result.pdf');
        $pdf->Output($mergedPdfPath, 'F');

        return $mergedPdfPath;
    }

    function processBulkPDF($ids)
    {
        $pdfPaths = [];
        foreach ($ids as $id) {
            $pdfPaths[] = self::generatePDF($id);
        }

        $mergedPdfPath = self::mergePDFs($pdfPaths);

        // Clean up temporary files
        foreach ($pdfPaths as $pdfPath) {
            Storage::delete($pdfPath);
        }

        return response()->download($mergedPdfPath, 'List Bulk Muet ' . date('d_m_y') . ' RESULT.pdf')->deleteFileAfterSend(true);
    }

    public function logDownload(Request $request)
    {
        try {
            $id = Crypt::decrypt($request->id);
        } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
            return redirect()->back();
        }

        $value = explode('-', $id);
        $certID = $value[0];
        $type = $value[1];

        $candidateId = Auth::guard('candidate')->id();

        // Log the download activity
        CandidateActivityLog::create([
            'candidate_id' => $candidateId,
            'activity_type' => 'download_result',
            'type' => $type
        ]);

        return response()->json(['status' => 'success']);
    }

    public function indexCandidate()
    {
        return view('modules.admin.administration.manage-candidates.index');
    }

    public function indexModCandidate()
    {
        return view('modules.admin.administration.manage-candidates.mod-candidate.index');
    }


    public function searchCandidate(Request $request)
    {
        // $users = Auth::check() ? User::where('id', '!=', Auth::id())->get() : abort(403);
        $candidates = Candidate::query();

        // Check if a search term was provided
        if ($request->has('search') && !empty($request->input('search'))) {
            $searchTerm = $request->input('search');
            $query->where('column1', 'like', '%' . $searchTerm . '%')
                ->orWhere('column2', 'like', '%' . $searchTerm . '%')
                ->orWhere('column3', 'like', '%' . $searchTerm . '%');
        }

        $data = [];
        foreach ($candidates as $candidate) {
            $data[] = [
                // "id"    => Crypt::encrypt($user->id),
                "id"    => $candidate->id,
                "name"  => $candidate->name,
                "nric"  => $candidate->identity_card_number,
            ];
        };

        return datatables($data)->toJson();
    }

    // public function ajaxCandidate(Request $request)
    // {

    //     // dd($request->toArray(), $request->search);
    //     // Check if a search term was provided and is not empty
    //     if (!$request->filled('search')) {
    //         // dd("hello");
    //         // Return empty DataTables response if search is empty or null
    //         return DataTables::of([])->toJson();
    //     }
    //     // dd($request->search);
    //     // Fetch records from the Candidate model with server-side processing
    //     $candidates = Candidate::query();

    //     // Check if a search term was provided and perform search
    //     if ($request->filled('search')) {
    //         $searchTerm = $request->input('search');
    //         $candidates->where('name', 'like', '%' . $searchTerm . '%')
    //                 ->orWhere('identity_card_number', 'like', '%' . $searchTerm . '%');
    //     }

    //     // Return the DataTable response
    //     return DataTables::of($candidates)
    //         ->addColumn('name', function ($candidate) {
    //             return $candidate->name;
    //         })
    //         ->addColumn('nric', function ($candidate) {
    //             return $candidate->identity_card_number; // Assuming 'nric' is a column in your database
    //         })
    //         ->addColumn('action', function ($candidate) {
    //             return '<button type="button" class="btn btn-sm btn-info" id="show_edit_modal" data-id="' . $candidate->id . '">Action</button>';
    //         })
    //         ->toJson();
    // }

    public function ajaxCandidate(Request $request)
    {
        // Check if a search term was provided and is not empty
        if (!$request->filled('search')) {
            return DataTables::of([])->toJson();
        }

        // Fetch records from the Candidate model with joins to muet_calon and muet_skor
        $candidates = Candidate::query()
            ->join('muet_calon', function ($join) {
                $join->on('candidates.name', '=', 'muet_calon.nama')
                    ->on('candidates.identity_card_number', '=', 'muet_calon.kp');
            })
            ->join('muet_skor', function ($join) {
                $join->on('muet_calon.tahun', '=', 'muet_skor.tahun')
                    ->on('muet_calon.sidang', '=', 'muet_skor.sidang')
                    ->on('muet_calon.jcalon', '=', 'muet_skor.jcalon')
                    ->on('muet_calon.nocalon', '=', 'muet_skor.nocalon')
                    ->on('muet_calon.kodnegeri', '=', 'muet_skor.kodnegeri')
                    ->on('muet_calon.kodpusat', '=', 'muet_skor.kodpusat');
            })
            ->select(
                'candidates.id',
                'candidates.name',
                'candidates.identity_card_number',
                'muet_calon.angka_giliran',
                'muet_calon.sidang',
                'muet_calon.tahun',
                'muet_skor.kodkts',
                'muet_skor.mkhbaru',
                'muet_calon.skor_agregat',
                'muet_calon.band'
            );

        // Apply search filtering if needed
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $candidates->where(function ($query) use ($searchTerm) {
                $query->where('candidates.name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('candidates.identity_card_number', 'like', '%' . $searchTerm . '%')
                    ->orWhere('muet_calon.nama', 'like', '%' . $searchTerm . '%')
                    ->orWhere('muet_calon.kp', 'like', '%' . $searchTerm . '%');
            });
        }

        // Fetch and group candidates by id
        $candidates = $candidates->get()->groupBy('id')->map(function ($rows) {
            $firstRow = $rows->first();

            // Group kodkts and mkhbaru into associative arrays
            $kodkts = [];
            $mkhbaru = [];

            foreach ($rows as $row) {
                $kodkts[] = $row->kodkts;
                $mkhbaru[] = $row->mkhbaru;
            }

            // Ensure the arrays are correctly aligned
            return [
                'id' => $firstRow->id,
                'name' => $firstRow->name,
                'nric' => $firstRow->identity_card_number,
                'angka_giliran' => $firstRow->angka_giliran,
                'sidang' => $firstRow->sidang,
                'tahun' => $firstRow->tahun,
                'kodkts' => $kodkts,
                'mkhbaru' => $mkhbaru,
                'skor_agregat' => $firstRow->skor_agregat,
                'band' => $firstRow->band
            ];
        })->values();

        return DataTables::of($candidates)
            ->addColumn('name', function ($candidate) {
                return $candidate['name'];
            })
            ->addColumn('nric', function ($candidate) {
                return $candidate['nric'];
            })
            ->addColumn('angka_giliran', function ($candidate) {
                return $candidate['angka_giliran'];
            })
            ->addColumn('sidang', function ($candidate) {
                return $candidate['sidang'];
            })
            ->addColumn('tahun', function ($candidate) {
                return $candidate['tahun'];
            })
            ->addColumn('kodkts', function ($candidate) {
                return implode(', ', $candidate['kodkts']);
            })
            ->addColumn('mkhbaru', function ($candidate) {
                return implode(', ', $candidate['mkhbaru']);
            })
            ->addColumn('skor_agregat', function ($candidate) {
                return $candidate['skor_agregat'];
            })
            ->addColumn('band', function ($candidate) {
                return $candidate['band'];
            })
            ->addColumn('action', function ($candidate) {
                return '<button type="button" class="btn btn-sm btn-info" id="show_edit_modal" data-id="' . $candidate['id'] . '">Action</button>';
            })
            ->toJson();
    }

    public function ajaxModCandidate(Request $request)
    {
        // Check if a search term was provided and is not empty
        if (!$request->filled('search')) {
            return DataTables::of([])->toJson();
        }

        // Fetch records from the Candidate model with joins to mod_calon and mod_skor
        $candidates = Candidate::query()
            ->join('mod_calon', function ($join) {
                $join->on('candidates.name', '=', 'mod_calon.nama')
                    ->on('candidates.identity_card_number', '=', 'mod_calon.kp');
            })
            ->join('mod_skor', function ($join) {
                $join->on('mod_calon.tahun', '=', 'mod_skor.tahun')
                    ->on('mod_calon.sidang', '=', 'mod_skor.sidang')
                    // ->on('mod_calon.jcalon', '=', 'mod_skor.jcalon')
                    ->on('mod_calon.reg_id', '=', 'mod_skor.reg_id')
                    ->on('mod_calon.nocalon', '=', 'mod_skor.nocalon')
                    ->on('mod_calon.kodnegeri', '=', 'mod_skor.kodnegeri')
                    ->on('mod_calon.kodpusat', '=', 'mod_skor.kodpusat');
            })
            ->select(
                'candidates.id',
                'candidates.name',
                'candidates.identity_card_number',
                'mod_calon.angka_giliran',
                'mod_calon.sidang',
                'mod_calon.tahun',
                'mod_skor.kodkts',
                'mod_skor.skorbaru',
                'mod_calon.skor_agregat',
                'mod_calon.band'
            );

        // Apply search filtering if needed
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $candidates->where(function ($query) use ($searchTerm) {
                $query->where('candidates.name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('candidates.identity_card_number', 'like', '%' . $searchTerm . '%')
                    ->orWhere('mod_calon.nama', 'like', '%' . $searchTerm . '%')
                    ->orWhere('mod_calon.kp', 'like', '%' . $searchTerm . '%');
            });
        }

        // Fetch and group candidates by id
        $candidates = $candidates->get()->groupBy('id')->map(function ($rows) {
            $firstRow = $rows->first();

            // Group kodkts and skorbaru into associative arrays
            $kodkts = [];
            $skorbaru = [];

            foreach ($rows as $row) {
                $kodkts[] = $row->kodkts;
                $skorbaru[] = $row->skorbaru;
            }

            // Ensure the arrays are correctly aligned
            return [
                'id' => $firstRow->id,
                'name' => $firstRow->name,
                'nric' => $firstRow->identity_card_number,
                'angka_giliran' => $firstRow->angka_giliran,
                'sidang' => $firstRow->sidang,
                'tahun' => $firstRow->tahun,
                'kodkts' => $kodkts,
                'skorbaru' => $skorbaru,
                'skor_agregat' => $firstRow->skor_agregat,
                'band' => $firstRow->band
            ];
        })->values();

        return DataTables::of($candidates)
            ->addColumn('name', function ($candidate) {
                return $candidate['name'];
            })
            ->addColumn('nric', function ($candidate) {
                return $candidate['nric'];
            })
            ->addColumn('angka_giliran', function ($candidate) {
                return $candidate['angka_giliran'];
            })
            ->addColumn('sidang', function ($candidate) {
                return $candidate['sidang'];
            })
            ->addColumn('tahun', function ($candidate) {
                return $candidate['tahun'];
            })
            ->addColumn('kodkts', function ($candidate) {
                return implode(', ', $candidate['kodkts']);
            })
            ->addColumn('skorbaru', function ($candidate) {
                return implode(', ', $candidate['skorbaru']);
            })
            ->addColumn('skor_agregat', function ($candidate) {
                return $candidate['skor_agregat'];
            })
            ->addColumn('band', function ($candidate) {
                return $candidate['band'];
            })
            ->addColumn('action', function ($candidate) {
                return '<button type="button" class="btn btn-sm btn-info" id="show_edit_modal" data-id="' . $candidate['id'] . '">Action</button>';
            })
            ->toJson();
    }

    // public function updateCandidate(Request $request, Candidate $candidate)
    // {

    //     // Validate the file
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required',
    //         'nric' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         // Convert the error messages to a string
    //         $errorMessages = implode(', ', $validator->messages()->all());
    //         $data = [
    //             'success' => false,
    //             'message' => $errorMessages,
    //         ];
    //         return response()->json($data);
    //     }

    //     // Old data
    //     $old = [
    //         "name" => $candidate->name,
    //         "nric" => $candidate->identity_card_number,
    //     ];

    //     // New data
    //     $new = [
    //         "name" => $request->name,
    //         "nric" => $request->nric,
    //     ];

    //     //sanitize value
    //     $candidate->name = $request->name;
    //     $candidate->identity_card_number = $request->nric;

    //     $candidate->save();

    //     //Find MuetCalon
    //     $muetCalon = MuetCalon::where('kp', $candidate->identity_card_number)->get();
    //     if ($muetCalon->isNotEmpty()) {
    //         foreach ($muetCalon as $key => $value) {
    //             $value->nama = $candidate->name;
    //             $value->kp = $candidate->identity_card_number;
    //             $value->save();
    //         }
    //     }

    //     //Find ModCalon
    //     $modCalon = ModCalon::where('kp', $candidate->identity_card_number)->get();
    //     if ($modCalon->isNotEmpty()) {  // Check if the collection is not empty
    //         foreach ($modCalon as $key => $value) {
    //             $value->nama = $candidate->name;
    //             $value->kp = $candidate->identity_card_number;
    //             $value->save();
    //         }
    //     }

    //     // Compare old and new data, and unset identical values
    //     foreach ($old as $key => $value) {
    //         if ($old[$key] === $new[$key]) {
    //             unset($old[$key]);
    //             unset($new[$key]);
    //         }
    //     }

    //     AuditLogService::log($candidate, 'Update candidate', $old, $new);

    //     $data = [
    //         'success' => true,
    //         'message' => 'Candidate updated successfully',
    //     ];
    //     return response()->json($data);
    // }

    public function updateCandidate(Request $request, Candidate $candidate)
    {
        // Validate the required fields
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'nric' => 'required',
            'listening_score' => 'required|numeric',
            'speaking_score' => 'required|numeric',
            'reading_score' => 'required|numeric',
            'writing_score' => 'required|numeric',
            'aggregated_score' => 'required|numeric',
            'band_achieved' => 'required|string',
        ]);

        if ($validator->fails()) {
            // Convert the error messages to a string
            $errorMessages = implode(', ', $validator->messages()->all());
            return response()->json([
                'success' => false,
                'message' => $errorMessages,
            ]);
        }

        // Old data (for audit log comparison)
        $old = [
            "name" => $candidate->name,
            "nric" => $candidate->identity_card_number,
        ];

        $old_nric = $candidate->identity_card_number;

        // New data
        $new = [
            "name" => $request->name,
            "nric" => $request->nric,
            "listening_score" => $request->listening_score,
            "speaking_score" => $request->speaking_score,
            "reading_score" => $request->reading_score,
            "writing_score" => $request->writing_score,
            "aggregated_score" => $request->aggregated_score,
            "band_achieved" => $request->band_achieved,
        ];

        // Update candidate basic details
        $candidate->name = $request->name;
        $candidate->identity_card_number = $request->nric;
        $candidate->save();

        // Update MUET Calon table
        $muetCalon = MuetCalon::where('kp', $old_nric)->first();
        if ($muetCalon) {
            $muetCalon->nama = $candidate->name;
            $muetCalon->kp = $candidate->identity_card_number;
            $muetCalon->skor_agregat = $request->aggregated_score;
            $muetCalon->band = $request->band_achieved;
            $muetCalon->save();
        }

        // Update remaining MUET Calon table
        MuetCalon::where('kp', $old_nric)
            ->update([
                'nama'  => $candidate->name,
                'kp'    => $candidate->identity_card_number
            ]);

        // Update remaining MOD Calon table
        ModCalon::where('kp', $old_nric)
            ->update([
                'nama'  => $candidate->name,
                'kp'    => $candidate->identity_card_number
            ]);


        // Update MUET Skor table
        if ($muetCalon) {
            $kodktsMapping = [
                1 => $request->listening_score,
                2 => $request->speaking_score,
                3 => $request->reading_score,
                4 => $request->writing_score,
            ];

            foreach ($kodktsMapping as $kodkts => $score) {
                $muetSkor = MuetSkor::where('tahun', $muetCalon->tahun)
                    ->where('sidang', $muetCalon->sidang)
                    ->where('jcalon', $muetCalon->jcalon)
                    ->where('nocalon', $muetCalon->nocalon)
                    ->where('kodnegeri', $muetCalon->kodnegeri)
                    ->where('kodpusat', $muetCalon->kodpusat)
                    ->where('kodkts', $kodkts)
                    ->first();

                if ($muetSkor) {
                    $muetSkor->mkhbaru = $score;
                    $muetSkor->save();
                }
            }
        }

        // Compare old and new data, and unset identical values
        foreach ($old as $key => $value) {
            if ($old[$key] === $new[$key]) {
                unset($old[$key]);
                unset($new[$key]);
            }
        }

        // Log the changes in the AuditLog
        AuditLogService::log($candidate, 'Update candidate', $old, $new);

        // Return success message
        return response()->json([
            'success' => true,
            'message' => 'Candidate updated successfully',
        ]);
    }


    public function updateModCandidate(Request $request, Candidate $candidate)
    {
        // Validate the required fields
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'nric' => 'required',
            'listening_score' => 'required|numeric',
            'speaking_score' => 'required|numeric',
            'reading_score' => 'required|numeric',
            'writing_score' => 'required|numeric',
            'aggregated_score' => 'required|numeric',
            'band_achieved' => 'required|string',
        ]);

        if ($validator->fails()) {
            // Convert error messages to a string
            $errorMessages = implode(', ', $validator->messages()->all());
            return response()->json([
                'success' => false,
                'message' => $errorMessages,
            ]);
        }

        // Old data (for audit log comparison)
        $old = [
            "name" => $candidate->name,
            "nric" => $candidate->identity_card_number,
        ];

        // New data to be compared with old for auditing
        $new = [
            "name" => $request->name,
            "nric" => $request->nric,
            "aggregated_score" => $request->aggregated_score,
            "band_achieved" => $request->band_achieved,
            "scores" => implode(',', [
                $request->listening_score,
                $request->speaking_score,
                $request->reading_score,
                $request->writing_score
            ])
        ];

        // Update the candidate's basic information
        $candidate->name = $request->name;
        $candidate->identity_card_number = $request->nric;
        $candidate->save();

        // Update modCalon table
        $modCalon = modCalon::where('kp', $candidate->identity_card_number)->first();
        if ($modCalon) {
            $modCalon->nama = $candidate->name;
            $modCalon->kp = $candidate->identity_card_number;
            $modCalon->skor_agregat = $request->aggregated_score;
            $modCalon->band = $request->band_achieved;
            $modCalon->save();
        }

        // Update modSkor table for each skill based on kodkts
        if ($modCalon) {
            $kodktsMapping = [
                1 => $request->listening_score,
                2 => $request->speaking_score,
                3 => $request->reading_score,
                4 => $request->writing_score,
            ];

            foreach ($kodktsMapping as $kodkts => $score) {
                $modSkor = modSkor::where('tahun', $modCalon->tahun)
                    ->where('sidang', $modCalon->sidang)
                    ->where('reg_id', $modCalon->reg_id)
                    ->where('nocalon', $modCalon->nocalon)
                    ->where('kodnegeri', $modCalon->kodnegeri)
                    ->where('kodpusat', $modCalon->kodpusat)
                    ->where('kodkts', $kodkts)
                    ->first();

                if ($modSkor) {
                    $modSkor->skorbaru = $score;
                    $modSkor->save();
                }
            }
        }

        // Compare old and new data and unset identical values for audit logging
        foreach ($old as $key => $value) {
            if ($old[$key] === $new[$key]) {
                unset($old[$key]);
                unset($new[$key]);
            }
        }

        // Log the changes in the AuditLog
        AuditLogService::log($candidate, 'Update candidate', $old, $new);

        // Return success message
        return response()->json([
            'success' => true,
            'message' => 'Candidate updated successfully',
        ]);
    }
}
