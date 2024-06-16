<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class FinancialStatementExport implements FromView, ShouldAutoSize
{
    private $payments;

    public function __construct($payments)
    {
        $this->payments = $payments;
    }

    public function view(): view
    {
        return view('modules.admin.report.financial.statement.excel.statement', [
            'payments' => $this->payments,
        ]);
    }
}
