<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class dokumenUangLembur extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = [
        'kdsatker',
        'bulan',
        'tahun',
        'keterangan',
        'file_excel',
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

    public function scopeMonitoringPusatTahun(){
        return $this->selectRaw('tahun, count(CASE WHEN terkirim = 1 THEN 1 ELSE NULL END) as pending')->groupBy('tahun')->orderBy('tahun', 'desc')->get();
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

    public function scopeMonitoringPusatBulan($data, $thn){
        return $this->where('tahun', $thn)->selectRaw('bulan, count(CASE WHEN terkirim = 1 THEN 1 ELSE NULL END) as pending')->groupBy('bulan')->orderBy('bulan')->get();
    }

    public function scopeSend($data)
    {
        if (Auth::guard('web')->check()) {
            if (Gate::any(['sys_admin'], auth()->user()->id)) {
                return $data->where('terkirim', 1)->count();
            }
            return 0;
        }
        return 0;
    }

    public function scopeDraft($data)
    {
        if (Auth::guard('web')->check()) {
            if (Gate::any(['plt_admin_satker', 'opr_belanja_51'], auth()->user()->id)) {
                return  $data   ->where('kdsatker', auth()->user()->kdsatker)
                                ->where('terkirim', 0)
                                ->count();
            }
            return 0;
        }else{
            if (Gate::any(['admin_satker'], auth()->user()->id)) {
                return  $data   ->where('kdsatker', auth()->user()->kdsatker)
                                ->where('terkirim', 0)
                                ->count();
            }
            return 0;
        }
    }
}
