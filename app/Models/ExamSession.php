<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSession extends Model
{
    protected $fillable = ['name','year', 'exam_type', 'is_deleted'];

    // public function certificate()
    // {
    //     return $this->belongsTo('App\Models\certificate');
    // }
}
