<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function satker()
    {
        return $this->belongsTo(Satker::class, 'kdsatker', 'kdsatker');
    }

    public function permohonanUangMakanPusat()
    {
        return $this    ->hasMany(PermohonanBelanja51::class, 'kdunit', 'kdunit')
                        ->where('jenis', 'makan')
                        ->where('kdsatker', '411792')
                        ;
    }

    public function permohonanUangLemburPusat()
    {
        return $this    ->hasMany(PermohonanBelanja51::class, 'kdunit', 'kdunit')
                        ->where('jenis', 'lembur')
                        ->where('kdsatker', '411792')
                        ;
    }
}
