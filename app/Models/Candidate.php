<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

use App\Models\MuetCalon;
use App\Models\ModCalon;

use Illuminate\Foundation\Auth\User as Authenticatable;


class Candidate extends Authenticatable
{
    use HasRoles;
    // use HasFactory;
    protected $fillable = ['name','identity_card_number','password'];


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function certificate()
    {
        return $this->hasOne('App\Models\Certificate','candidate_id');
    }

    public function muetCalon()
    {
        return $this->hasMany('App\Models\MuetCalon','kp','identity_card_number');
    }

    public function modCalon()
    {
        return $this->hasMany('App\Models\ModCalon','kp','identity_card_number');
    }

    public function getIndexNumber($candidateID){
        $candidate = Candidate::find($candidateID);

        $muet_calon = MuetCalon::where('kp', $candidate->identity_card_number)->get();

        $arr_index_number = [];
        foreach ($muet_calon as $key => $value) {
            $arr_index_number [] = $value->kodnegeri.$value->kodpusat."/".$value->jcalon.$value->nocalon;
        }

        $mod_calon = ModCalon::where('kp', $candidate->identity_card_number)->get();

        foreach ($mod_calon as $key => $value) {
            $arr_index_number [] = $value->kodnegeri.$value->kodpusat."/".$value->jcalon.$value->nocalon;
        }

        return $arr_index_number;

    }
}
