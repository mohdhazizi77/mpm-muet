<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OrdersExport implements FromView, ShouldAutoSize
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
        if($this->type == 'NEW'){
            return view('modules.admin.pos.' . $this->type . '.new-xlsx', [
                'orders' => $this->orders,
            ]);
        }else{
            return view('modules.admin.pos.' . $this->type . '.pos-xlsx', [
                'orders' => $this->orders,
            ]);
        }
    }
}
