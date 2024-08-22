<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class satker extends Model
{
    use Uuids;
    use HasFactory;
    protected $fillable = [
        'kdsatker',
        'nmsatker',
        'kdkoordinator',
        'order',
    ];

    public function scopeSearch()
    {
        if (request('search')) {
            return $this->where('kdsatker', 'LIKE', '%' . request('search') . '%')->orWhere('nmsatker', 'LIKE', '%' . request('search') . '%');
        }
    }

    public function unit()
    {
        return $this->hasMany(Unit::class, 'kdsatker', 'kdsatker');
    }

    public function permohonanUangMakanVertikal()
    {
        return $this    ->hasMany(PermohonanBelanja51::class, 'kdsatker', 'kdsatker')
                        ->where('jenis', 'makan')
                        ->where('kdsatker', '!=', '411792')
                        ;
    }

    public function permohonanUangLemburVertikal()
    {
        return $this    ->hasMany(PermohonanBelanja51::class, 'kdsatker', 'kdsatker')
                        ->where('jenis', 'lembur')
                        ->where('kdsatker', '!=', '411792')
                        ;
    }

    public function scopeOrder($data)
    {
        return $data->orderby('order');
    }

    public function satker()
    {
        return $this->hasMany(User::class, 'kdsatker', 'kdsatker');
    }

    public function dokumenUangMakan($thn, $bln)
    {
        return $this->hasMany(dokumenUangMakan::class, 'kdsatker', 'kdsatker')->where('tahun', $thn)->where('bulan', $bln)->get();
    }

    public function dokumenUangLembur($thn, $bln)
    {
        return $this->hasMany(dokumenUangLembur::class, 'kdsatker', 'kdsatker')->where('tahun', $thn)->where('bulan', $bln)->get();
    }

    public function user()
    {
        return $this->hasMany(User::class, 'kdsatker', 'kdsatker');
    }

    public function scopeVertikal($data, $kdsatker)
    {
        return $this->where('kdkoordinator', $kdsatker);
    }

    public function scopeKoordinator($data, $kdsatker, $kdkoordinator)
    {;
        if ($this->where('kdsatker', $kdsatker)->first()->kdkoordinator === $kdkoordinator) {
            return true;
        } else {
            return false;
        }
    }
}
