<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotifikasiBelanja51;
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
            'data' => NotifikasiBelanja51::where('kdunit', auth()->user()->kdunit)->where('status', 'unread')->get(),
            'notifBelanja51Tolak' => NotifikasiBelanja51::NotifikasiPusat(auth()->user()->kdsatker, auth()->user()->kdunit),
        ]);   
    }

    public function notifikasi(NotifikasiBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat', 'approver_pusat'];
        } else {
            $gate = [''];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->kdunit != auth()->user()->kdunit) {
            abort(403);
        }
        
        $id->update(['status' => 'read']);
        return redirect()->back();
    }
}
