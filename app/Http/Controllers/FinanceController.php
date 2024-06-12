<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use DataTables;


class FinanceController extends Controller
{
    public function index($exam_type)
    {
        if (!in_array($exam_type, ['muet', 'mod'])) {
            abort(404);
        }

        $user = Auth::User() ? Auth::User() : abort(403);

        $startDate = date('Y-m-d 00:00:00'); // Current start date and time (00:00:00)
        $endDate = date('Y-m-d 23:59:59');   // Current end date and time (23:59:59)

        $type = $exam_type;
        $exam_type = strtoupper($exam_type);

        $payments = Payment::whereBetween('created_at', [$startDate, $endDate])->where('type', $exam_type);

        $totalSuccess   = $payments->where('status', 'SUCCESS')->count();
        $totalPay60     = $payments->where('amount','=', 60.0)->where('type', $exam_type)->sum('amount');
        $totalPay20     = $payments->where('amount','=', 20.0)->where('type', $exam_type)->sum('amount');
        $totalCollect   = $totalPay60 + $totalPay20;

        $count = [
            'totalSuccess' => $totalSuccess,
            'totalPay60' => $totalPay60,
            'totalPay20' => $totalPay20,
            'totalCollect' => $totalCollect,
        ];

        return view('modules.admin.report.financial.' . $type . '.index',
        // return view('modules.admin.report.financial.muet.index',
            compact([
                'user',
                'count',
            ]));

        // return view('modules.admin.pos.' . $type . '.index', compact('user'));


    }

    public function getAjax(Request $request)
    {

        $payments = Payment::where('type', strtoupper($request->exam_type));

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
            $payments->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Apply filtering based on name search if provided
        if ($request->has('textSearch') && !empty($request->textSearch)) {
            $textSearch = $request->textSearchTrx;
            $payments->where(function ($query) use ($textSearch) {
                $query->where('txn_id', 'LIKE', '%' . $textSearch . '%')
                    // Add more columns to search in if necessary
                    ->orWhere('ref_no', 'LIKE', '%' . $textSearch . '%');
            });
        }

        // Retrieve the filtered results
        $payments = $payments->get();

        $data = [];
        foreach ($payments as $key => $payment) {
            $data[] = [
                'txn_id' => $payment->txn_id,
                'receipt_no' => $payment->receipt_number,
                'trx_date' => $payment->payment_date,
                'candidate_name' => $payment->order->candidate->name,
                'amount' => $payment->amount,
                'status' => $payment->status,
                'receipt' => $payment->receipt,
            ];
        }

        return datatables($data)->toJson();
    }

    public function ajaxDashboard(){
        //akan return 4 count
        // all in date range
        //total success trx
        //total amount rm60
        //total amount rm20
        //total amount rm60 rm 20
    }
}
