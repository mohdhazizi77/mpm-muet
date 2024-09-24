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
        try {
            if (strtolower($this->type) == 'new') {
                return view('modules.admin.pos.new.new-xlsx', [
                    'orders' => $this->orders,
                ]);
            } else {
                return view('modules.admin.pos.' . strtolower($this->type) . '.pos-xlsx', [
                    'orders' => $this->orders,
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('View not found: ' . $e->getMessage());
            abort(404, 'View not found');
        }
    }
}
