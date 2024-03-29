<?php

namespace App\Helper\Alika\API3;

use Illuminate\Support\Facades\Http;

class satkerAlika
{
    public static function getDetailSatker($kdSatker)
    {
        $satker = Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get( config('alika.uri3').'data-detail-satker',[
            'kdsatker' => $kdSatker,
            'X-API-KEY' => config('alika.key')
        ]);
        return json_decode($satker);
    }
}