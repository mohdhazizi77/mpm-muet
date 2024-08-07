<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModPusat extends Model
{
    use HasFactory;
    protected $table = 'mod_pusat';

    protected $fillable = [
        'tahun',
        'sidang',
        'kodnegeri',
        'kodpusat',
        'namapusat'
    ];
}
