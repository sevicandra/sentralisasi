<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPermohonanUangLembur extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeRekap($data)
    {
        return $data->groupBy(['nip', 'nama'])->selectRaw('nip, nama, SUM(CASE WHEN jenishari = "kerja" THEN jumlahjam ELSE 0 END) as jumlahjamkerja, SUM(CASE WHEN jenishari = "libur" THEN jumlahjam ELSE 0 END) as jumlahjamlibur, group_concat(golongan)');
    }

    public function scopeRekapTanggal($data)
    {
        return $data->select('nama', 'nip', 'tanggal', 'absensimasuk', 'absensikeluar')
            ->orderBy('nip')
            ->orderBy('tanggal')
            ->get()
            ->groupBy('nip')
            ->map(function ($items) {
                $responseData = new \stdClass();
                $responseData->nama = $items->first()->nama;
                $responseData->nip = $items->first()->nip;
                $responseData->data = $items->map(function ($item) {
                    return (object) [
                        'tanggal' => $item->tanggal,
                        'absensimasuk' => $item->absensimasuk,
                        'absensikeluar' => $item->absensikeluar,
                        'jenishari' => $item->jenishari,
                    ];
                });
                return $responseData;
            });
    }
}
