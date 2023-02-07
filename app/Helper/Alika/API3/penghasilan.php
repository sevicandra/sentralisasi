<?php

namespace App\Helper\Alika\API3;

use Illuminate\Support\Facades\Http;


class penghasilan
{
    public static function getPenghasilan($nip, $thn)
    {
        $penghasilan=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri3').'data-penghasilan',[
            'nip' => $nip,
            'thn' => $thn,
            'X-API-KEY' => config('alika.key')
        ]);
        return json_decode($penghasilan);
    }

    public static function getTahunPenghasilan($nip)
    {
        $tahun=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri3').'data-tahun-penghasilan',[
            'nip' => $nip,
            'X-API-KEY' => config('alika.key')
        ]);
        return json_decode($tahun);
    }

    public static function getPenghasilanTahunan($nip, $thn)
    {
        $penghasilan=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri3').'data-penghasilan-tahunan',[
            'nip' => $nip,
            'thn' => $thn,
            'X-API-KEY' => config('alika.key')
        ]);
        return json_decode($penghasilan);
    }
}