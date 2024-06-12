<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        "order_id",
        "payment_date",
        "method",
        "amount",
        "status",
        "txn_id",
        "ref_no",
        "cust_info",
        "receipt",
        "receipt_number",
        "error_message",
        "payment_for",
        "type",
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
}
