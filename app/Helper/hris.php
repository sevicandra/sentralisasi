<?php

namespace App\Helper;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class hris
{
    public static function token()
    {
        try {
            $value = Cache::remember('hrisToken', now()->addMinutes(20), function () {
                $token = Http::asForm()->post(config('hris.token_uri'), [
                    'client_secret' => config('hris.secret'),
                    'client_id' => config('hris.id'),
                    'grant_type' => config('hris.grant')
                ]);
                return json_decode($token, false)->access_token;
            });

            return $value;
        } catch (\Throwable $th) {
            Cache::forget('hrisToken');
            return null;
        }
    }

    public static function getPegawai($nip)
    {
        try {
        $accesstoken = self::token();
        $value = Cache::remember('hrisPegawai' . $nip, now()->addMinutes(20), function () use ($accesstoken, $nip) {
            $pegawai = Http::withToken($accesstoken)->get(config('hris.uri') . 'profil/Pegawai/GetByNip/' . $nip);
            return collect([json_decode($pegawai, false)->Data]);
        });
        return $value;
        } catch (\Throwable $th) {
            Cache::forget('hrisPegawai' . $nip);
            return null;
        }
    }

    public static function getPegawaiBySatker($kdSatker)
    {
        try {
            $value = Cache::remember('hrisPegawaiBySatker' . $kdSatker, now()->addMinutes(20), function () use ($kdSatker) {
                $accesstoken = self::token();
                $pegawai = Http::withToken($accesstoken)->get(config('hris.uri') . 'profil/pegawai/getByKodeSatker', [
                    "kdSatker" => $kdSatker,
                ]);
                return collect(json_decode($pegawai, false)->Data);
            });
            return $value;
        } catch (\Throwable $th) {
            Cache::forget('hrisPegawaiBySatker' . $kdSatker);
            return null;
        }
    }

    public static function getKeluarga($nip)
    {
        try {
            $value = Cache::remember('hrisKeluarga' . $nip, now()->addMinutes(20), function () use ($nip) {
                $accesstoken = self::token();
                $pegawai = Http::withToken($accesstoken)->get(config('hris.uri') . 'keluarga/Riwayat/GetKeluargaByNip/' . $nip);
                return collect([json_decode($pegawai, false)->Data]);
            });
            return $value;
        } catch (\Throwable $th) {
            Cache::forget('hrisKeluarga' . $nip);
            return null;
        }
    }

    public static function getRekening($nip)
    {
        try {
            $value = Cache::remember('hrisRekening' . $nip, now()->addMinutes(20), function () use ($nip) {
                $accesstoken = self::token();
                $pegawai = Http::withToken($accesstoken)->get(config('hris.uri') . 'rekening/Riwayat/GetRekeningByNip/' . $nip);
                return collect([json_decode($pegawai, false)->Data]);
            });

            return $value;
        } catch (\Throwable $th) {
            Cache::forget('hrisRekening' . $nip);
            return null;
        }
    }
}
