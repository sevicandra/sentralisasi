<?php

namespace App\Helper\AlikaNew;

use Illuminate\Support\Facades\Http;
use App\Helper\AlikaNew\Token;
use Illuminate\Support\Facades\Cache;


class RefPangkat
{
    public static function get()
    {
        $data = Cache::remember('refPangkat',  now()->addMinutes(20), function () {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . Token::get(),
            ])->get(config('alikaNew.url') . '/api/RefPangkat');
            return json_decode($response, false);
        });
        return $data;
    }
}