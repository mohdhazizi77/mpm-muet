<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\FinanceExport;

use Maatwebsite\Excel\Facades\Excel;
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

        // $payments = Payment::whereBetween('created_at', [$startDate, $endDate])->where('type', $exam_type);
        $payments = Payment::where('type', $exam_type);

        $totalSuccess   = $payments->where('status', 'SUCCESS')->count();
        $totalPay60     = $payments->where('type', $exam_type)->sum('amount');
        $totalPay20     = $payments->where('type', $exam_type)->sum('amount');

        $totalCollect   = $totalPay60 + $totalPay20;

        $count = [
            'totalSuccess' => $totalSuccess,
            'totalPay60' => $totalPay60,
            'totalPay20' => $totalPay20,
            // 'totalCollect' => $totalCollect,
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

        $payments = Payment::latest();
        if ($request->has('exam_type_select') && !empty($request->exam_type_select)) {
            $payments->where('type', $request->exam_type_select);
        }else{
            $payments->where('type', strtoupper($request->exam_type));
        }

        if ($request->has('payment_for') && !empty($request->payment_for)) {
            $payments->where('payment_for', $request->payment_for);
        }

        if ($request->has('status') && !empty($request->status)) {
            $payments->where('status', $request->status);
        }

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

        // // Apply filtering based on name search if provided
        // if ($request->has('textSearch') && !empty($request->textSearch)) {
        //     $textSearch = $request->textSearchTrx;
        //     $payments->where(function ($query) use ($textSearch) {
        //         $query->where('txn_id', 'LIKE', '%' . $textSearch . '%')
        //             // Add more columns to search in if necessary
        //             ->orWhere('ref_no', 'LIKE', '%' . $textSearch . '%');
        //     });
        // }

        // Retrieve the filtered results
        $payments = $payments->get();

        $data = [];
        foreach ($payments as $key => $payment) {
            $data[] = [
                'date_created' => $payment->created_at->format('d/m/y H:i:s'),
                'reference_id' => $payment->order->unique_order_id,
                'ref_no' => $payment->ref_no,
                'txn_id' => $payment->txn_id ?? 'Tiada Rekod',
                'receipt_no' => $payment->receipt_number ?? 'Tiada Rekod',
                'trx_date' => $payment->payment_date ?? 'Tiada Rekod',
                'candidate_name' => $payment->order?->candidate?->name ?? 'Tiada Rekod',
                'amount' => $payment->amount ?? 'Tiada Rekod',
                'status' => $payment->status ?? 'Tiada Rekod',
                'receipt' => $payment->receipt ?? 'Tiada Rekod',
            ];
        }

        // Apply text search after building the array
        if ($request->has('textSearch') && !empty($request->textSearch)) {
            $textSearch = $request->textSearch;
            $data = array_filter($data, function ($item) use ($textSearch) {
                return stripos($item['reference_id'], $textSearch) !== false ||
                    stripos($item['ref_no'], $textSearch) !== false ||
                    stripos($item['candidate_name'], $textSearch) !== false ||
                    stripos($item['txn_id'], $textSearch) !== false;
            });
        }

        return datatables($data)->toJson();
    }

    public function getData(Request $request, $exam_type)
    {
        $type = $exam_type;
        $exam_type = strtoupper($exam_type);

        $totalSuccess   = Payment::when($request->filled('exam_type'), function ($query) use ($request) {
                                return $query->where('type', 'like', "%{$request->input('exam_type')}%");
                            }, function ($query) use ($exam_type){
                                return $query->where('type', $exam_type);
                            })
                            ->when($request->filled('startDate') || $request->filled('endDate'), function ($query) use ($request) {
                                $currentDate = Carbon::now()->format('Y-m-d H:i:s');

                                $startDate = Carbon::parse($request->startDate)->startOfDay()->format('Y-m-d H:i:s');
                                $endDate = $request->has('endDate') && !empty($request->endDate)
                                            ? Carbon::parse($request->endDate)->endOfDay()->format('Y-m-d H:i:s')
                                            : $currentDate;

                                $query->whereBetween('created_at', [$startDate, $endDate]);
                            })
                            ->when($request->filled('payment_for'), function ($query) use ($request) {
                                return $query->where('payment_for', 'like', "%{$request->input('payment_for')}%");
                            })
                            // ->when($request->filled('textSearch'), function ($query) use ($request) {
                            //     $textSearch = $request->textSearch;
                            //     $request->where(function ($query) use ($textSearch) {
                            //         $query->where('txn_id', 'LIKE', '%' . $textSearch . '%')
                            //             ->orWhere('ref_no', 'LIKE', '%' . $textSearch . '%');
                            //     });
                            // })
                            ->when($request->filled('status'), fn($query) => $query->where('status', 'like', "%{$request->input('status')}%"))
                            ->count();

        $totalPayMpm = Payment::when($request->filled('exam_type'), function ($query) use ($request) {
                                return $query->where('type', 'like', "%{$request->input('exam_type')}%");
                            }, function ($query) use ($exam_type){
                                return $query->where('type', $exam_type);
                            })
                            ->when($request->filled('payment_for'), function ($query) use ($request) {
                                $paymentFor = $request->input('payment_for');
                                if ($paymentFor == 'MPM_PRINT') {
                                    return $query->where('payment_for', 'MPM_PRINT');
                                }else{
                                    return $query->where('payment_for', 'SELF_PRINT')->whereRaw('false');
                                }
                            }, function ($query) {
                                return $query->where('payment_for', 'MPM_PRINT');
                            })
                            ->when($request->filled('startDate') || $request->filled('endDate'), function ($query) use ($request) {
                                $currentDate = Carbon::now()->format('Y-m-d H:i:s');

                                $startDate = Carbon::parse($request->startDate)->startOfDay()->format('Y-m-d H:i:s');
                                $endDate = $request->has('endDate') && !empty($request->endDate)
                                            ? Carbon::parse($request->endDate)->endOfDay()->format('Y-m-d H:i:s')
                                            : $currentDate;

                                // Filter based on the date range
                                $query->whereBetween('payment_date', [$startDate, $endDate]);
                            })
                            // ->when($request->filled('textSearch'), function ($query) use ($request) {
                            //     $textSearch = $request->textSearch;
                            //     $request->where(function ($query) use ($textSearch) {
                            //         $query->where('txn_id', 'LIKE', '%' . $textSearch . '%')
                            //             ->orWhere('ref_no', 'LIKE', '%' . $textSearch . '%');
                            //     });
                            // })
                            ->when($request->filled('status'), fn($query) => $query->where('status', 'like', "%{$request->input('status')}%"))
                            ->sum('amount');

        $totalPaySelf = Payment::when($request->filled('exam_type'), function ($query) use ($request) {
                                return $query->where('type', 'like', "%{$request->input('exam_type')}%");
                            }, function ($query) use ($exam_type){
                                return $query->where('type', $exam_type);
                            })
                            ->when($request->filled('payment_for'), function ($query) use ($request) {
                                $paymentFor = $request->input('payment_for');
                                if ($paymentFor == 'SELF_PRINT') {
                                    return $query->where('payment_for', 'SELF_PRINT');
                                }else{
                                    return $query->where('payment_for', 'MPM_PRINT')->whereRaw('false');
                                }
                            }, function ($query) {
                                return $query->where('payment_for', 'SELF_PRINT');
                            })
                            ->when($request->filled('startDate') || $request->filled('endDate'), function ($query) use ($request) {
                                $currentDate = Carbon::now()->format('Y-m-d H:i:s');

                                $startDate = Carbon::parse($request->startDate)->startOfDay()->format('Y-m-d H:i:s');
                                $endDate = $request->has('endDate') && !empty($request->endDate)
                                            ? Carbon::parse($request->endDate)->endOfDay()->format('Y-m-d H:i:s')
                                            : $currentDate;

                                // Filter based on the date range
                                $query->whereBetween('payment_date', [$startDate, $endDate]);
                            })
                            // ->when($request->filled('textSearch'), function ($query) use ($request) {
                            //     $textSearch = $request->textSearch;
                            //     $request->where(function ($query) use ($textSearch) {
                            //         $query->where('txn_id', 'LIKE', '%' . $textSearch . '%')
                            //             ->orWhere('ref_no', 'LIKE', '%' . $textSearch . '%');
                            //     });
                            // })
                            ->when($request->filled('status'), fn($query) => $query->where('status', 'like', "%{$request->input('status')}%"))
                            ->sum('amount');

        $totalColection = $totalPayMpm + $totalPaySelf;


        return [
            'totalSuccess' => $totalSuccess,
            'totalPayMpm' => round($totalPayMpm, 1),
            'totalPaySelf' => round($totalPaySelf, 1),
            'totalColection' => round($totalColection, 1),
        ];
    }

    // public function generatePdf(Request $request){
    //     $payments = Payment::when($request->filled('exam_type_select'), function ($query) use ($request) {
    //                     return $query->where('type', $request->input('exam_type_select'));
    //                 }, function ($query) use ($request){
    //                     return $query->where('type', strtoupper($request->exam_type));
    //                 })
    //                 ->when($request->filled('payment_for'), function ($query) use ($request) {
    //                     return $query->where('payment_for', 'like', "%{$request->input('payment_for')}%");
    //                 })
    //                 ->when($request->filled('startDate') || $request->filled('endDate'), function ($query) use ($request) {
    //                     $currentDate = Carbon::now()->format('Y-m-d H:i:s');

    //                     $startDate = Carbon::parse($request->startDate)->startOfDay()->format('Y-m-d H:i:s');
    //                     $endDate = $request->has('endDate') && !empty($request->endDate)
    //                                 ? Carbon::parse($request->endDate)->endOfDay()->format('Y-m-d H:i:s')
    //                                 : $currentDate;

    //                     // Filter based on the date range
    //                     $query->whereBetween('payment_date', [$startDate, $endDate]);
    //                 })
    //                 ->when($request->filled('textSearch'), function ($query) use ($request) {
    //                     $textSearch = $request->textSearch;
    //                     $request->where(function ($query) use ($textSearch) {
    //                         $query->where('txn_id', 'LIKE', '%' . $textSearch . '%')
    //                             ->orWhere('ref_no', 'LIKE', '%' . $textSearch . '%');
    //                     });
    //                 })
    //                 ->when($request->filled('status'), fn($query) => $query->where('status', 'like', "%{$request->input('status')}%"))
    //                 ->latest()
    //                 // ->limit(300)
    //                 ->get();

    //     // dd($request->toArray(), $payments);


    //     if($request->exam_type == 'mod'){
    //         $pdf = Pdf::loadView('modules.admin.report.financial.mod.pdf', ['payments' => $payments]);

    //     }else{
    //         $pdf = Pdf::loadView('modules.admin.report.financial.muet.pdf', ['payments' => $payments]);
    //     }

    //     return $pdf->stream('List_finance_' . $request->exam_type . '.pdf');
    // }

    public function generatePdf(Request $request)
    {
    try {
        $payments = Payment::query();

        // Exam type filter
        if ($request->filled('exam_type_select')) {
            $payments->where('type', $request->exam_type_select);
        } elseif ($request->exam_type) {
            $payments->where('type', strtoupper($request->exam_type));
        }

        // Payment for filter
        if ($request->filled('payment_for')) {
            $payments->where('payment_for', 'like', "%{$request->payment_for}%");
        }

        // Date range filter
        if ($request->filled('startDate') || $request->filled('endDate')) {
            $startDate = Carbon::parse($request->startDate)->startOfDay();
            $endDate = $request->filled('endDate') ?
                Carbon::parse($request->endDate)->endOfDay() :
                Carbon::now()->endOfDay();

            $payments->whereBetween('payment_date', [$startDate, $endDate]);
        }

        // Text search
        if ($request->filled('textSearch')) {
            $payments->where(function($query) use ($request) {
                $query->where('txn_id', 'like', "%{$request->textSearch}%")
                        ->orWhere('ref_no', 'like', "%{$request->textSearch}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $payments->where('status', 'like', "%{$request->status}%");
        }

        $view = $request->exam_type == 'mod' ?
            'modules.admin.report.financial.mod.pdf' :
            'modules.admin.report.financial.muet.pdf';

        $tempData = [];
        $payments->latest()->chunk(100, function($records) use (&$tempData) {
            foreach ($records as $record) {
                // $tempData[] = $record->toArray();
                $tempData[] = $record->get();
            }
        });

        dd($tempData);
        $pdf = PDF::loadView($view, ['payments' => collect($tempData)])
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'memory_limit' => '512M',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'sans-serif',
                'chroot' => public_path('fonts')
            ]);

        return $pdf->download('List_finance_' . $request->exam_type . '.pdf');

    } catch (\Exception $e) {
        \Log::error('PDF generation error: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to generate PDF: ' . $e->getMessage()], 500);
    }
    }

    public function generateExcel(Request $request){

        // $currentDate = Carbon::now()->format('Y-m-d H:i:s');
        // $transactions = Order::latest();
        // // list by transaction by role
        // switch (Auth::User()->getRoleNames()[0]) {
        //     case 'PSM':
        //         // $transactions->where('type', 'MUET');
        //         $transactions->when($request->filled('exam_type'), function ($query) use ($request) {
        //                 return $query->where('type', $request->input('exam_type'));
        //             }, function ($query) {
        //                 return $query->where('type', 'MUET');
        //             });
        //         break;
        //     case 'BPKOM':
        //         // $transactions->where('type', 'MOD');
        //         $transactions->when($request->filled('exam_type'), function ($query) use ($request) {
        //                 return $query->where('type', $request->input('exam_type'));
        //             }, function ($query) {
        //                 return $query->where('type', 'MOD');
        //             });
        //         break;
        // }

        // if(filled($request->startDate) || filled($request->endDate)){
        //     $startDate = Carbon::parse($request->startDate)->startOfDay()->format('Y-m-d H:i:s');
        //     $endDate = $request->has('endDateTrx') && !empty($request->endDate)
        //                 ? Carbon::parse($request->endDate)->endOfDay()->format('Y-m-d H:i:s')
        //                 : $currentDate;

        //     // Filter based on the date range
        //     $transactions->whereBetween('created_at', [$startDate, $endDate]);
        // }

        // if ($request->has('exam_type') && !empty($request->exam_type)) {
        //     $transactions->where('type', $request->exam_type);
        // }

        // if ($request->has('payment_for') && !empty($request->payment_for)) {
        //     $transactions->where('payment_for', $request->payment_for);
        // }

        // if ($request->has('status_trx') && !empty($request->status_trx)) {
        //     $transactions->where('current_status', $request->status_trx);
        // }

        // if(filled($request->textSearch)){
        //     $textSearch = $request->textSearch;
        //     $transactions->where(function ($query) use ($textSearch) {
        //         $query->where('unique_order_id', 'LIKE', '%' . $textSearch . '%');
        //             // Add more columns to search in if necessary
        //             // ->orWhere('ref_no', 'LIKE', '%' . $textSearch . '%');
        //     });
        // }

        // $transactions = $transactions->get();

        // return Excel::download(new FinanceExport($transactions), 'transaction_' . now() . '.xlsx');




        $payments = Payment::when($request->filled('exam_type_select'), function ($query) use ($request) {
            return $query->where('type', $request->input('exam_type_select'));
        }, function ($query) use ($request){
            return $query->where('type', strtoupper($request->exam_type));
        })
        ->when($request->filled('payment_for'), function ($query) use ($request) {
            return $query->where('payment_for', 'like', "%{$request->input('payment_for')}%");
        })
        ->when($request->filled('startDate') || $request->filled('endDate'), function ($query) use ($request) {
            $currentDate = Carbon::now()->format('Y-m-d H:i:s');

            $startDate = Carbon::parse($request->startDate)->startOfDay()->format('Y-m-d H:i:s');
            $endDate = $request->has('endDate') && !empty($request->endDate)
                        ? Carbon::parse($request->endDate)->endOfDay()->format('Y-m-d H:i:s')
                        : $currentDate;

            // Filter based on the date range
            $query->whereBetween('payment_date', [$startDate, $endDate]);
        })
        ->when($request->filled('textSearch'), function ($query) use ($request) {
            $textSearch = $request->textSearch;
            $request->where(function ($query) use ($textSearch) {
                $query->where('txn_id', 'LIKE', '%' . $textSearch . '%')
                    ->orWhere('ref_no', 'LIKE', '%' . $textSearch . '%');
            });
        })
        ->when($request->filled('status'), fn($query) => $query->where('status', 'like', "%{$request->input('status')}%"))
        ->latest()
        ->get();

        return Excel::download(new FinanceExport($payments), 'finance_' . now() . '.xlsx');

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
