<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nomor extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function satker()
    {
        return $this->belongsTo(Satker::class, 'kdsatker', 'kdsatker');
    }

    public function scopeSearch($data)
    {
        if (request('search')) {
            return $data->where('kdsatker', 'like', '%' . request('search') . '%');
        }
        return $data;
    }

    public function scopeIndex($data)
    {

        return $data->leftJoin('satkers', 'nomors.kdsatker', '=', 'satkers.kdsatker')
            ->leftJoin('units', 'nomors.kdunit', '=', 'units.kdunit')
            ->orderBy('nomors.tahun', 'desc')
            ->orderBy('satkers.order', 'asc')
            ->orderBy('nomors.kdunit', 'asc')
            ->selectRaw('nomors.*, satkers.nmsatker, units.nama as nmunit')
            ->where('nomors.kdsatker', 'like', '%' . request('search') . '%')
            ->orWhere('satkers.nmsatker', 'like', '%' . request('search') . '%')
            ->orWhere('units.nama', 'like', '%' . request('search') . '%')
        ;
    }
}
