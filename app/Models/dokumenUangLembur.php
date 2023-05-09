<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dokumenUangLembur extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = [
        'kdsatker',
        'bulan',
        'tahun',
        'keterangan',
        'file',
        'nmbulan',
        'jmlpegawai',
        'terkirim'
    ];

    public function scopeUangLembur($data, $kdsatkr, $thn, $bln=null)
    {
        if ($bln) {
            return $data->where('kdsatker', $kdsatkr)->where('tahun', $thn)->where('bulan', $bln);
        }
        return $data->where('kdsatker', $kdsatkr)->where('tahun', $thn);
    }

    // public function scopeUangLemburBulan($data, $kdsatkr, $thn, $bln)
    // {
    //     return $data->where('kdsatker', $kdsatkr)->where('tahun', $thn)->where('bulan', $bln);
    // }

    public function scopeTahun($data ,$kdsatkr=null)
    {
        if ($kdsatkr) {
            $datas=$data->where('kdsatker', $kdsatkr)->select('tahun')->groupBy('tahun')->orderBy('tahun', 'desc')->get();
        }else{
            $datas=$data->select('tahun')->groupBy('tahun')->orderBy('tahun', 'desc')->get();
        }
        $tahun =[];
        foreach ($datas as $value) {
            $tahun[]= $value->tahun;
        }
        return $tahun;
    }

    public function scopeBulan($data , $thn, $kdsatkr=null)
    {
        if ($kdsatkr) {
            $datas=$data->where('kdsatker', $kdsatkr)->where('tahun', $thn)->select('bulan')->groupBy('bulan')->orderBy('bulan')->get();
        }else{
            $datas=$data->where('tahun', $thn)->select('bulan')->groupBy('bulan')->orderBy('bulan')->get();
        }
        $bulan =[];
        foreach ($datas as $value) {
            $bulan[]= $value->bulan;
        }
        return $bulan;
    }

    public function scopeSend($data)
    {
        return $data->where('terkirim', 1)->count();
    }

    public function scopeDraft($data)
    {
        return  $data   ->where('kdsatker', auth()->user()->kdsatker)
                        ->where('terkirim', 0)->count();
    }
}
