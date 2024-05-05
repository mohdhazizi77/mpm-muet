<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    // use HasFactory;
    protected $fillable = ['user_id', 'index_number', 'cid', 'exam_session_id', 'result', 'issue_date', 'expire_date', 'muet_center_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function examsession()
    {
        return $this->belongsTo('App\Models\ExamSession', 'exam_session_id');
    }

    // public function order(){
    //     return $this->belongsTo('App\Models\Order', 'exam_session_id');
    // }

    public function getOrder()
    {
        return $this->hasMany('App\Models\Order', 'certificate_id');
    }

}
