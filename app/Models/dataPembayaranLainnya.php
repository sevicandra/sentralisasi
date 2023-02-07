<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'sts'
    ];

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
                        ->groupBy('kdsatker', 'jenis')
                        ->selectRaw('kdsatker, jenis, COUNT(nip) as jml, SUM(bruto) as bruto, SUM(pph) as pph');
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
                        ->groupBy('kdsatker', 'jenis')
                        ->selectRaw('kdsatker, jenis, COUNT(nip) as jml, SUM(bruto) as bruto, SUM(pph) as pph');
    }

    public function scopeDetailPaymentUpload($data, $kdsatker, $jenis, $thn, $bln)
    {
        return $data    ->where('sts', '1')
                        ->where('kdsatker', $kdsatker)
                        ->where('jenis', $jenis)
                        ->where('tahun', $thn)
                        ->where('bulan', $bln)
                        ->select('id','nip', 'nama', 'pph', 'bruto');
    }

    public function scopePaymentUpload($data, $kdsatker, $jenis, $thn, $bln)
    {
        return $data    ->where('sts', '1')
                        ->where('kdsatker', $kdsatker)
                        ->where('jenis', $jenis)
                        ->where('tahun', $thn)
                        ->where('bulan', $bln);
    }
}
