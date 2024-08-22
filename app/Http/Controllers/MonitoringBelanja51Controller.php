<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermohonanBelanja51;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class MonitoringBelanja51Controller extends Controller
{
    public function index()
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        
        return view('belanja-51-monitoring.index',[
            'pageTitle' => 'Monitoring Belanja 51',
            'permohonanMakanPusat' =>PermohonanBelanja51::permohonanMakanPusat()->count(),
            'permohonanMakanVertikal' =>PermohonanBelanja51::permohonanMakan()->count(),
            'permohonanLemburPusat' =>PermohonanBelanja51::permohonanLemburPusat()->count(),
            'permohonanLemburVertikal' =>PermohonanBelanja51::permohonanLembur()->count()
        ]);
    }
}
