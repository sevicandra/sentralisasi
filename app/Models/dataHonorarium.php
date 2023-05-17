<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class dataHonorarium extends Model
{
    use Uuids;
    use HasFactory;

    protected $table='data_honorariums';

    protected $fillable=[
        'bulan',
        'nmbulan',
        'tahun',
        'kdsatker',
        'nama',
        'nip',
        'bruto',
        'pph',
        'uraian',
        'tanggal',
        'file',
        'sts'
    ];

    public function scopeSatker(){
        return $this    ->join('satkers', 'data_honorariums.kdsatker', '=','satkers.kdsatker')
                        ->orderBy('satkers.order')
        ;
    }

    public function scopeTahun($data ,$kdsatkr=null)
    {
        if ($kdsatkr) {
            return $data->where('kdsatker', $kdsatkr)->orderBy('tahun', 'desc')->select('tahun')->distinct()->get();
        }else{
            return $data->select('tahun')->orderBy('tahun', 'desc')->distinct()->get();
        }
    }

    public function scopeBulan($data, $tahun)
    {
        return $data->where('tahun', $tahun)->select('bulan')->orderBy('bulan')->distinct()->get();
    }

    public function scopeHonor($data, $kdsatker, $thn)
    {
        return $data    ->where('kdsatker', $kdsatker)
                        ->where('tahun', $thn)
                        ->orderBy('bulan')
                        ->groupBy('nmbulan', 'file')
                        ->selectRaw('nmbulan, file,COUNT(nip) as jmh, SUM(bruto) as bruto, SUM(pph) as pph, MIN(sts) as minSts, MAX(sts) as maxSts');
    }

    public function scopeHonorDetail($data, $kdsatker, $file =null)
    {
        if ($file=== null) {
            return $data->where('kdsatker', $kdsatker);
        }else{
            return $data->where('kdsatker', $kdsatker)->where('file', $file);
        }
    }

    public function scopePending($data)
    {
        return $data    ->where('sts', '1')
                        ->orderBy('tahun', 'DESC')
                        ->orderBy('bulan')
                        ->groupBy('tahun', 'bulan', 'nmbulan', 'nmsatker','file')
                        ->selectRaw('tahun, bulan, nmbulan, nmsatker, file, COUNT(nip) as jmh, SUM(bruto) as bruto, SUM(pph) as pph')->get();
    }

    public function scopeDataPendingDetail($data, $file)
    {
        return $data->where('sts', '1')->where('file', $file);
    }

    public function scopeUpload($data, $thn, $bln)
    {
        return $data    ->where('sts', '2')
                        ->where('tahun', $thn)
                        ->where('bulan', $bln)
                        ->groupBy('nmsatker','file')
                        ->selectRaw('nmsatker, file, COUNT(nip) as jmh, SUM(bruto) as bruto, SUM(pph) as pph');
    }

    public function scopeUploadDetail($data, $file)
    {
        return $data->where('sts', '2')->where('file', $file);
    }

    public function scopeTahunUpload($data)
    {
        return $data->where('sts', '2')->select('tahun')->orderBy('tahun', 'desc')->distinct()->get();
    }

    public function scopeBulanUpload($data, $tahun)
    {
        return $data->where('tahun', $tahun)->where('sts', '2')->select('bulan')->orderBy('bulan')->distinct()->get();
    }

    public function scopeSend($data)
    {
        if (Auth::guard('web')->check()) {
            if (Gate::any(['sys_admin'], auth()->user()->id)) {
                return  $data   ->where('sts', '1')
                                ->count();
            }
            return 0;
        }
        return 0;
    }

    public function scopeDraft($data)
    {
        if (Auth::guard('web')->check()) {
            if (Gate::any(['plt_admin_satker', 'opr_honor'], auth()->user()->id)) {
                return  $data   ->where('kdsatker', auth()->user()->kdsatker)
                                ->where('sts', '0')
                                ->count();
            }
            return 0;
        }else{
            if (Gate::any(['admin_satker'], auth()->user()->id)) {
                return  $data   ->where('kdsatker', auth()->user()->kdsatker)
                                ->where('sts', '0')
                                ->count();
            }
            return 0;
        }
    }
    
}
