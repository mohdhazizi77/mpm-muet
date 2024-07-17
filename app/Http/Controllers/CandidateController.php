<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

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
use App\Models\CandidateActivityLog;
use Carbon\Carbon;
use setasign\Fpdi\Fpdi;
use setasign\Fpdf\Fpdf;
use Exception;
use DataTables;
class CandidateController extends Controller
{

    public function index()
    {
        // dd(Auth::User(), Auth::User()->getRoleNames()[0]);

        $user = Auth::User() ? Auth::User() : abort(403);
        $muets = $user->muetCalon;
        $mods = $user->modCalon;
        $config = ConfigGeneral::get()->first();
        // dd($user->muetCalon);


        // foreach ($certificates as $key => $certificate) {
        //     $certificate->exam_session_name = $certificate->examsession->name .", ".$certificate->examsession->year;
        //     $certificate->band = unserialize($certificate->result)['band'];
        // }

        return view('modules.candidates.index',
            compact([
                'user',
                'config',
            ]));
    }

    public function getAjax()
    {
        $candidate = Auth::User() ? Auth::User() : abort(403);

        $muets = $candidate->muetCalon;
        $mods = $candidate->modCalon;
        // $certificates = $muets->concat($mods);

        // Set attribute for each item in the combined collection
        // $certificates = $certificates->map(function ($certificate) {
        //     if ($certificate instanceof MuetCalon) {
        //         $certificate->setAttribute('model_type', 'MuetCalon');
        //     } elseif ($certificate instanceof ModCalon) {
        //         $certificate->setAttribute('model_type', 'ModCalon');
        //     }
        //     return $certificate;
        // });

        $cutoffTime = Carbon::now()->subDay(); // Get the current time and subtract 24 hours to get the cutoff time
        foreach ($muets as $key => $muet) {

            $is_more2year = self::checkYear($muet->getTarikh->tahun); //check cert if already 2 years
            $is_selfPrintPaid = false;
            $is_mpmPrintPaid = false;
            if ($is_more2year) {
                // $res = $muet->getOrder->where('payment_status','SUCCESS')->where('payment_for', 'SELF_PRINT')->toArray();

                $res = $muet->getOrder()
                        ->where('payment_status', 'SUCCESS')
                        ->where('payment_for', 'SELF_PRINT')
                        ->where('created_at', '>=', $cutoffTime)
                        ->get()
                        ->toArray();
                $is_selfPrintPaid = count($res)>0 ? true : false;

                $res = $muet->getOrder->where('payment_status','SUCCESS')->where('payment_for', 'MPM_PRINT')->toArray();
                $is_mpmPrintPaid = count($res)>0 ? true : false;
            } else {
                $res = $muet->getOrder->where('payment_status','SUCCESS')->where('payment_for', 'SELF_PRINT')->toArray();
                $is_selfPrintPaid = count($res)>0 ? true : false;

                $res = $muet->getOrder->where('payment_status','SUCCESS')->where('payment_for', 'MPM_PRINT')->toArray();
                $is_mpmPrintPaid = count($res)>0 ? true : false;
            }

            $cert_datas[] = [
                "no"                => ++$key,
                "id"                => Crypt::encrypt($muet->id . "-MUET"), // xxx-MUET or xxx-MOD
                // "id"                => $muet->id . "-MUET", // xxx-MUET or xxx-MOD
                "type"              => 'MUET',
                "year"              => $muet->tahun,
                "session"           => $muet->getTarikh->sesi,
                "band"              => "Band ".self::formatNumber($muet->band),
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
                $is_selfPrintPaid = count($res)>0 ? true : false;

                $res = $mod->getOrder->where('payment_status','SUCCESS')->where('payment_for', 'MPM_PRINT')->toArray();
                $is_mpmPrintPaid = count($res)>0 ? true : false;
            } else {
                $res = $mod->getOrder->where('payment_status','SUCCESS')->where('payment_for', 'SELF_PRINT')->toArray();
                $is_selfPrintPaid = count($res)>0 ? true : false;

                $res = $mod->getOrder->where('payment_status','SUCCESS')->where('payment_for', 'MPM_PRINT')->toArray();
                $is_mpmPrintPaid = count($res)>0 ? true : false;
            }

            $cert_datas[] = [
                "no"                => ++$key,
                "id"                => Crypt::encrypt($mod->id . "-MOD"), // xxx-MUET or xxx-MOD
                // "id"                => $muet->id . "-MUET", // xxx-MUET or xxx-MOD
                "type"              => 'MOD',
                "year"              => $mod->tahun,
                "session"           => $mod->getTarikh->sesi,
                "band"              => "Band ".$mod->band,
                "is_more2year"      => $is_more2year,
                "is_selfPrintPaid"  => $is_selfPrintPaid,
                "is_mpmPrintPaid"   => $is_mpmPrintPaid,
            ];

        }

        return datatables($cert_datas)->toJson();
    }

