<?php

namespace App\Helper\AlikaNew;

use Illuminate\Support\Facades\Http;
use App\Helper\AlikaNew\Token;
use Illuminate\Support\Facades\Cache;

class Penghasilan
{
    public static function get($nip, $tahun)
    {
        try {
            $token = Token::get();
            $value = Cache::remember('alikaPenghasilan_' . $nip . '_' . $tahun, now()->addMinutes(20), function () use ($token, $nip, $tahun) {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token
                ])->get(config('alikaNew.url') . '/api/Penghasilan/Detail/' . $nip . '/' . $tahun);
                return json_decode($response, false);
            });
            return $value;
        } catch (\Throwable $th) {
            Cache::forget('alikaPenghasilan_' . $nip . '_' . $tahun);
            return null;
        }
    }
    public static function gaji($nip, $tahun){
        try {
            $token = Token::get();
            $value = Cache::remember('alikaPenghasilanGaji_' . $nip . '_' . $tahun, now()->addMinutes(20), function () use ($token, $nip, $tahun) {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token
                ])->get(config('alikaNew.url') . '/api/Penghasilan/Gaji/' . $nip . '/' . $tahun);
                return json_decode($response, false);
            });
            return $value;
        } catch (\Throwable $th) {
            Cache::forget('alikaPenghasilanGaji_' . $nip . '_' . $tahun);
            return null;
        }
    }
    public static function tukin($nip, $tahun){
        try {
            $token = Token::get();
            $value = Cache::remember('alikaPenghasilanTukin_' . $nip . '_' . $tahun, now()->addMinutes(20), function () use ($token, $nip, $tahun) {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token
                ])->get(config('alikaNew.url') . '/api/Penghasilan/Tukin/' . $nip . '/' . $tahun);
                return json_decode($response, false);
            });
            return $value;
        } catch (\Throwable $th) {
            Cache::forget('alikaPenghasilanTukin_' . $nip . '_' . $tahun);
            return null;
        }
    }
}
