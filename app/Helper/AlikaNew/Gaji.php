<?php

namespace App\Helper\AlikaNew;
use Illuminate\Support\Facades\Http;
use App\Helper\AlikaNew\Token;
use Illuminate\Support\Facades\Cache;

class Gaji
{
    public static function get($nip, $tahun)
    {
        try {
            $token = Token::get();
            $value = Cache::remember('alikaGaji_' . $nip . '_' . $tahun, now()->addMinutes(20), function () use ($token, $nip, $tahun) {
                $response = Http::withToken($token)->get(config('alikaNew.url') . '/api/v1/Gaji?nip=' . $nip . '&tahun=' . $tahun);
                return json_decode($response, false);
            });
            return $value;
        } catch (\Throwable $th) {
            Cache::forget('alikaGaji_' . $nip . '_' . $tahun);
            return null;
        }
    }

    public static function tahun($nip)
    {
        try {
            $token = Token::get();
            $value = Cache::remember('alikaGajiTahun_' . $nip, now()->addMinutes(20), function () use ($token, $nip) {
                $response = Http::withToken($token)->get(config('alikaNew.url') . '/api/v1/Gaji/GetTahun?nip=' . $nip);
                return json_decode($response, false);
            });
            return $value;
        } catch (\Throwable $th) {
            Cache::forget('alikaGajiTahun_' . $nip);
            return null;
        }
    }
}
