<?php

namespace App\Helper\AlikaNew;

use App\Helper\AlikaNew\Token;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class RefSPTTahunan
{
    public static function get($tahun)
    {
        try {
            $token = Token::get();
            $value = Cache::remember('alikaRefSPTTahunan_'.$tahun, now()->addMinutes(20), function () use ($token, $tahun) {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token
                ])->get(config('alikaNew.url') . '/api/RefSptTahunan/GetByTahun/' . $tahun);
                return json_decode($response, false);
            });
            return $value;
        } catch (\Throwable $th) {
            Cache::forget('alikaRefSPTTahunan_'.$tahun);
            return null;
        }
    }
}
