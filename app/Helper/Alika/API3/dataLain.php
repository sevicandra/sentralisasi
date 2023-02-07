<?php

namespace App\Helper\Alika\API3;

use Illuminate\Support\Facades\Http;


class dataLain
{
    public static function getPph($nip, $thn)
    {
        $pph=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri3').'data-pph-lain',[
            'nip' => $nip,
            'thn' => $thn,
            'X-API-KEY' => config('alika.key')
        ]);
        return json_decode($pph);
    }
}