<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;

use App\Models\MuetTarikh;

class MuetCalon extends Model
{
    use HasFactory;
    protected $table = 'muet_calon';
    protected $fillable = [
        'tahun',
        'sidang',
        'nama',
        'kp',
        'kodnegeri',
        'kodpusat',
        'jcalon',
        'nocalon',
        'angka_giliran',
        'alamat1',
        'alamat2',
        'poskod',
        'bandar',
        'negeri',
        'skor_agregat',
        'band',
    ];


    public function getSkor()
    {

        return $this->hasMany('App\Models\MuetSkor', 'kodnegeri', 'kodnegeri')
            ->where('tahun', $this->tahun)
            ->where('sidang', $this->sidang)
            ->where('kodpusat', $this->kodpusat)
            ->where('jcalon', $this->jcalon)
            ->where('nocalon', $this->nocalon);
    }

    public function getPusat()
    {
        return $this->hasMany('App\Models\MuetPusat', 'tahun', 'tahun')
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

    public function getResult($candidate)
    {

        $result = [];
        $result['year'] = $candidate->getTarikh->tahun;
        $result['session'] = $candidate->getTarikh->sesi . " " . $candidate->getTarikh->tahun;
        $result['session'] = $candidate->getTarikh->sesi;
        $result['index_number'] = $candidate->kodnegeri . $candidate->kodpusat . "/" . $candidate->jcalon . $candidate->nocalon;
        foreach ($candidate->getSkor as $key => $value) {
            $result[$value->getKodKertasName($value->kodkts)] = self::checkingMarkah($value->mkhbaru);
        }
        $result['agg_score'] = self::checkingAggSkor($candidate->skor_agregat);
        $result['band'] = self::checkingBand($candidate->band);
        $result['issue_date'] = $candidate->getTarikh->tarikh_isu; //$candidate->getTarikh->tarikh_isu;
        $result['exp_date'] = $candidate->getTarikh->tarikh_exp; //$candidate->getTarikh->tarikh_exp;

        return $result;
    }

    public function index_number($candidate)
    {

        $value = $candidate->kodnegeri . $candidate->kodpusat . "/" . $candidate->jcalon . $candidate->nocalon;
        return $value;
    }

    static function checkingMarkah($id)
    {

        $checkingArr = [
            '-1' => 'ABSENT',
            'X'  => '',
            '-3' => 'EXEMPTED',
            '-4' => 'WITHHELD',
            '-5' => 'NULLIFIED',
        ];

        return array_key_exists($id, $checkingArr) ? $checkingArr[$id] : $id;
    }

    static function checkingAggSkor($id)
    {

        $checkingArr = [
            '-1' => 'NIL',
            'X'  => 'NIL',
            '-3' => '',
            '-4' => 'WITHHELD',
            '-5' => 'NULLIFIED',
        ];

        return array_key_exists($id, $checkingArr) ? $checkingArr[$id] : $id;
    }

    static function checkingBand($id)
    {

        $checkingArr = [
            '-1' => '',
            'X'  => 'NIL',
            '-3' => '',
            '-4' => 'WITHHELD',
            '-5' => 'NULLIFIED',
        ];

        // List of disallowed values
        $disallowed = ["-1", "-2", "-3", "-4", "-5", "X"];

        // Check if the number is in the disallowed list
        if (in_array($id, $disallowed)) {
            // return $number;
            $id = $id;
        }

        // Check if the number contains a '+'
        else if (strpos($id, '+') !== false) {
            // return $number;
            $id = $id;
        }
        // else {
        //     // Convert to float and format to one decimal place
        //     $id = number_format((float)$id, 1);
        // }


        return array_key_exists($id, $checkingArr) ? $checkingArr[$id] : $id;
    }
}
