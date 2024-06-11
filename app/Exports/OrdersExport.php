<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromCollection, WithHeadings
{
    protected $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function collection()
    {
        // return $this->orders;
        return collect($this->orders);
    }

    public function headings(): array
    {
        return [
            'Date',
            'Reference ID',
            'Detail'
        ];
    }
}
