<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PosNewExport implements FromView
{
    /**
     * @return View
     */
    public function view(): View
    {
        return view('admin.pos.new.new-xlsx');
    }
}
