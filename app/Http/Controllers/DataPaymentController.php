<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DataPaymentController extends Controller
{
    public function index()
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[''];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        return redirect('/data-payment/server');
        return view('data-payment.index');
    }
}
