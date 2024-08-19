<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FilePermohonanBelanja51 extends Model
{
    use HasFactory;

    protected $guarded = ['id'];    

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($data) {
            if ($data->file) {
                Storage::delete($data->file);
            }
        });
    }

    public function permohonan()
    {
        return $this->belongsTo(PermohonanBelanja51::class, 'permohonan_id', 'id');
    }

}
