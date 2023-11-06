<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
        $uri = config('sso.base_uri') . config('sso.endsession.endpoint');
        $id_token = session()->get('id_token');
        $post_logout_redirect_uri = config('sso.authorize.redirect_uri');
        $state = config('sso.authorize.state');
        $endsession_url = $uri . '?id_token_hint=' . $id_token . '&post_logout_redirect_uri=' . $post_logout_redirect_uri . '&state=' . $state;
        return redirect($endsession_url);
    }
}
