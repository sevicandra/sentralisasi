<?php

namespace App\Helper\AlikaNew;

use Illuminate\Support\Facades\Http;
use App\Helper\AlikaNew\Token;
use Illuminate\Support\Facades\Cache;

class Profil
{
    public static function get($kodeSatker, $tahun)
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
                    return json_decode($response, false);
                }
            );
            return $value;
        } catch (\Throwable $th) {
            Cache::forget('alikaToken');
            return null;
        }
    }
}
