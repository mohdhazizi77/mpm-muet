<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;

class MuetCalon extends Model
{
    use HasFactory;
    protected $table = 'muet_calon';

    public function getSkor(){

        return $this->hasMany('App\Models\MuetSkor', 'kodnegeri', 'kodnegeri')
                    ->where('kodpusat', $this->kodpusat)
                    ->where('jcalon', $this->jcalon)
                    ->where('nocalon', $this->nocalon);
    }

    public function getPusat(){
        return $this->hasMany('App\Models\MuetPusat','tahun', 'tahun')
                    ->where('sidang', $this->sidang)
                    ->where('kodnegeri', $this->kodnegeri)
                    ->where('kodpusat', $this->kodpusat);
    }

    public function getTarikh()
    {
        return $this->hasOne('App\Models\MuetTarikh', 'tahun', 'tahun')->where('sidang', $this->sidang)->where('tahun', $this->tahun);
    }

    public function getOrder()
    {
        return $this->hasMany('App\Models\Order', 'muet_calon_id', 'id');
    }

    public function getResult($candidate){

        $result = [];
        $result['year'] = $candidate->getTarikh->tahun;
        $result['session'] = $candidate->getTarikh->sesi . " " . $candidate->getTarikh->tahun;
        $result['session'] = $candidate->getTarikh->sesi;
        $result['index_number'] = $candidate->kodnegeri . $candidate->kodpusat ."/". $candidate->jcalon . $candidate->nocalon;
        foreach ($candidate->getSkor as $key => $value) {
            $result[$value->getKodKertasName($value->kodkts)] = $value->mkhbaru;
        }
        $result['agg_score'] = (float)$candidate->skor_agregat;
        $result['band'] = $candidate->band;
        $result['issue_date'] = $candidate->getTarikh->tarikh_isu; //$candidate->getTarikh->tarikh_isu;
        $result['exp_date'] = $candidate->getTarikh->tarikh_exp; //$candidate->getTarikh->tarikh_exp;

        return $result;
    }

    public function index_number($candidate){

        $value = $candidate->kodnegeri.$candidate->kodpusat."/".$candidate->jcalon.$candidate->nocalon;
        return $value;
    }
}
