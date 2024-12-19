<?php

namespace App\Helper\Alika\API3;

use Illuminate\Support\Facades\Http;


class dataLembur
{
    public static function getPph($nip, $thn)
    {
        $pph=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri3').'data-pph-lembur',[
            'nip' => $nip,
            'thn' => $thn,
            'X-API-KEY' => config('alika.key')
        ]);
        return json_decode($pph);
    }

    public static function getLembur($nip, $thn)
    {
        $lembur=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri3').'data-lembur',[
            'nip' => $nip,
            'thn' => $thn,
            'X-API-KEY' => config('alika.key')
        ]);
        return json_decode($lembur);
    }

    public static function getTahun($nip)
    {
        $tahun=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri3').'data-tahun-lembur',[
            'nip' => $nip,
            'X-API-KEY' => config('alika.key')
        ]);
        return json_decode($tahun);
    }
}