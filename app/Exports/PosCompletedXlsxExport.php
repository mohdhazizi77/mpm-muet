<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PosCompletedXlsxExport implements FromView
{
    /**
     * @return View
     */
    public function view(): View
    {
        return view('admin.pos.completed.completed-xlsx');
    }
}
