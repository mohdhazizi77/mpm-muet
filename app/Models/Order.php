<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_order_id',
        'user_id',
        'name',
        'email',
        'phone_num',
        'shipping_address',
        'payment_for',
        'payment_status',
        'courier_id',
        'certificate_id',
    ];

    public function certificate()
    {
        return $this->belongsTo('App\Models\Certificate', 'certificate_id');
    }
}
