<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModTarikh extends Model
{
    use HasFactory;
    protected $table = 'mod_tarikh';
    protected $fillable = [
        'tahun',
        'sidang',
        'tarikh_isu',
        'tarikh_exp',
        'sesi'
    ];
}
