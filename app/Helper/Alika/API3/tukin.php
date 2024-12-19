<?php

namespace App\Helper\Alika\API3;

use Illuminate\Support\Facades\Http;

class tukin
{
    public static function getTukin($nip, $thn)
    {
        $tukin=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri3').'data-tukin',[
            'nip' => $nip,
            'thn' => $thn,
            'jns'=>0,
            'X-API-KEY' => config('alika.key')
        ]);
        return json_decode($tukin);
    }

    public static function getKekuranganTukin($nip, $thn)
    {   
        $kekurangan=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri3').'data-tukin',[
            'nip' => $nip,
            'thn' => $thn,
            'jns'=>1,
            'X-API-KEY' => config('alika.key')
        ]);
        return json_decode($kekurangan);
    }

    public static function getTahun($nip)
    {
        $tahun=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri3').'data-tahun-tukin',[
            'nip' => $nip,
            'X-API-KEY' => config('alika.key')
        ]);
        return json_decode($tahun);
    }
}