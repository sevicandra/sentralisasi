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
        return $data->where('nip', $nip)->where('status', ['kirim', 'approve', 'reject']);
    }
}
