<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function index()
    {

        if (Auth::guard('web')->check()) {
            $gate=['sys_admin', 'plt_admin_satker'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        
        return view('admin.index');
    }
}
