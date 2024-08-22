<?php

namespace App\Http\Controllers;

use App\Models\NotifikasiBelanja51;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class Belanja51Controller extends Controller
{
    public function index()
    {
        if (Auth::guard('web')->check()) {
            $gate = ['plt_admin_satker', 'opr_belanja_51_vertikal', 'approver_vertikal'];
        } else {
            $gate = ['admin_satker'];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        $notifBelanja51Tolak = NotifikasiBelanja51::NotifikasiVertikal(auth()->user()->kdsatker);
        return view('belanja-51.index', [
            'pageTitle' => 'Belanja 51',
            'data' => NotifikasiBelanja51::where('kdsatker', auth()->user()->kdsatker)->where('status', 'unread')->get(),
            'notifBelanja51Tolak' => $notifBelanja51Tolak,
        ]);
    }

    public function notifikasi(NotifikasiBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['plt_admin_satker', 'opr_belanja_51_vertikal', 'approver_vertikal'];
        } else {
            $gate = ['admin_satker'];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->kdsatker != auth()->user()->kdsatker) {
            abort(403);
        }

        $id->update(['status' => 'read']);
        return redirect()->back();
    }

    public function document($path)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['plt_admin_satker', 'opr_belanja_51', 'approver_vertikal', 'approver_pusat', 'sys_admin'];
        } else {
            $gate = ['admin_satker'];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        return response()->file(Storage::path($path), [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
