<?php

namespace App\Http\Controllers;

use App\Exports\FinancialStatementExport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class FinanceStatementController extends Controller
{
    public function index()
    {
        $user = Auth::User() ? Auth::User() : abort(403);

        return view('modules.admin.report.financial.statement.index',
            compact([
                'user',
            ]));

    }

    public function downloadExcel(Request $request){
        $year = $request->input('year');
        $month = $request->input('month');

        $payments = Payment::whereYear('payment_date', $year)
                    ->whereMonth('payment_date', $month)
                    ->get();

        $pdf = Pdf::loadView('modules.admin.report.financial.statement.pdf.statement', ['payments' => $payments]);

        return $pdf->stream('List_financial_statment_' . now() . '.pdf');
        // return Excel::download(new FinancialStatementExport($payments), 'list_alumni.xlsx');
    }
}
