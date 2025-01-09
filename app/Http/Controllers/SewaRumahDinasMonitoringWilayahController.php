<?php

namespace App\Http\Controllers;

use App\Models\satker;
use Illuminate\Http\Request;
use App\Models\sewaRumahDinas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class SewaRumahDinasMonitoringWilayahController extends Controller
{
    public function index(){
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_belanja_51', 'admin_pusat'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id) || ! Gate::any('wilayah', [auth()->user()->kdsatker])) {
            abort(403);
        }

        return view('rumah-dinas.monitoring_wilayah.index',[
            'data'=>sewaRumahDinas::monitoringWilayah(auth()->user()->kdsatker)->paginate(15)->withQueryString(),
            'rumdinReject'=>sewaRumahDinas::countReject(),
            'rumdinUsulan'=>sewaRumahDinas::countUsulan(),
            'rumdinPenghentian'=>sewaRumahDinas::countPenghentian(),
            'pageTitle'=>'Sewa Rumah Dinas',
        ]);
    }

    public function detail($kdsatker){
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_belanja_51', 'admin_pusat'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id) || ! Gate::any('wilayah', [auth()->user()->kdsatker]) || ! satker::koordinator($kdsatker, auth()->user()->kdsatker)) {
            abort(403);
        }

        return view('rumah-dinas.monitoring_wilayah.detail',[
            'data'=>sewaRumahDinas::monitoringDetail($kdsatker)->paginate(15)->withQueryString(),
            'rumdinReject'=>sewaRumahDinas::countReject(),
            'rumdinUsulan'=>sewaRumahDinas::countUsulan(),
            'rumdinPenghentian'=>sewaRumahDinas::countPenghentian(),
            'pageTitle'=>'Sewa Rumah Dinas',
        ]);
    }

    public function dokumen(sewaRumahDinas $sewaRumahDinas)
    {   
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_belanja_51', 'admin_pusat'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id) || ! Gate::any('wilayah', [auth()->user()->kdsatker]) || ! satker::koordinator($sewaRumahDinas->kdsatker, auth()->user()->kdsatker)) {
            abort(403);
        }
        
        return response()->file(Storage::path($sewaRumahDinas->file),[
            'Content-Type' => 'application/pdf',
        ]);
    }
}
