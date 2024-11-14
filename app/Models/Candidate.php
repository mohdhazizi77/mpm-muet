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
    use HasRoles, HasFactory;

    protected $fillable = ['name', 'identity_card_number', 'password'];

    // Ensure the timestamps are enabled
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function certificate()
    {
        return $this->hasOne(Certificate::class, 'candidate_id');
    }

    public function muetCalon()
    {
        return $this->hasMany(MuetCalon::class, 'kp', 'identity_card_number');
    }

    public function modCalon()
    {
        return $this->hasMany(ModCalon::class, 'kp', 'identity_card_number');
    }

    public function getIndexNumber($candidateID): array
    {
        $candidate = Candidate::with(['muetCalon', 'modCalon'])->find($candidateID);

        if (!$candidate) {
            return [];
        }

        $indexNumbers = [];

        foreach ($candidate->muetCalon as $value) {
            $indexNumbers[] = $value->kodnegeri . $value->kodpusat . "/" . $value->jcalon . $value->nocalon;
        }

        foreach ($candidate->modCalon as $value) {
            $indexNumbers[] = $value->kodnegeri . $value->kodpusat . "/" . $value->reg_id;
        }

        return $indexNumbers;
    }

    // Optional: If you need to hash passwords
    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = bcrypt($value);
    // }
}