    function formatNumber($number) {
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
        if ($result['year'] > 2021) {
            $scheme = [
                "listening" => 90,
                "speaking" => 90,
                "reading" => 90,
                "writing" => 90,
                "agg_score" => 360,
            ];
        } else if($result['year'] > 2008 && $result['year'] < 2021){
            $scheme = [
                "listening" => 45,
                "speaking" => 45,
                "reading" => 120,
                "writing" => 90,
                "agg_score" => 360,
            ];
        } else { // lees than 2008
            $scheme = [
                "listening" => 45,
                "speaking" => 45,
                "reading" => 135,
                "writing" => 75,
                "agg_score" => 360,
            ];
        }

        // Log result view activity
        CandidateActivityLog::create([
            'candidate_id' => Auth::guard('candidate')->id(),
            'activity_type' => 'view_result',
            'type'          => $type
        ]);

        return view('modules.candidates.print-pdf', compact(['user','scheme','result','cryptId']));

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
            $pusat = $candidate->getPusat->first();
            $tarikh = $candidate->getTarikh;
            $result = $candidate->getResult($candidate);
            if ($result['year'] > 2021) {
                $scheme = [
                    "listening" => 90,
                    "speaking" => 90,
                    "reading" => 90,
                    "writing" => 90,
                    "agg_score" => 360,
                ];
            } else if($result['year'] > 2008 && $result['year'] < 2021){
                $scheme = [
                    "listening" => 45,
                    "speaking" => 45,
                    "reading" => 120,
                    "writing" => 90,
                    "agg_score" => 360,
                ];
            } else { // lees than 2008
                $scheme = [
                    "listening" => 45,
                    "speaking" => 45,
                    "reading" => 135,
                    "writing" => 75,
                    "agg_score" => 360,
                ];
            }

            $url = 'http://localhost:8000/qrscan'; // Replace with your URL or data
            $url = config('app.url').'/verify/result/'.$cryptId; // Replace with your URL or data /verify/result/{id}
            $qr = QrCode::size(50)->style('round')->generate($url);

            $pdf = PDF::loadView('modules.candidates.download-pdf', [
                'tarikh' => $tarikh,
                'qr' => $qr,
                'type' => $type,
                'result' => $result,
                'candidate' => $candidate,
                'scheme' => $scheme,
                'pusat' => $pusat,
                'image1Data' => config('base64_images.jataNegara'),
                'image2Data' => config('base64_images.logoMPM'),
                'image3Data' => config('base64_images.sign'),
            ])
            ->setPaper('a4', 'portrait')
            ->setOptions(['isRemoteEnabled' => true]);
            // return $pdf->download($result['index_number'].' '.$type.' RESULT.pdf');
            return $pdf->stream($result['index_number'].' '.$type.' RESULT.pdf');

        } catch
        (Exception $e) {
            return back()->withError($e->getMessage());
        }
    }
    public function downloadpdfCandidate($id, $type)
    {
        try {

            if ($type == "MUET") {
                $candidate = MuetCalon::find($id);
            } else {
                $candidate = ModCalon::find($id);
            }
            $pusat = $candidate->getPusat->first();
            $tarikh = $candidate->getTarikh;
            $result = $candidate->getResult($candidate);
            if ($result['year'] > 2021) {
                $scheme = [
                    "listening" => 90,
                    "speaking" => 90,
                    "reading" => 90,
                    "writing" => 90,
                    "agg_score" => 360,
                ];
            } else if($result['year'] > 2008 && $result['year'] < 2021){
                $scheme = [
                    "listening" => 45,
                    "speaking" => 45,
                    "reading" => 120,
                    "writing" => 90,
                    "agg_score" => 360,
                ];
            } else { // lees than 2008
                $scheme = [
                    "listening" => 45,
                    "speaking" => 45,
                    "reading" => 135,
                    "writing" => 75,
                    "agg_score" => 360,
                ];
            }

            $cryptId = Crypt::encrypt($id . "-" . $type);
            $url = 'http://localhost:8000/qrscan'; // Replace with your URL or data
            $url = config('app.url').'/verify/result/'.$cryptId; // Replace with your URL or data /verify/result/{id}
            $qr = QrCode::size(50)->style('round')->generate($url);

            $pdf = PDF::loadView('modules.candidates.download-pdf', [
                'tarikh' => $tarikh,
                'qr' => $qr,
                'type' => $type,
                'result' => $result,
                'candidate' => $candidate,
                'scheme' => $scheme,
                'pusat' => $pusat,
                'image1Data' => config('base64_images.jataNegara'),
                'image2Data' => config('base64_images.logoMPM'),
                'image3Data' => config('base64_images.sign'),
            ])
            ->setPaper('a4', 'portrait')
            ->setOptions(['isRemoteEnabled' => true]);
            // return $pdf->download($type.' RESULT.pdf');
            return $pdf->stream($result['index_number'].' '.$type.' RESULT.pdf');

        } catch
        (Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    public function singleDownloadPdf($cryptId)
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
            $pusat = $candidate->getPusat->first();
            $tarikh = $candidate->getTarikh;
            $result = $candidate->getResult($candidate);
            if ($result['year'] > 2021) {
                $scheme = [
                    "listening" => 90,
                    "speaking" => 90,
                    "reading" => 90,
                    "writing" => 90,
                    "agg_score" => 360,
                ];
            } else if($result['year'] > 2008 && $result['year'] < 2021){
                $scheme = [
                    "listening" => 45,
                    "speaking" => 45,
                    "reading" => 120,
                    "writing" => 90,
                    "agg_score" => 360,
                ];
            } else { // lees than 2008
                $scheme = [
                    "listening" => 45,
                    "speaking" => 45,
                    "reading" => 135,
                    "writing" => 75,
                    "agg_score" => 360,
                ];
            }
            $url = 'http://localhost:8000/qrscan'; // Replace with your URL or data
            $url = config('app.url').'/verify/result/'.$cryptId; // Replace with your URL or data /verify/result/{id}

            $qr = QrCode::size(50)->style('round')->generate($url);


            $pdf = PDF::loadView('modules.candidates.download-pdf', [
                'tarikh' => $tarikh,
                'qr' => $qr,
                'type' => $type,
                'result' => $result,
                'candidate' => $candidate,
                'scheme' => $scheme,
                'pusat' => $pusat,
                'image1Data' => config('base64_images.jataNegara'),
                'image2Data' => config('base64_images.logoMPM'),
                'image3Data' => config('base64_images.sign'),
            ])
            ->setPaper('a4', 'portrait')
            ->setOptions(['isRemoteEnabled' => true]);
            return $pdf->download($result['index_number'].' '.$type.' RESULT.pdf');

        } catch
        (Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    public function bulkDownloadPdf(Request $request)
    {
        // dd($request->toArray());
        $arr_calon= [];
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
                $arr_calon[] =  $order->muet_calon_id.'-MUET';
            } else { //MOD
                $arr_calon[] = $order->mod_calon_id.'-MOD';
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
        if ($result['year'] > 2021) {
            $scheme = [
                "listening" => 90,
                "speaking" => 90,
                "reading" => 90,
                "writing" => 90,
                "agg_score" => 360,
            ];
        } else if($result['year'] > 2008 && $result['year'] < 2021){
            $scheme = [
                "listening" => 45,
                "speaking" => 45,
                "reading" => 120,
                "writing" => 90,
                "agg_score" => 360,
            ];
        } else { // lees than 2008
            $scheme = [
                "listening" => 45,
                "speaking" => 45,
                "reading" => 135,
                "writing" => 75,
                "agg_score" => 360,
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
                        ->where('payment_for', 'SELF_PRINT')
                        ->where('created_at', '>=', $cutoffTime)
                        ->get()
                        ->toArray();

            $show_result = count($res)>0 ? true : false;
        } else {
            $show_result = true ;
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


        $order = Order::find($orderId);
        $tracks = TrackingOrder::where('order_id',$orderId)->latest()->get();
        $payment = Payment::where('order_id',$orderId)->first();


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
        if ($result['year'] > 2021) {
            $scheme = [
                "listening" => 90,
                "speaking" => 90,
                "reading" => 90,
                "writing" => 90,
                "agg_score" => 360,
            ];
        } else if($result['year'] > 2008 && $result['year'] < 2021){
            $scheme = [
                "listening" => 45,
                "speaking" => 45,
                "reading" => 120,
                "writing" => 90,
                "agg_score" => 360,
            ];
        } else { // lees than 2008
            $scheme = [
                "listening" => 45,
                "speaking" => 45,
                "reading" => 135,
                "writing" => 75,
                "agg_score" => 360,
            ];
        }

        // dd($candidate->getResult($candidate));
        return view('modules.candidates.verify-result', compact(['candidate','scheme','result','cryptId']));

    }

    function generatePDF($id) {
        $value = explode('-', $id);
        $certID = $value[0];
        $type = $value[1];

        if ($type == "MUET") {
            $candidate = MuetCalon::find($certID);
        } else {
            $candidate = ModCalon::find($certID);
        }
        $pusat = $candidate->getPusat->first();
        $tarikh = $candidate->getTarikh;
        $result = $candidate->getResult($candidate);
        if ($result['year'] > 2021) {
            $scheme = [
                "listening" => 90,
                "speaking" => 90,
                "reading" => 90,
                "writing" => 90,
                "agg_score" => 360,
            ];
        } else if($result['year'] > 2008 && $result['year'] < 2021){
            $scheme = [
                "listening" => 45,
                "speaking" => 45,
                "reading" => 120,
                "writing" => 90,
                "agg_score" => 360,
            ];
        } else { // lees than 2008
            $scheme = [
                "listening" => 45,
                "speaking" => 45,
                "reading" => 135,
                "writing" => 75,
                "agg_score" => 360,
            ];
        }

        $cryptId = Crypt::encrypt($certID);
        $url = config('app.url').'/verify/result/'.$id;
        $qr = QrCode::size(50)->style('round')->generate($url);

        $pdf = PDF::loadView('modules.candidates.download-pdf', [
            'tarikh' => $tarikh,
            'qr' => $qr,
            'type' => $type,
            'result' => $result,
            'candidate' => $candidate,
            'scheme' => $scheme,
            'pusat' => $pusat,
            'image1Data' => config('base64_images.jataNegara'),
            'image2Data' => config('base64_images.logoMPM'),
            'image3Data' => config('base64_images.sign'),
        ])
        ->setPaper('a4', 'portrait')
        ->setOptions(['isRemoteEnabled' => true]);

        $pdfPath = storage_path('app/temp/'.$id.'.pdf');
        $pdf->save($pdfPath);

        return $pdfPath;
    }

    function mergePDFs($pdfPaths) {
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

    function processBulkPDF($ids) {
        $pdfPaths = [];
        foreach ($ids as $id) {
            $pdfPaths[] = self::generatePDF($id);
        }

        $mergedPdfPath = self::mergePDFs($pdfPaths);

        // Clean up temporary files
        foreach ($pdfPaths as $pdfPath) {
            Storage::delete($pdfPath);
        }

        return response()->download($mergedPdfPath, 'List Bulk Muet '.date('d_m_y').' RESULT.pdf')->deleteFileAfterSend(true);
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
}
