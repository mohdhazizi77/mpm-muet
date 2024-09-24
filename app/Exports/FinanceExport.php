<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class FinanceExport implements FromView, ShouldAutoSize
{
    private $payment;

    public function __construct($payment)
    {
        $this->payment = $payment;
    }

    public function view(): view
    {
        // return view('modules.admin.report.transaction.export.transaction', [
        return view('modules.admin.report.financial.export.finance', [
            'payments' => $this->payment,
        ]);
    }
}
