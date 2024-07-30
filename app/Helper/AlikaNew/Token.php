<?php
namespace App\Helper\AlikaNew;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class Token
{
    public static function get()
    {
        try {
            $value = Cache::remember('alikaToken', now()->addMinutes(20), function () {
                $token = Http::asForm()->post(config('alikaNew.token'), [
                    'client_secret' => config('alikaNew.secret'),
                    'client_id' => config('alikaNew.id'),
                    'grant_type' => config('alikaNew.grant'),
                    'scope' => config('alikaNew.scopes'),
                ]);
                return json_decode($token, false)->access_token;
            });
            return $value;
        } catch (\Throwable $th) {
            Cache::forget('alikaToken');
            return null;
        }
    }
}