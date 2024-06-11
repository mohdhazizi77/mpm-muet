<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'identity_card_number',
        'phone_num',
        'address',
        'avatar',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function clearNRIC($nric = ''){

        if (strpos($nric, '-') !== false) {
            // If it does, remove the hyphen
            $nric = str_replace('-', '', $nric);
        }

        return $nric;
    }

    public function certificate()
    {
        return $this->hasMany('App\Models\Certificate','user_id');
    }

    public static function getStates($id = '')
    {
        $states = [
            1 => "JOHOR",
            2 => "KEDAH",
            3 => "KELANTAN",
            4 => "MELAKA",
            5 => "NEGERI SEMBILAN",
            6 => "PAHANG",
            7 => "PERAK",
            8 => "PERLIS",
            9 => "PULAU PINANG",
            10 => "SABAH",
            11 => "SARAWAK",
            12 => "SELANGOR",
            13 => "TERENGGANU",
            14 => "WILAYAH PERSEKUTUAN KUALA LUMPUR",
            15 => "WILAYAH PERSEKUTUAN LABUAN",
            16 => "WILAYAH PERSEKUTUAN PUTRAJAYA"
        ];

        return empty($id) ? $states : $states[$id];
    }

    public static function getKeyStates($state = '')
    {
        $states = [
            1 => "JOHOR",
            2 => "KEDAH",
            3 => "KELANTAN",
            4 => "MELAKA",
            5 => "NEGERI SEMBILAN",
            6 => "PAHANG",
            7 => "PERAK",
            8 => "PERLIS",
            9 => "PULAU PINANG",
            10 => "SABAH",
            11 => "SARAWAK",
            12 => "SELANGOR",
            13 => "TERENGGANU",
            14 => "WILAYAH PERSEKUTUAN KUALA LUMPUR",
            15 => "WILAYAH PERSEKUTUAN LABUAN",
            16 => "WILAYAH PERSEKUTUAN PUTRAJAYA"
        ];

        return !empty($state) ? array_search($state, $states) : '';
    }

}
