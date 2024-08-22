<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PermohonanBelanja51 extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($data) {
            $data->dataMakan()->delete();
            $data->dataLembur()->delete();
            foreach ($data->dokumen as $lampiran) {
                Storage::delete($lampiran->file);
                $lampiran->delete();
            }
            $data->history()->delete();
            if ($data->file) {
                Storage::delete($data->file);
            }
        });
    }

    public function satker()
    {
        return $this->belongsTo(Satker::class, 'kdsatker', 'kdsatker');
    }

    public function dataMakan()
    {
        return $this->hasMany(DataPermohonanUangMakan::class, 'permohonan_id', 'id');
    }

    public function dataLembur()
    {
        return $this->hasMany(DataPermohonanUangLembur::class, 'permohonan_id', 'id');
    }

    public function dokumen()
    {
        return $this->hasMany(FilePermohonanBelanja51::class, 'permohonan_id', 'id')->where('type', '!=', null);
    }
    public function lampiran()
    {
        return $this->hasMany(FilePermohonanBelanja51::class, 'permohonan_id', 'id')->where('type', null);
    }

    public function spkl()
    {
        return $this->hasOne(FilePermohonanBelanja51::class, 'permohonan_id', 'id')->where('type', 'spkl');
    }

    public function sptjm()
    {
        return $this->hasOne(FilePermohonanBelanja51::class, 'permohonan_id', 'id')->where('type', 'sptjm');
    }

    public function lpt()
    {
        return $this->hasOne(FilePermohonanBelanja51::class, 'permohonan_id', 'id')->where('type', 'lpt');
    }

    public function history()
    {
        return $this->hasMany(HistoryPermohonanBelanja51::class, 'permohonan_id', 'id');
    }

    public function scopeDraftMakan($data, $kdsatker)
    {
        return $data->where('kdsatker', $kdsatker)->where('status', 'draft')->where('jenis', 'makan');
    }

    public function scopeArsipMakan($data, $kdsatker)
    {
        return $data->where('kdsatker', $kdsatker)->where('status', '!=', 'draft')->where('jenis', 'makan');
    }

    public function scopeDraftLembur($data, $kdsatker)
    {
        return $data->where('kdsatker', $kdsatker)->where('status', 'draft')->where('jenis', 'lembur');
    }

    public function scopeArsipLembur($data, $kdsatker)
    {
        return $data->where('kdsatker', $kdsatker)->where('status', '!=', 'draft')->where('jenis', 'lembur');
    }

    public function scopeTTE($data, $nip)
    {
        return $data->where('nip', $nip)->where('status', 'proses');
    }

    public function scopeArsipTTE($data, $nip)
    {
        return $data->where('nip', $nip)->where('status', ['kirim', 'approved', 'rejected']);
    }

    public function scopeDraftMakanPusat($data, $kdsatker, $kdunit)
    {
        return $data->where('kdsatker', $kdsatker)->where('kdunit', $kdunit)->where('status', 'draft')->where('jenis', 'makan');
    }

    public function scopeArsipMakanPusat($data, $kdsatker, $kdunit)
    {
        return $data->where('kdsatker', $kdsatker)->where('kdunit', $kdunit)->where('status', '!=', 'draft')->where('jenis', 'makan');
    }

    public function scopeDraftLemburPusat($data, $kdsatker, $kdunit)
    {
        return $data->where('kdsatker', $kdsatker)->where('kdunit', $kdunit)->where('status', 'draft')->where('jenis', 'lembur');
    }

    public function scopeArsipLemburPusat($data, $kdsatker, $kdunit)
    {
        return $data->where('kdsatker', $kdsatker)->where('kdunit', $kdunit)->where('status', '!=', 'draft')->where('jenis', 'lembur');
    }

    public function scopePermohonanMakan($data)
    {
        return $data->where('kdsatker', '!=', 411792)->where('status', 'kirim')->where('jenis', 'makan');
    }

    public function scopeTahunMakanVertikal()
    {
        $datas = $this->where('jenis', 'makan')->where('kdsatker', '!=', 411792)->selectRaw('tahun')->groupBy('tahun')->get();
        $tahun = [];
        foreach ($datas as $value) {
            $tahun[] = $value->tahun;
        }
        return $tahun;
    }

    public function scopeBulanMakanVertikal($data, $tahun)
    {
        $datas = $this->where('jenis', 'makan')->where('kdsatker', '!=', 411792)->where('tahun', $tahun)->selectRaw('bulan')->groupBy('bulan')->get();
        $bulan = [];
        foreach ($datas as $value) {
            $bulan[] = $value->bulan;
        }
        return $bulan;
    }

    public function scopePermohonanLembur($data)
    {
        return $data->where('kdsatker', '!=', 411792)->where('status', 'kirim')->where('jenis', 'lembur');
    }

    public function scopeTahunLemburVertikal()
    {
        $datas = $this->where('jenis', 'lembur')->where('kdsatker', '!=', 411792)->selectRaw('tahun')->groupBy('tahun')->get();
        $tahun = [];
        foreach ($datas as $value) {
            $tahun[] = $value->tahun;
        }
        return $tahun;
    }

    public function scopeBulanLemburVertikal($data, $tahun)
    {
        $datas = $this->where('jenis', 'lembur')->where('kdsatker', '!=', 411792)->where('tahun', $tahun)->selectRaw('bulan')->groupBy('bulan')->get();
        $bulan = [];
        foreach ($datas as $value) {
            $bulan[] = $value->bulan;
        }
        return $bulan;
    }
}
