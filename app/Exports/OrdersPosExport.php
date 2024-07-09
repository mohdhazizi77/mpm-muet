<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OrdersPosExport implements FromView, ShouldAutoSize
{
    protected $orders;
    protected $type;

    public function __construct($orders,$type)
    {
        $this->orders = $orders;
        $this->type = $type;
    }

    public function view(): view
    {
        return view('modules.admin.pos.' . strtolower($this->type) . '.processing-xlsx', [
            'orders' => $this->orders,
        ]);
    }
}
