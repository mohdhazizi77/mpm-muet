<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    // use HasFactory;
    protected $fillable = ['user_id','index_number', 'muet_center_id', 'is_deleted'];


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function certificate()
    {
        return $this->hasOne('App\Models\Certificate','candidate_id');
    }
}
