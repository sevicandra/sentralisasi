<?php
namespace App\Helper\AlikaNew;

use Illuminate\Support\Facades\Http;
use App\Helper\AlikaNew\Token;
use Illuminate\Support\Facades\Cache;

class Satker
{
    public static function get($kdsatker)
    {
        try {
            $token = Token::get();
            $value = Cache::remember(
                'alikaSatker_' . $kdsatker,
                now()->addMinutes(20),
                function () use ($token, $kdsatker) {
                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $token
                    ])->get(config('alikaNew.url') . '/api/Satker/GetByKdSatker/' . $kdsatker);
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