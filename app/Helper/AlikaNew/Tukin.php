<?php

namespace App\Helper\AlikaNew;

use Illuminate\Support\Facades\Http;
use App\Helper\AlikaNew\Token;
use Illuminate\Support\Facades\Cache;

class Tukin
{
    public static function get($nip, $tahun)
    {
        try {
            $token = Token::get();
            $value = Cache::remember('alikaTukin_' . $nip . '_' . $tahun, now()->addMinutes(20), function () use ($token, $nip, $tahun) {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token
                ])->get(config('alikaNew.url') . '/api/v1/Tukin?nip=' . $nip . '&tahun=' . $tahun);
                return json_decode($response, false);
            });
            return $value;
        } catch (\Throwable $th) {
            Cache::forget('alikaTukin_' . $nip . '_' . $tahun);
            return null;
        }
    }

    public static function tahun($nip)
    {
        try {
            $token = Token::get();
            $value = Cache::remember('alikaTukinTahun_' . $nip, now()->addMinutes(20), function () use ($token, $nip) {
                $response = Http::withToken($token)->get(config('alikaNew.url') . '/api/v1/Tukin/GetTahun?nip=' . $nip);
                return json_decode($response, false);
            });
            return $value;
        } catch (\Throwable $th) {
            Cache::forget('alikaTukinTahun_' . $nip);
            return null;
        }
    }
}
