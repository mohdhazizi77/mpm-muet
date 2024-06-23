<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Reedware\LaravelCompositeRelations\HasCompositeRelations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MuetTarikh extends Model
{
    use HasFactory;
    protected $table = 'muet_tarikh';
    protected $fillable = [
        'tahun',
        'sidang',
        'tarikh_isu',
        'tarikh_exp',
        'sesi'
    ];
}
