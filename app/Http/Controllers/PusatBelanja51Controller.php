<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PusatBelanja51Controller extends Controller
{
    public function index()
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat', 'approver_pusat'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        return view('belanja-51-pusat.index', [
            'pageTitle' => 'Belanja 51',
        ]);   
    }
}
