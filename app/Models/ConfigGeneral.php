<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigGeneral extends Model
{
    use HasFactory;

    protected $table = 'config_generals';
    protected $guarded = [];
    protected $filable = [
        'id',
        'rate_mpmprint',
        'rate_selfprint',
        'email_alert_order',
    ];

}
