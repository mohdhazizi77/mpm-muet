<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Agent\Agent;

class AuditLog extends Model
{
    use HasFactory;

    protected $table = 'audit_logs';

    protected $fillable = [
        'user_id',
        'activity',
        'summary',
        'device',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function getDeviceDetail()
    {
        $agent = new Agent;
        $arr = array(
            'manufacturer'  => $agent->device(),
            'platform'      => $agent->platform(),
            'model'         => $agent->browser(). ' ' . $agent->version($agent->browser()),
            'version'       => $agent->version($agent->platform()),
            'ip_address'    => $_SERVER['REMOTE_ADDR']
        );
        $data_device_encode = json_encode($arr);
        return $data_device_encode;
    }
}
