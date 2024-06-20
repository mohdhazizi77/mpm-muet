<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        "unique_order_id",
        "candidate_id",
        "name",
        "email",
        "phone_num",
        "shipping_address",
        "payment_for",
        "type",
        "payment_status",
        "current_status",
        "courier_id",
        "muet_calon_id",
        "mod_calon_id",
        "tracking_number",
        "consigment_note",
    ];

    public function certificate()
    {
        return $this->belongsTo('App\Models\Certificate', 'certificate_id');
    }

    public function candidate()
    {
        return $this->belongsTo('App\Models\Candidate', 'candidate_id');

    }

    public function muetCalon()
    {
        return $this->belongsTo('App\Models\MuetCalon', 'muet_calon_id', 'id');
    }


    public function modCalon()
    {
        return $this->belongsTo('App\Models\ModCalon', 'mod_calon_id', 'id');

    }
}
