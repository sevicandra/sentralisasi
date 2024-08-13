<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sewaRumahDinas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class SewaRumahDinasMonitoringNonAktifController extends Controller
{
    public function index(){
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        return view('rumah-dinas.monitoring_nonaktif.index',[
            'data'=>sewaRumahDinas::MonitoringNonAktif()->paginate(15)->withQueryString(),
            'rumdinReject'=>sewaRumahDinas::countReject(),
            'rumdinUsulan'=>sewaRumahDinas::countUsulan(),
            'rumdinPenghentian'=>sewaRumahDinas::countPenghentian(),
            'pageTitle'=>'Sewa Rumah Dinas',
        ]);
    }

    public function detail($kdsatker){
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        return view('rumah-dinas.monitoring_nonaktif.detail',[
            'data'=>sewaRumahDinas::MonitorinNonAktifDetail($kdsatker)->paginate(15)->withQueryString(),
            'rumdinReject'=>sewaRumahDinas::countReject(),
            'rumdinUsulan'=>sewaRumahDinas::countUsulan(),
            'rumdinPenghentian'=>sewaRumahDinas::countPenghentian(),
            'pageTitle'=>'Sewa Rumah Dinas',
        ]);
    }

    public function dokumen(sewaRumahDinas $sewaRumahDinas)
    {   
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        return response()->file(Storage::path($sewaRumahDinas->file),[
            'Content-Type' => 'application/pdf',
        ]);
    }
}
