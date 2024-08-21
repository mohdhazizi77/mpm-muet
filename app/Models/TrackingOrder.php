<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'detail',
        'status',
        'created_at',
        'updated_at',
    ];

    public static function statusColor($id = '')
    {
        $arr = [
            'PAID' => 'secondary',
            'NEW' => 'info',
            'PROCESSING' => 'warning',
            'CANCEL' => 'danger',
            'COMPLETED' => 'success',
        ];

        return empty($id) ? $arr : $arr[$id];
    }
}
