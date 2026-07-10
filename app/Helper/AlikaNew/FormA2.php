<?php

namespace App\Helper\AlikaNew;

use Illuminate\Support\Facades\Http;
use App\Helper\AlikaNew\Token;
use Illuminate\Support\Facades\Cache;

class FormA2
{
    public static function preview($nip, $tahun, $kdsatker)
    {
        try {
            $token = Token::get();
            $value = Cache::remember(
                'alika1721A2Preview_' . $nip . '_' . $tahun . '_' . $kdsatker,
                now()->addMinutes(5),
                function () use ($token, $kdsatker, $nip, $tahun) {
                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $token
                    ])->post(config('alikaNew.url') . '/api/v1/1721-A2/Preview', [
                        'nip' => $nip,
                        'tahun' => $tahun,
                        'kdsatker' => $kdsatker
                    ]);
                    return $response->body();
                }
            );
            return $value;
        } catch (\Throwable $th) {
            Cache::forget('alika1721A2Preview_' . $nip . '_' . $tahun . '_' . $kdsatker);
            return null;
        }
    }
}
