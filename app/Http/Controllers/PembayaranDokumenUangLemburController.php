<?php

namespace App\Http\Controllers;

use App\Models\satker;
use Illuminate\Http\Request;

use App\Models\dokumenUangLembur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class PembayaranDokumenUangLemburController extends Controller
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
        $tahun = dokumenUangLembur::tahun();
        $bulan = dokumenUangLembur::bulan($thn);
        return view('pembayaran.dokumen_uang_lembur.index',[
            'data'=>satker::orderBy('jnssatker')->get(),
            'thn'=>$thn,
            'bln'=>$bln,
            'tahun'=>$tahun,
            'bulan'=>$bulan,
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

        $data = dokumenUangLembur::uangLembur($kdsatker, $thn, $bln)->get();

        return view('pembayaran.dokumen_uang_lembur.detail',[
            'data'=>$data,
            'thn'=>$thn,
            'bln'=>$bln,
        ]);
    }

    public function reject(dokumenUangLembur $dokumenUangLembur)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if (!$dokumenUangLembur->terkirim) {
            return abort(403);
        }
        $dokumenUangLembur->update(['terkirim'=>false]);
        return Redirect()->back()->with('berhasil', 'Data berhasil dikembalikan.');
    }

    public function dokumen(dokumenUangLembur $dokumenUangLembur)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        
        return response()->file(Storage::path($dokumenUangLembur->file),[
            'Content-Type' => 'application/pdf',
        ]);

    }
}
