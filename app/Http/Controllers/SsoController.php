<?php

namespace App\Http\Controllers;

use App\Models\adminSatker;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class SsoController extends Controller
{
    public function sso()
    {
        return redirect(config('sso.base_uri') . config('sso.authorize')['endpoint'] . '?grant_type=' . config('sso.authorize')['grant_type'] . '&response_type=' . config('sso.authorize')['response_type'] . '&client_id=' . config('sso.authorize')['client_id'] . '&scope=' . config('sso.authorize')['scope'] . '&nonce=' .  config('sso.authorize')['nonce'] . 'state=' . config('sso.authorize')['state'] . '&redirect_uri=' . config('sso.authorize')['redirect_uri']);
    }
    public function sign_in(Request $request)
    {
        session()->regenerate();
        if ($request->code) {
            // Get Token

            $response = Http::asForm()->post(config('sso.base_uri') . config('sso.token')['endpoint'], [
                'client_id' => config('sso.authorize')['client_id'],
                'grant_type' => config('sso.authorize')['grant_type'],
                'client_secret' => config('sso.token')['client_secret'],
                'code' => $request->code,
                'redirect_uri' => config('sso.authorize')['redirect_uri']
            ]);

            $token =  json_decode($response->getBody()->getContents(), true);
            if (!isset($token['access_token'])) {
                return redirect('/sso');
            }
            $access_token = $token['access_token'];
            if ($access_token) {
                $response2 = Http::asForm()->post(config('sso.base_uri') . config('sso.userinfo')['endpoint'], [
                    'access_token' => $access_token
                ]);

                if ($response2) {
                    $userinfo =  json_decode($response2->getBody()->getContents(), false);
                    $nip = $userinfo->nip;
                    $user = User::where('nip', $nip)->first();
                    if ($userinfo->jabatan === 'Kepala Subbagian') {
                        $admin = adminSatker::where('kdunit', $userinfo->kode_organisasi)->first();
                        if (isset($admin->id)) {
                            Auth::guard('admin')->loginUsingId($admin->id);
                            $admin->update([
                                'nama' => $userinfo->name,
                                'nip' => $userinfo->nip
                            ]);
                            $request->session()->regenerate();
                            $request->session()->put('gravatar', $userinfo->gravatar);
                            $request->session()->put('nik', $userinfo->g2c_Nik);
                            $request->session()->put('name', $userinfo->name);
                            $request->session()->put('id_token', $token['id_token']);
                            return redirect()->intended('/');
                        }
                    }
                    if (isset($user->id)) {
                        Auth::guard('web')->loginUsingId($user->id);
                        $request->session()->regenerate();
                        $request->session()->put('gravatar', $userinfo->gravatar);
                        $request->session()->put('name', $userinfo->name);
                        $request->session()->put('nik', $userinfo->g2c_Nik);
                        $request->session()->put('id_token', $token['id_token']);
                        return redirect()->intended('/');
                    }
                    return redirect('/login')->with('gagal', 'Pengguna tidak terdaftar');
                } else {
                    redirect('/login')->with('gagal', 'Request Error');
                }
            } else {
                redirect('/login')->with('gagal', 'Request Error');
            }
        } else {
            redirect('/login')->with('gagal', 'Request Error');
        }
    }
}
