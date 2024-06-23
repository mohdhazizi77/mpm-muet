<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MuetPusat extends Model
{
    use HasFactory;
    protected $table = 'muet_pusat';

    protected $fillable = [
        'tahun',
        'sidang',
        'kodnegeri',
        'kodpusat',
        'namapusat'
    ];
}
