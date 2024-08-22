<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AbsensiUangMakan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeTahun($data, $kdsatker)
    {
        $datas = $this->where('kdsatker', $kdsatker)->selectRaw('year(tanggal) as tahun')->groupBy('tahun')->get();
        $tahun = [];
        foreach ($datas as $value) {
            $tahun[] = $value->tahun;
        }
        return $tahun;
    }

    public function scopeBulan($data, $kdsatker, $tahun)
    {
        $datas = $this->where('kdsatker', $kdsatker)->whereYear('tanggal', $tahun)->selectRaw('month(tanggal) as bulan')->groupBy('bulan')->get();
        $bulan = [];
        foreach ($datas as $value) {
            $bulan[] = $value->bulan;
        }
        return $bulan;
    }

    public function scopeRekap($data, $kdsatker, $thn, $bln)
    {
        if (request('search')) {
            $data->where('nip', 'LIKE', '%' . request('search') . '%')->orWhere('nama', 'LIKE', '%' . request('search') . '%');
        }
        if (request('min') && request('max')) {
            $data->whereBetween('tanggal', [request('min'), request('max')]);
        }
        return $data->where('kdsatker', $kdsatker)->whereYear('tanggal', $thn)->whereMonth('tanggal', $bln)->groupBy(['nip', 'nama'])->selectRaw('nip, nama, count(nip) as jml, group_concat(golongan)');
    }

    public function scopeRekapTanggal($data, $kdsatker, $thn, $bln)
    {
        return $data->select('nama', 'nip', 'tanggal', 'absensimasuk', 'absensikeluar')
            ->where('kdsatker', $kdsatker)
            ->whereYear('tanggal', $thn)
            ->whereMonth('tanggal', $bln)
            ->orderBy('nip')
            ->orderBy('tanggal')
            ->get()
            ->groupBy('nip')
            ->map(function ($items) {
                $responseData = new \stdClass();
                $responseData->nama = $items->first()->nama;
                $responseData->nip = $items->first()->nip;
                $responseData->data = $items->map(function ($item) {
                    return (object) [
                        'tanggal' => $item->tanggal,
                        'absensimasuk' => $item->absensimasuk,
                        'absensikeluar' => $item->absensikeluar,
                    ];
                });
                return $responseData;
            });
    }

    public function scopeRekapBulanan($data, $kdsatker, $thn)
    {
        $data->where('kdsatker', $kdsatker)
            ->whereYear('tanggal', $thn)
            ->groupByRaw('month(tanggal)')
            ->selectRaw('month(tanggal) as bulan, count(DISTINCT nip) as jml')
        ;
        return DB::table('bulans')->joinSub($data, 'data', 'data.bulan', '=', 'bulans.bulan')->orderBy('data.bulan')->select(['data.bulan', 'data.jml', 'bulans.nmbulan']);
    }

    public function scopeDetail($data, $kdsatker, $thn, $bln, $nip)
    {
        return $data->where('kdsatker', $kdsatker)->whereYear('tanggal', $thn)->whereMonth('tanggal', $bln)->where('nip', $nip)->orderBy('tanggal', 'asc')->get();
    }

    public function scopeTahunPusat($data, $kdsatker, $kdunit)
    {
        $datas = $this->where('kdsatker', $kdsatker)->where('kdunit', $kdunit)->selectRaw('year(tanggal) as tahun')->groupBy('tahun')->get();
        $tahun = [];
        foreach ($datas as $value) {
            $tahun[] = $value->tahun;
        }
        return $tahun;
    }

    public function scopeBulanPusat($data, $kdsatker, $kdunit, $tahun)
    {
        $datas = $this->where('kdsatker', $kdsatker)->where('kdunit', $kdunit)->whereYear('tanggal', $tahun)->selectRaw('month(tanggal) as bulan')->groupBy('bulan')->get();
        $bulan = [];
        foreach ($datas as $value) {
            $bulan[] = $value->bulan;
        }
        return $bulan;
    }

    public function scopeRekapPusat($data, $kdsatker, $kdunit, $thn, $bln)
    {
        if (request('search')) {
            $data->where('nip', 'LIKE', '%' . request('search') . '%')->orWhere('nama', 'LIKE', '%' . request('search') . '%');
        }
        if (request('min') && request('max')) {
            $data->whereBetween('tanggal', [request('min'), request('max')]);
        }
        return $data->where('kdsatker', $kdsatker)->where('kdunit', $kdunit)->whereYear('tanggal', $thn)->whereMonth('tanggal', $bln)->groupBy(['nip', 'nama'])->selectRaw('nip, nama, count(nip) as jml, group_concat(golongan)');
    }

    public function scopeRekapTanggalPusat($data, $kdsatker, $kdunit, $thn, $bln)
    {
        return $data->select('nama', 'nip', 'tanggal', 'absensimasuk', 'absensikeluar')
            ->where('kdsatker', $kdsatker)
            ->where('kdunit', $kdunit)
            ->whereYear('tanggal', $thn)
            ->whereMonth('tanggal', $bln)
            ->orderBy('nip')
            ->orderBy('tanggal')
            ->get()
            ->groupBy('nip')
            ->map(function ($items) {
                $responseData = new \stdClass();
                $responseData->nama = $items->first()->nama;
                $responseData->nip = $items->first()->nip;
                $responseData->data = $items->map(function ($item) {
                    return (object) [
                        'tanggal' => $item->tanggal,
                        'absensimasuk' => $item->absensimasuk,
                        'absensikeluar' => $item->absensikeluar,
                    ];
                });
                return $responseData;
            });
    }

    public function scopeRekapBulananPusat($data, $kdsatker, $kdunit, $thn)
    {
        $data->where('kdsatker', $kdsatker)
            ->where('kdunit', $kdunit)
            ->whereYear('tanggal', $thn)
            ->groupByRaw('month(tanggal)')
            ->selectRaw('month(tanggal) as bulan, count(DISTINCT nip) as jml')
        ;
        return DB::table('bulans')->joinSub($data, 'data', 'data.bulan', '=', 'bulans.bulan')->orderBy('data.bulan')->select(['data.bulan', 'data.jml', 'bulans.nmbulan']);
    }

    public function scopeDetailPusat($data, $kdsatker, $kdunit, $thn, $bln, $nip)
    {
        return $data->where('kdsatker', $kdsatker)->where('kdunit', $kdunit)->whereYear('tanggal', $thn)->whereMonth('tanggal', $bln)->where('nip', $nip)->orderBy('tanggal', 'asc')->get();
    }
}
