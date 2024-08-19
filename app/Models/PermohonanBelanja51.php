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
            foreach ($data->lampiran as $lampiran) {
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

    public function lampiran()
    {
        return $this->hasMany(FilePermohonanBelanja51::class, 'permohonan_id', 'id');
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

    public function scopeTTE($data, $nip)
    {
        return $data->where('nip', $nip)->where('status', 'proses');
    }

    public function scopeArsipTTE($data, $nip)
    {
        return $data->where('nip', $nip)->where('status', ['kirim', 'approve', 'reject']);
    }
}
