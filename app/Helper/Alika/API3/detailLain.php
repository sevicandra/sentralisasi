<?php

namespace App\Helper\Alika\API3;

use Illuminate\Support\Facades\Http;


class detailLain
{
    public static function getTarif($thn)
    {
        $tarif = Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get( config('alika.uri3').'data-ref-spt',[
            'thn'=>$thn,
            'X-API-KEY' => config('alika.key')
        ]);
        return json_decode($tarif);
    }

    public static function getProfil($kdsatker, $thn)
    {
        $profil = Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get( config('alika.uri3').'data-profil',[
            'kdsatker' => $kdsatker,
            'tahun'=>$thn,
            'X-API-KEY' => config('alika.key')
        ]);
        return json_decode($profil);
    }
}