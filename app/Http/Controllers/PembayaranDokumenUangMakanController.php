<?php

namespace App\Http\Controllers;

use App\Models\satker;
use App\Models\dokumenUangMakan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PembayaranDokumenUangMakanController extends Controller
{
    public function index($thn=null, $bln=null)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if (!$thn) {
            $thn=date('Y');
        }

        if (!$bln) {
            $bln=date('m');
        }
        $tahun = dokumenUangMakan::tahun();
        $bulan = dokumenUangMakan::bulan($thn);
        return view('pembayaran.dokumen_uang_makan.index',[
            'data'=>satker::orderBy('jnssatker')->get(),
            'thn'=>$thn,
            'bln'=>$bln,
            'tahun'=>$tahun,
            'bulan'=>$bulan,
            "pageTitle"=>"Dokumen Uang Makan",
        ]);
    }

    public function detail($kdsatker, $thn, $bln)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $data = dokumenUangMakan::uangMakan($kdsatker, $thn, $bln)->get();
        return view('pembayaran.dokumen_uang_makan.detail',[
            'data'=>$data,
            'thn'=>$thn,
            'bln'=>$bln,
        ]);
    }

    public function reject(dokumenUangMakan $dokumenUangMakan)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if (!$dokumenUangMakan->terkirim) {
            return abort(403);
        }
        $dokumenUangMakan->update(['terkirim'=>false]);
        return Redirect()->back()->with('berhasil', 'Data berhasil dikembalikan.');
    }

    public function dokumen(dokumenUangMakan $dokumenUangMakan)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        
        return response()->file(Storage::path($dokumenUangMakan->file),[
            'Content-Type' => 'application/pdf',
        ]);

    }
}
