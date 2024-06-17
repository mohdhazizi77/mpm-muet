<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TransactionExport implements FromView, ShouldAutoSize
{
    private $transaction;

    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    public function view(): view
    {
        return view('modules.admin.report.transaction.export.transaction', [
            'transactions' => $this->transaction,
        ]);
    }
}
