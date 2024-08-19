<?php

namespace App\Models;

use App\Helper\Esign\Tte;
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

    public function TTE($nomor, $nik, $passpharse)
    {
        try {
            $tte = new Tte();
            $response = $tte->esign([
                'tujuan' => "Sekretaris Direktorat Jenderal Kekayaan Negara c.q. Kepala Bagian Keuangan",
                'nomor' => $nomor,
                'jenis_dokumen' => "Register Permohonan Uang Makan",
                'perihal' => $this->nama,
                'linkQR' => config('app.url') . '/belanja-51-v2/document/' . $this->file,
                'file' => $this->file,
            ], $nik, $passpharse);
            $result = $response->getBody()->getContents();
            $result_header = $response->getHeaders();
            Storage::put($this->file, $result);
            $this->update([
                'status' => 'success',
                'date' => $result_header['Date'][0],
                'id_dokumen' => $result_header['id_dokumen'][0],
            ]);
        } catch (\Throwable $th) {
            $this->update([
                'status' => 'failed',
            ]);
        }
    }
}
