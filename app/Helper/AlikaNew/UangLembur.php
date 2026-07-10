<?php

namespace App\Helper\AlikaNew;

use Illuminate\Support\Facades\Http;
use App\Helper\AlikaNew\Token;
use Illuminate\Support\Facades\Cache;

class UangLembur
{
    public static function get($nip, $tahun)
    {
        try {
            $token = Token::get();
            $value = Cache::remember('alikaUangLembur_' . $nip . '_' . $tahun, now()->addMinutes(20), function () use ($token, $nip, $tahun) {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token
                ])->get(config('alikaNew.url') . '/api/v1/UangLembur?nip=' . $nip . '&tahun=' . $tahun);
                return json_decode($response, false);
            });
            return $value;
        } catch (\Throwable $th) {
            Cache::forget('alikaUangLembur_' . $nip . '_' . $tahun);
            return null;
        }
    }
    public static function tahun($nip)
    {
        try {
            $token = Token::get();
            $value = Cache::remember('alikaUangLemburTahun_' . $nip, now()->addMinutes(20), function () use ($token, $nip) {
                $response = Http::withToken($token)->get(config('alikaNew.url') . '/api/v1/UangLembur/GetTahun?nip=' . $nip);
                return json_decode($response, false);
            });
            return $value;
        } catch (\Throwable $th) {
            Cache::forget('alikaUangLemburTahun_' . $nip);
            return null;
        }
    }
    public static function pph($nip, $tahun)
    {
        try {
            $token = Token::get();
            $value = Cache::remember('alikaUangLemburPph_' . $nip . '_' . $tahun, now()->addMinutes(20), function () use ($token, $nip, $tahun) {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token
                ])->get(config('alikaNew.url') . '/api/UangLembur/GetPPh/' . $nip . '/' . $tahun);
                return json_decode($response, false);
            });
            return $value;
        } catch (\Throwable $th) {
            Cache::forget('alikaUangLemburPph_' . $nip . '_' . $tahun);
            return null;
        }
    }
}
