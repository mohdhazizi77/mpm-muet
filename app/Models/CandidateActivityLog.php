<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateActivityLog extends Model
{
    use HasFactory;

    protected $fillable = ['candidate_id', 'activity_type'];

}
