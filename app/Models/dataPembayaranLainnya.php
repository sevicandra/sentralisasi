<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class dataPembayaranLainnya extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable=[
        'bulan',
        'nmbulan',
        'tahun',
        'kdsatker',
        'jenis',
        'nama',
        'nip',
        'bruto',
        'pph',
        'uraian',
        'tanggal',
        'sts',
        'server_id'
    ];

    public function scopeSatker(){
        return $this    ->join('satkers', 'data_pembayaran_lainnyas.kdsatker', '=','satkers.kdsatker')
                        ->orderBy('satkers.order')
        ;
    }

    public function scopeTahunPending($data)
    {
        return $data->where('sts', '0')->select('tahun')->orderBy('tahun', 'desc')->distinct()->get();
    }

    public function scopeBulanPending($data, $tahun)
    {
        return $data->where('sts', '0')->where('tahun', $tahun)->select('bulan')->orderBy('bulan')->distinct()->get();
    }

    public function scopeSatkerPending($data, $tahun, $bulan)
    {
        return $data    ->where('tahun', $tahun)
                        ->where('bulan', $bulan)
                        ->where('sts', '0')
                        ->groupBy('nmsatker', 'jenis')
                        ->selectRaw('nmsatker, data_pembayaran_lainnyas.kdsatker, jenis, COUNT(nip) as jml, SUM(bruto) as bruto, SUM(pph) as pph');
    }

    public function scopeDetailPaymentPending($data, $kdsatker, $jenis, $thn, $bln)
    {
        return $data    ->where('sts', '0')
                        ->where('kdsatker', $kdsatker)
                        ->where('jenis', $jenis)
                        ->where('tahun', $thn)
                        ->where('bulan', $bln)
                        ->select('id','nip', 'nama', 'pph', 'bruto');
    }

    public function scopePaymentPending($data, $kdsatker, $jenis, $thn, $bln)
    {
        return $data    ->where('sts', '0')
                        ->where('kdsatker', $kdsatker)
                        ->where('jenis', $jenis)
                        ->where('tahun', $thn)
                        ->where('bulan', $bln);
    }

    public function scopeTahunUpload($data)
    {
        return $data->where('sts', '1')->select('tahun')->orderBy('tahun', 'desc')->distinct()->get();
    }

    public function scopeBulanUpload($data, $tahun)
    {
        return $data->where('sts', '1')->where('tahun', $tahun)->select('bulan')->orderBy('bulan')->distinct()->get();
    }

    public function scopeSatkerUpload($data, $tahun, $bulan)
    {
        return $data    ->where('tahun', $tahun)
                        ->where('bulan', $bulan)
                        ->where('sts', '1')
                        ->groupBy('nmsatker', 'jenis')
                        ->selectRaw('nmsatker, data_pembayaran_lainnyas.kdsatker, jenis, COUNT(nip) as jml, SUM(bruto) as bruto, SUM(pph) as pph');
    }

    public function scopeDetailPaymentUpload($data, $kdsatker, $jenis, $thn, $bln)
    {
        return $data    ->where('sts', '1')
                        ->where('kdsatker', $kdsatker)
                        ->where('jenis', $jenis)
                        ->where('tahun', $thn)
                        ->where('bulan', $bln)
                        ->select('id','nip', 'nama', 'pph', 'bruto', 'server_id');
    }

    public function scopePaymentUpload($data, $kdsatker, $jenis, $thn, $bln)
    {
        return $data    ->where('sts', '1')
                        ->where('kdsatker', $kdsatker)
                        ->where('jenis', $jenis)
                        ->where('tahun', $thn)
                        ->where('bulan', $bln);
    }

    public function scopeDraft($data)
    {
        if (Auth::guard('web')->check()) {
            if (Gate::any(['sys_admin'], auth()->user()->id)) {
                return  $data   ->where('sts', '0')
                                ->count();
            }
            return 0;
        }
        return 0;
    }
}
