<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kop extends Model
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

        return $data->leftJoin('satkers', 'kops.kdsatker', '=', 'satkers.kdsatker')
            ->leftJoin('units', 'kops.kdunit', '=', 'units.kdunit')
            ->orderBy('satkers.order', 'asc')
            ->orderBy('kops.kdunit', 'asc')
            ->selectRaw('kops.*, satkers.nmsatker, units.nama as nmunit')
            ->where('kops.kdsatker', 'like', '%' . request('search') . '%')
            ->orWhere('satkers.nmsatker', 'like', '%' . request('search') . '%')
            ->orWhere('units.nama', 'like', '%' . request('search') . '%')
        ;
    }
}
