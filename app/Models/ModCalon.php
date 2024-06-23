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

    public function getSkor(){

        return $this->hasMany('App\Models\ModSkor', 'kodnegeri', 'kodnegeri')
                    ->where('kodpusat', $this->kodpusat)
                    ->where('nocalon', $this->nocalon)
                    ->where('reg_id', $this->reg_id);
    }

    public function getPusat(){
        return $this->hasMany('App\Models\ModPusat','tahun', 'tahun')
                    ->where('sidang', $this->sidang)
                    ->where('kodnegeri', $this->kodnegeri)
                    ->where('kodpusat', $this->kodpusat);
    }

    public function getTarikh()
    {
        return $this->hasOne('App\Models\ModTarikh', 'tahun', 'tahun')->where('sidang', $this->sidang)->where('tahun', $this->tahun);
    }

    public function getOrder()
    {
        return $this->hasMany('App\Models\Order', 'mod_calon_id', 'id');
    }

    public function getResult($candidate){

        $result = [];
        $result['year'] = $candidate->getTarikh->tahun;
        $result['session'] = $candidate->getTarikh->sesi . " " . $candidate->getTarikh->tahun;
        $result['index_number'] = $candidate->kodnegeri . $candidate->kodpusat ."/". $candidate->jcalon . $candidate->nocalon;
        foreach ($candidate->getSkor as $key => $value) {
            $result[$value->getKodKertasName($value->kodkts)] = $value->mkhbaru;
        }
        $result['agg_score'] = (float)$candidate->skor_agregat;
        $result['band'] = $candidate->band;
        $result['issue_date'] = $candidate->getTarikh->tarikh_isu; //$candidate->getTarikh->tarikh_isu;
        $result['exp_date'] = $candidate->getTarikh->tarikh_exp; //$candidate->getTarikh->tarikh_exp;
        // dd($result);
        return $result;
    }

}
