<?php

namespace App\Http\Controllers;

use App\Models\BandDescriptionsHeader;
use App\Models\Candidate;
use App\Models\CefrConfig;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = Auth::User() ? Auth::User() : abort(403);

        $descriptions = CefrConfig::query()
            ->where('year', 2023)
            ->where('session', 1)
            ->get();

        return view('candidates.index',
            compact([
                'user',
                'descriptions',
            ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Candidate $candidate)
    {
//        $user = Auth::User() ? Auth::User() : abort(403);

        return view('candidates.show');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Candidate $candidate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Candidate $candidate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Candidate $candidate)
    {
        //
    }

    public function printpdf()
    {
        return view('candidates.print-pdf');
    }

    public function qrscan()
    {
        return view('candidates.qr-scan');
    }

    public function downloadpdf()
    {
        try {

            $url = 'http://localhost:8000/qrscan'; // Replace with your URL or data
            $qr = QrCode::size(50)->style('round')->generate($url);

//            dd($qr);

            $pdf = PDF::loadView('candidates.download-pdf', ['qr' => $qr])->setPaper('a4', 'portrait');

            return $pdf->download('MUET RESULT.pdf');

        } catch
        (Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    public function printmpm()
    {
        $status = 0;
        return view('candidates.print-mpm', compact([
            'status',
        ]));
    }

    public function payment()
    {

// $url = 'http://mpm-pay-web.test/api/payment/create';
// $token = 'Ry7QE2LZ0eIrD7S1LijxKyeyLiT9ZNxVom7TwHBhQbrQriP2dsIqkcc5785h';
// $secret_key = '7b5b9128-80f5-4fa9-9efc-7e9746b82a27';

// $url = 'https://ebayar.mpm.edu.my/api/payment/create';
// $token = 'slmTa0evIzLCj20uqFcL3bAzk13JpoptxWRQV7ZrtWvwYTQ8y6skqsb6mINf';
// $secret_key = '83fe0a62-afb8-4e95-9985-488a2ff56193';

        $url = 'https://ebayar-lab.mpm.edu.my/api/payment/create';
        $token = 'a2aWmIGjPSVZ8F3OvS2BtppKM2j6TKvKXE7u8W7MwbkVyZjwZfSYdNP5ACem';
        $secret_key = '1eafc1e9-df86-4c8c-a3de-291ada259ab0';

        $data = [
            "full_name" => "ALI BIN ABU",
            "phone_number" => "0133422881",
            "email_address" => "aliabu@gmail.com",
            "amount" => "67.90",
            "nric" => "900101121357",
            "extra_data" => "poslaju",
        ];

// {"full_name":"MIOR MOHD HANIF YOB","phone_number":"0133422881","email_address":"miorhanif@mpm.edu.my","amount":"1660","nric":"870806385211","extra_data":"870806385211|1|2,18|IGCSE REGISTRATION","order_id":"870806385211|1|2,18","hash":"f89fb9a5026145e145d4021bd1ff1e5046083a269a83b3fb0cc3e070f4353344"}

        $hash = hash_hmac('SHA256', urlencode($secret_key) . urlencode($data['full_name']) . urlencode($data['phone_number']) . urlencode($data['email_address']) . urlencode($data['amount']), $secret_key);
        $data['hash'] = $hash;
        header("Location: " . $this->createPayment($url, $data, $token));
        exit();
//        $this->createPayment($url, $data, $token);

//        echo "\n";

    }

    public function paymentstatus(Request $request)
    {
//        dd($request);
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
                return view('candidates.print-mpm-return', compact([
                    'status',
                    'ref_no',
                    'txn_id',
                ]));
            } elseif ($status == 'FAILED') {
                return view('candidates.print-mpm', compact([
                    'status',
                    'ref_no',
                    'txn_id',
                ]));
            }


//            dd($full_name);

//            $file = fopen("log\logsalinansijil_" . date('d-m-Y') . ".txt", "a+");
//
//            fwrite($file, json_encode($_REQUEST));
//            fclose($file);

            //update or store data to application.

            //mysql update query

            //laravel eloquent model
        }
    }

    public function muetstatus()
    {
        $status = 0;
        $ref_no = '';
        $txn_id = '';

        return view('candidates.muet-status', compact([
            'status',
            'ref_no',
            'txn_id',
        ]));
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
//        echo $output;

        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
//            var_dump($error_msg);
            exit();
        }
//        var_dump($output . 'zz');
//        exit();
        if (!empty($output->url)) {
            curl_close($curl);
            return $output->url;
        } else {
            return "Payment Gateway tidak dapat disambung. Pastikan URL dan TOKEN adalah betul.";
            curl_close($curl);
        }
    }
}
