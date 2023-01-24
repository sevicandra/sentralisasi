<?php

namespace App\Helper\Alika;

use Illuminate\Support\Facades\Http;


class dataLembur
{
    public static function getPph($nip, $thn)
    {
        $pph=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri').'data-pph-lembur',[
            'nip' => $nip,
            'thn' => $thn,
            'X-API-KEY' => config('alika.key')
        ]);
        return json_decode($pph);
    }
}