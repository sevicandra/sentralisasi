<?php

namespace App\Helper\AlikaNew;

use Illuminate\Support\Facades\Http;
use App\Helper\AlikaNew\Token;
use Illuminate\Support\Facades\Cache;

class refJabatan
{
    public static function get()
    {
        $data = Cache::remember('refJabatan',  now()->addMinutes(20), function () {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . Token::get(),
            ])->get(config('alikaNew.url') . '/api/RefJabatan');
            return json_decode($response, false);
        });
        return $data;
    }
}
