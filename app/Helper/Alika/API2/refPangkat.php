<?php

namespace App\Helper\Alika\API2;

use Illuminate\Support\Facades\Http;

class refPangkat{
    public static function get(){
        $data=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri2').'ref-pangkat',[
            'X-API-KEY' => config('alika.key')
        ]);
        return json_decode($data);
    }
}