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

    public static function getLain($nip, $thn, $jns)
    {
        $lain=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri3').'data-lain',[
            'nip' => $nip,
            'thn' => $thn,
            'jns' => $jns,
            'X-API-KEY' => config('alika.key')
        ]);
        return json_decode($lain);
    }

    public static function getLainDetail($nip, $thn, $jns, $bln)
    {
        $lain=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri3').'data-detail-lain',[
            'nip' => $nip,
            'thn' => $thn,
            'jns' => $jns,
            'bln' => $bln,
            'X-API-KEY' => config('alika.key')
        ]);
        return json_decode($lain);
    }

    public static function getTahun($nip)
    {
        $tahun=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri3').'data-tahun-lain',[
            'nip' => $nip,
            'X-API-KEY' => config('alika.key')
        ]);
        return json_decode($tahun);
    }

    public static function getJenis($nip, $thn)
    {
        $jenis=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri3').'data-jenis-lain',[
            'nip' => $nip,
            'thn' => $thn,
            "X_API_KEY" => config('alika.key')
        ]);
        return json_decode($jenis);
    }
}