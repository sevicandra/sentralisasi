<?php

namespace App\Helper\Alika\API3;

use Illuminate\Support\Facades\Http;

class spt{
    public static function getSptPegawai($nip, $thn)
    {
        $peg = Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get( config('alika.uri3').'data-spt-pegawai',[
            'nip' => $nip,
            'thn'=>$thn,
            'X-API-KEY' => config('alika.key')
        ]);
        return json_decode($peg);
    }

    public static function getViewGaji($nip, $thn){
        $gaji = Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get( config('alika.uri3').'data-view-gaji',[
            'nip' => $nip,
            'thn'=>$thn,
            'X-API-KEY' => config('alika.key')
        ]);
        return json_decode($gaji);
    }

    public static function getViewKurang($nip, $thn)
    {
        $kurang = Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get( config('alika.uri3').'data-view-kurang',[
            'nip' => $nip,
            'thn'=>$thn,
            'X-API-KEY' => config('alika.key')
        ]);
        return json_decode($kurang);
    }

    public static function getViewTukin($nip, $thn)
    {
        $tukin = Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get( config('alika.uri3').'data-view-tukin',[
            'nip' => $nip,
            'thn'=>$thn,
            'X-API-KEY' => config('alika.key')
        ]);
        return json_decode($tukin);
    }
    

    public static function getViewRapel($nip, $thn)
    {
        $rapel = Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get( config('alika.uri3').'data-view-rapel',[
            'nip' => $nip,
            'thn'=>$thn,
            'X-API-KEY' => config('alika.key')
        ]);
        return json_decode($rapel);
    }

    public static function getTahun($nip)
    {
        $tahun = Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get( config('alika.uri3').'data-tahun-spt',[
            'nip' => $nip,
            'X-API-KEY' => config('alika.key')
        ]);
        return json_decode($tahun);
    }
}