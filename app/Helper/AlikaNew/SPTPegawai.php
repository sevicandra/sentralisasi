<?php

namespace App\Helper\AlikaNew;

use Illuminate\Support\Facades\Http;
use App\Helper\AlikaNew\Token;
use Illuminate\Support\Facades\Cache;

class SPTPegawai
{
    public static function get($nip, $tahun)
    {
        try {
            $token = Token::get();
            $value = Cache::remember(
                'alikaSPTPegawai_' . $nip . '_' . $tahun,
                now()->addMinutes(20),
                function () use ($token, $nip, $tahun) {
                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $token
                    ])->get(config('alikaNew.url') . '/api/DataSptPegawai/GetByNip/' . $nip . '/' . $tahun);
                    return json_decode($response, false);
                }
            );
            return $value;
        } catch (\Throwable $th) {
            Cache::forget('alikaToken');
            return null;
        }
    }
    public static function tahunByNip($nip)
    {
        try {
            $token = Token::get();
            $value = Cache::remember('alikaSPTPegawaiTahunByNip_' . $nip, now()->addMinutes(20), function () use ($token, $nip) {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token
                ])->get(config('alikaNew.url') . '/api/DataSptPegawai/GetTahun/GetByNip/' . $nip);
                return json_decode($response, false);
            });
            return $value;
        } catch (\Throwable $th) {
            Cache::forget('alikaSPTPegawaiTahunByNip_' . $nip);
            return null;
        }
    }
    public static function gaji($nip, $tahun)
    {
        try {
            $token = Token::get();
            $value = Cache::remember('alikaSPTPegawaiGaji_' . $nip . '_' . $tahun, now()->addMinutes(20), function () use ($token, $nip, $tahun) {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token
                ])->get(config('alikaNew.url') . '/api/DataSptPegawai/Gaji/' . $nip . '/' . $tahun);
                return json_decode($response, false);
            });
            return $value;
        } catch (\Throwable $th) {
            Cache::forget('alikaSPTPegawaiGaji_' . $nip . '_' . $tahun);
            return null;
        }
    }
    public static function kekuranganGaji($nip, $tahun)
    {
        try {
            $token = Token::get();
            $value = Cache::remember('alikaSPTPegawaiKekuranganGaji_' . $nip . '_' . $tahun, now()->addMinutes(20), function () use ($token, $nip, $tahun) {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token
                ])->get(config('alikaNew.url') . '/api/DataSptPegawai/KekuranganGaji/' . $nip . '/' . $tahun);
                return json_decode($response, false);
            });
            return $value;
        } catch (\Throwable $th) {
            Cache::forget('alikaSPTPegawaiKekuranganGaji_' . $nip . '_' . $tahun);
            return null;
        }
    }
    public static function tukin($nip, $tahun)
    {
        try {
            $token = Token::get();
            $value = Cache::remember('alikaSPTPegawaiTukin_' . $nip . '_' . $tahun, now()->addMinutes(20), function () use ($token, $nip, $tahun) {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token
                ])->get(config('alikaNew.url') . '/api/DataSptPegawai/Tukin/' . $nip . '/' . $tahun);
                return json_decode($response, false);
            });
            return $value;
        } catch (\Throwable $th) {
            Cache::forget('alikaSPTPegawaiTukin_' . $nip);
            return null;
        }
    }
}
