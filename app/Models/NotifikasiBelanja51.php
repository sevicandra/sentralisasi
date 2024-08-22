<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifikasiBelanja51 extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function scopeNotifikasiVertikal($data, $kdsatker)
    {
        return $data->where('kdsatker', $kdsatker)->where('status', 'unread')->count();
    }

    public function scopeNotifikasiPusat($data, $kdsatker, $kdunit)
    {
        return $data->where('kdsatker', $kdsatker)->where('kdunit', $kdunit)->where('status', 'unread')->count();
    }
}
