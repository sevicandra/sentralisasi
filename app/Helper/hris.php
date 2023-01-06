<?php

namespace App\Helper;

use Illuminate\Support\Facades\Http;

class hris
{
    public static function token()
    {
        $token= Http::asForm()->post(config('hris.token_uri'),[
            'client_secret'=>config('hris.secret'),
            'client_id' =>config('hris.id'),
            'grant_type'=>config('hris.grant')
        ]);
        return json_decode($token, false)->access_token;
    }

    public static function getPegawai($nip)
    {
        $accesstoken = self::token();
        $pegawai = Http::withToken($accesstoken)->get(config('hris.uri').'profil/Pegawai/GetByNip/'.$nip);
        return collect([json_decode($pegawai, false)->Data]);
    }

    public static function getPegawaiBySatker($kdSatker)
    {
        $accesstoken = self::token();
        $pegawai = Http::withToken($accesstoken)->get(config('hris.uri').'profil/pegawai/getByKodeSatker',[
            "kdSatker"=>$kdSatker,
        ]);
        return collect(json_decode($pegawai, false)->Data);
    }
}