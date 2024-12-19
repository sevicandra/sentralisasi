<?php

namespace App\Helper\AlikaNew;

use Illuminate\Support\Facades\Http;
use App\Helper\AlikaNew\Token;
use Illuminate\Support\Facades\Cache;

class Profil
{
    public static function get($kodeSatker, $tahun = null)
    {
        try {
            $token = Token::get();
            $value = Cache::remember(
                'alikaProfil_' . $kodeSatker . '_' . $tahun,
                now()->addMinutes(20),
                function () use ($token, $kodeSatker, $tahun) {
                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $token
                    ])->get(config('alikaNew.url') . '/api/Profil/GetByKdSatker/' . $kodeSatker . '/' . $tahun);
                    return (json_decode($response, false));
                }
            );
            return $value;
        } catch (\Throwable $th) {
            Cache::forget('alikaProfil_' . $kodeSatker . '_' . $tahun);
            return null;
        }
    }

    public static function post($data)
    {
        try {
            $token = Token::get();
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->post(config('alikaNew.url') . '/api/Profil', $data);
            return $response;
        } catch (\Throwable $th) {
            Cache::forget('alikaToken');
            return null;
        }
    }

    public static function put($id, $data)
    {
        try {
            $token = Token::get();
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->put(config('alikaNew.url') . '/api/Profil/'. $id, $data);
            return $response;
        } catch (\Throwable $th) {
            Cache::forget('alikaToken');
            return null;
        }
    }

    public static function delete($data)
    {
        try {
            $token = Token::get();
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->delete(config('alikaNew.url') . '/api/Profil', $data);
            return $response;
        } catch (\Throwable $th) {
            Cache::forget('alikaToken');
            return null;
        }
    }

    public static function getPenandatangan($id)
    {
        try {
            $token = Token::get();
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->get(config('alikaNew.url') . '/api/Profil/?id=' . $id);
            return json_decode($response, false);
        } catch (\Throwable $th) {
            Cache::forget('alikaToken');
            return null;
        }
    }
}
