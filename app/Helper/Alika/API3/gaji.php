<?php

namespace App\Helper\Alika\API3;

use Illuminate\Support\Facades\Http;

class gaji
{
    public static function getGaji($nip, $thn)
    {
        $gaji=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri3').'data-gaji',[
            'nip' => $nip,
            'thn' => $thn,
            'X-API-KEY' => config('alika.key')
        ]);
        return json_decode($gaji);
    }

    public static function getKekuranganGaji($nip, $thn)
    {   
        $kekurangan=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri3').'data-kurang',[
            'nip' => $nip,
            'thn' => $thn,
            'X-API-KEY' => config('alika.key')
        ]);
        return json_decode($kekurangan);
    }

    public static function getTahunGaji($nip)
    {
        $tahun=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri3').'data-tahun-gaji',[
            'nip' => $nip,
            'X-API-KEY' => config('alika.key')
        ]);
        return json_decode($tahun);
    }
}