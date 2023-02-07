<?php

namespace App\Http\Controllers;

use App\Models\dokumenUangMakan;
use App\Models\dokumenUangLembur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    public function index($thn = null)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_belanja_51'];
            $gate2=['sys_admin'];
        }else{
            $gate=['admin_satker'];
            $gate2=[];

        }

        if (! Gate::any($gate, auth()->user()->id)) {
            if (! Gate::any($gate2, auth()->user()->id)) {
                abort(403);
            }
            return Redirect('/belanja-51/dokumen-uang-makan');
        }
        if(!$thn){
            $thn = date('Y');
        }
        $kdsatker=auth()->user()->kdsatker;
        $tahunum = dokumenUangMakan::tahun($kdsatker);
        $tahunul = dokumenUangLembur::tahun($kdsatker);

        $um = dokumenUangMakan::uangMakan($kdsatker, $thn)->get();
        $ul = dokumenUangLembur::uangLembur($kdsatker, $thn)->get();

        $thn_merged = (object) array_merge(
            (array) $tahunum, (array) $tahunul);
        return view('pembayaran.index',[
            'tahun'=>collect($thn_merged)->unique()->sortDesc(),
            'uangMakan'=>$um,
            'uangLembur'=>$ul,
            'thn'=>$thn
        ]);
    }

    public function detailUM($thn, $bln)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_belanja_51'];
            $gate2=['sys_admin'];
        }else{
            $gate=['admin_satker'];
            $gate2=[];

        }

        if (! Gate::any($gate, auth()->user()->id)) {
            if (! Gate::any($gate2, auth()->user()->id)) {
                abort(403);
            }
            return Redirect('/belanja-51/dokumen-uang-makan');
        }
        $kdsatker=auth()->user()->kdsatker;
        $data = dokumenUangMakan::uangMakan($kdsatker, $thn, $bln)->get();
        return view('pembayaran.detail',[
            'data'=>$data,
            'thn'=>$thn,
            'jns'=>'uang-makan'
        ]);
    }

    public function detailUL($thn, $bln)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_belanja_51'];
            $gate2=['sys_admin'];
        }else{
            $gate=['admin_satker'];
            $gate2=[];

        }

        if (! Gate::any($gate, auth()->user()->id)) {
            if (! Gate::any($gate2, auth()->user()->id)) {
                abort(403);
            }
            return Redirect('/monitoring/dokumen-uang-makan');
        }
        $kdsatker=auth()->user()->kdsatker;
        $data = dokumenUangLembur::uangLembur($kdsatker, $thn, $bln)->get();
        return view('pembayaran.detail',[
            'data'=>$data,
            'thn'=>$thn,
            'jns'=>'uang-lembur'
        ]);
    }

    public function dokumenUM(dokumenUangMakan $um)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_belanja_51'];
            $gate2=['sys_admin'];
        }else{
            $gate=['admin_satker'];
            $gate2=[];

        }

        if (! Gate::any($gate, auth()->user()->id)) {
            if (! Gate::any($gate2, auth()->user()->id)) {
                abort(403);
            }
            return Redirect('/belanja-51/dokumen-uang-makan');
        }

        if ($um->kdsatker != auth()->user()->kdsatker) {
            abort(403);
        }
        
        return response()->file(Storage::path($um->file),[
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function dokumenUL(dokumenUangLembur $ul)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_belanja_51'];
            $gate2=['sys_admin'];
        }else{
            $gate=['admin_satker'];
            $gate2=[];

        }

        if (! Gate::any($gate, auth()->user()->id)) {
            if (! Gate::any($gate2, auth()->user()->id)) {
                abort(403);
            }
            return Redirect('/monitoring/dokumen-uang-makan');
        }

        if ($ul->kdsatker != auth()->user()->kdsatker) {
            abort(403);
        }
        
        return response()->file(Storage::path($ul->file),[
            'Content-Type' => 'application/pdf',
        ]);

    }
}
