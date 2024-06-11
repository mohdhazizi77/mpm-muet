<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModCalon extends Model
{
    use HasFactory;
    protected $table = 'mod_calon';

    public function index_number($candidate){

        $value = $candidate->kodnegeri.$candidate->kodpusat."/".$candidate->jcalon.$candidate->nocalon;
        return $value;
    }

}
