<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigMpmBayar extends Model
{
    use HasFactory;

    protected $table = 'config_mpmbayars';

    protected $fillable = [
        'url', 'token', 'secret_key'
    ];
}
