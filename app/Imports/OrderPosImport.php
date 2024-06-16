<?php

namespace App\Imports;

use App\Models\Order;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class OrderPosImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $validationMessages = [];

        foreach ($rows as $row) {
            if (empty($row['Parcel Notes'])) {
                $validationMessages[] = 'Invalid data on Parcel Notes: ' . $row->getRowIndex() . '. Missing required fields.';
                continue;
            }

            $existingOrder = Order::where('unique_order_id', $row['Parcel Notes'])->first();

            if (!$existingOrder) {
                $validationMessages[] = 'Order with Parcel Notes ' . $row['Parcel Notes'] . ' does not exist in the database.';
            }
        }
        if (!empty($validationMessages)) {
            return collect(['validation_messages' => $validationMessages]);
        }

        return collect([]);
    }
}
