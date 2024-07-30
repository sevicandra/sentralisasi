<?php

namespace App\Helper\AlikaNew;
use Illuminate\Support\Facades\Http;
use App\Helper\AlikaNew\Token;
use Illuminate\Support\Facades\Cache;

class KekuranganGaji
{
    public static function get($nip, $tahun)
    {
        try {
            $token = Token::get();
            $value = Cache::remember('alikaKekuranganGaji_' . $nip . '_' . $tahun, now()->addMinutes(20), function () use ($token, $nip, $tahun) {
                $response = Http::withToken($token)->get(config('alikaNew.url') . '/api/KekuranganGaji/GetByNip/' . $nip . '/' . $tahun);
                return json_decode($response, false);
            });
            return $value;
        } catch (\Throwable $th) {
            Cache::forget('alikaKekuranganGaji_' . $nip . '_' . $tahun);
            return null;
        }
    }
}