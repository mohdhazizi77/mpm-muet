<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModSkor extends Model
{
    use HasFactory;
    protected $table = 'mod_skor';

    protected $fillable = [
        'tahun',
        'sidang',
        'kodnegeri',
        'kodpusat',
        'reg_id',
        'nocalon',
        'nocalon',
        'kodkts',
        'skorbaru',
    ];


    public function getNamaKertas()
    {
        return $this->hasOne('App\Models\Kodkts', 'kodkts');
    }

    public function getKodKertasName($id = '')
    {
        $arr = [
            '1' => 'listening',
            '2' => 'speaking',
            '3' => 'reading',
            '4' => 'writing'
        ];

        return empty($id) ? $arr : $arr[$id];
    }
}
