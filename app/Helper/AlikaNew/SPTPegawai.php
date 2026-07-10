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
                    ])->get(config('alikaNew.url') . '/api/v1/DataSptPegawai/?nip=' . $nip . '&tahun=' . $tahun);
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
                ])->get(config('alikaNew.url') . '/api/v1/DataSptPegawai/GetTahun?nip=' . $nip);
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
                ])->get(config('alikaNew.url') . '/api/v1/DataSptPegawai/Gaji/' . $nip . '/' . $tahun);
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
                ])->get(config('alikaNew.url') . '/api/v1/DataSptPegawai/KekuranganGaji/' . $nip . '/' . $tahun);
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
                ])->get(config('alikaNew.url') . '/api/v1/DataSptPegawai/Tukin/' . $nip . '/' . $tahun);
                return json_decode($response, false);
            });
            return $value;
        } catch (\Throwable $th) {
            Cache::forget('alikaSPTPegawaiTukin_' . $nip);
            return null;
        }
    }
    public static function getByKdSatker($kdSatker, $tahun, $limit, $offset, $nip = null)
    {
        try {
            $token = Token::get();
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token

            ])->get(config('alikaNew.url') . '/api/v1/DataSptPegawai', [
                'kdsatker' => $kdSatker,
                'tahun' => $tahun, 
                'nip' => $nip
            ]);

            return json_decode($response, false);
        } catch (\Throwable $th) {
        }
    }
    public static function tahunByKdSatker($kdSatker)
    {
        try {
            $token = Token::get();
            $value = Cache::remember('alikaSPTPegawaiTahunByKdSatker_' . $kdSatker, now()->addMinutes(20), function () use ($token, $kdSatker) {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token
                ])->get(config('alikaNew.url') . '/api/v1/DataSptPegawai/GetTahun?kdsatker' . $kdSatker);
                return json_decode($response, false);
            });
            return $value;
        } catch (\Throwable $th) {
            Cache::forget('alikaSPTPegawaiTahunByKdSatker_' . $kdSatker);
            return null;
        }
    }
    public static function countByKdSatker($kdSatker, $tahun)
    {
        try {
            $token = Token::get();
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->get(config('alikaNew.url') . '/api/v1/DataSptPegawai/Count?kdsatker=' . $kdSatker . '&tahun=' . $tahun);
            return json_decode($response, false);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public static function getById($id)
    {
        try {
            $token = Token::get();
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->get(config('alikaNew.url') . '/api/v1/DataSptPegawai/' . $id);
            return json_decode($response, false);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public static function put($id, $data)
    {
        try {
            $token = Token::get();
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->patch(config('alikaNew.url') . '/api/v1/DataSptPegawai/' . $id, $data);
            return $response;
        } catch (\Throwable $th) {
            return null;
        }
    }
    public static function destroy($id)
    {
        try {
            $token = Token::get();
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->delete(config('alikaNew.url') . '/api/v1/DataSptPegawai/' . $id);
            return $response;
        } catch (\Throwable $th) {
            return null;
        }
    }
    public static function post($data)
    {
        try {
            $token = Token::get();
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->post(config('alikaNew.url') . '/api/v1/DataSptPegawai/', $data);
            return $response;
        } catch (\Throwable $th) {
            return null;
        }
    }
}
