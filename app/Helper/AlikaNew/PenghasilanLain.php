<?php

namespace App\Helper\AlikaNew;

use Illuminate\Support\Facades\Http;
use App\Helper\AlikaNew\Token;
use Illuminate\Support\Facades\Cache;

class PenghasilanLain
{
    public static function get($nip, $tahun, $jns = null, $bln = null)
    {
        $token = Token::get();
        if ($jns && $bln) {
            try {
                $value = Cache::remember('alikaPengBayaranLain_' . $nip . '_' . $tahun . "_" . $jns . "_" . $bln, now()->addMinutes(20), function () use ($token, $nip, $tahun, $jns, $bln) {
                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $token
                    ])->get(config('alikaNew.url') . '/api/PengBayaranLain/GetByNip/' . $nip . '/' . $tahun . '/' . $jns . '/' . $bln);
                    return json_decode($response, false);
                });
            } catch (\Throwable $th) {
                Cache::forget('alikaPengBayaranLain_' . $nip . '_' . $tahun . "_" . $jns . "_" . $bln);
                return null;
            }
        }
        if ($jns == null) {
            try {
                $value = Cache::remember('alikaPenghasilanLain_' . $nip . '_' . $tahun, now()->addMinutes(20), function () use ($token, $nip, $tahun) {
                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $token
                    ])->get(config('alikaNew.url') . '/api/PenghasilanLain/GetByNip/' . $nip . '/' . $tahun);
                    return json_decode($response, false);
                });
            } catch (\Throwable $th) {
                Cache::forget('alikaPengBayaranLain_' . $nip . '_' . $tahun);
                return null;
            }
        } else {
            try {
                $value = Cache::remember('alikaPenghasilanLain_' . $nip . '_' . $tahun . "_" . $jns, now()->addMinutes(20), function () use ($token, $nip, $tahun, $jns) {
                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $token
                    ])->get(config('alikaNew.url') . '/api/PenghasilanLain/GetByNip/' . $nip . '/' . $tahun . '/' . $jns);
                    return json_decode($response, false);
                });
            } catch (\Throwable $th) {
                Cache::forget('alikaPengBayaranLain_' . $nip . '_' . $tahun . "_" . $jns);
                return null;
            }
        }
        return $value;
    }

    public static function tahun($nip)
    {
        try {
            $token = Token::get();
            $value = Cache::remember('alikaPenghasilanLainTahun_' . $nip, now()->addMinutes(20), function () use ($token, $nip) {
                $response = Http::withToken($token)->get(config('alikaNew.url') . '/api/PenghasilanLain/GetTahun/' . $nip);
                return json_decode($response, false);
            });
            return $value;
        } catch (\Throwable $th) {
            Cache::forget('alikaPenghasilanLainTahun_' . $nip);
            return null;
        }
    }

    public static function jenis($nip, $tahun)
    {
        try {
            $token = Token::get();
            $value = Cache::remember('alikaPenghasilanLainJenis_' . $nip . '_' . $tahun, now()->addMinutes(20), function () use ($token, $nip, $tahun) {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token
                ])->get(config('alikaNew.url') . '/api/PenghasilanLain/GetJenis/' . $nip . '/' . $tahun);
                return json_decode($response, false);
            });
            return $value;
        } catch (\Throwable $th) {
            Cache::forget('alikaPenghasilanLainJenis_' . $nip . '_' . $tahun);
            return null;
        }
    }

    public static function pph($nip, $tahun)
    {
        try {
            $token = Token::get();
            $value = Cache::remember('alikaPenghasilanLainPph_' . $nip . '_' . $tahun, now()->addMinutes(20), function () use ($token, $nip, $tahun) {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token
                ])->get(config('alikaNew.url') . '/api/PenghasilanLain/GetPPh/' . $nip . '/' . $tahun);
                return json_decode($response, false);
            });
            return $value;
        } catch (\Throwable $th) {
            Cache::forget('alikaPenghasilanLainPph_' . $nip . '_' . $tahun);
            return null;
        }
    }
}
