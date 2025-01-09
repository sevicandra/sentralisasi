<?php

namespace App\Http\Controllers;

use App\Models\satker;
use Illuminate\Http\Request;
use App\Models\dokumenUangMakan;
use App\Models\dokumenUangLembur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PembayaranUangLemburWilayahController extends Controller
{
    public function index($thn=null, $bln=null)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_belanja_51', 'admin_pusat'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id) || ! Gate::any('wilayah', [auth()->user()->kdsatker])) {
            abort(403);
        }

        $tahun = dokumenUangLembur::tahun();
        if (!$thn) {
            $thn=$tahun[0];
        }

        $bulan = dokumenUangLembur::bulan($thn);
        if (!$bln) {
            $bln=end($bulan);
        }
        return view('pembayaran.wilayah.uang_lembur.index',[
            'data'=>satker::vertikal(auth()->user()->kdsatker)->order()->get(),
            'thn'=>$thn,
            'bln'=>$bln,
            'tahun'=>$tahun,
            'bulan'=>$bulan,
            "pageTitle"=>"Dokumen Uang Lembur",
            'uangLemburKirim'=>dokumenUangLembur::send(),
            'uangMakanKirim'=>dokumenUangMakan::send(),
            'uangLemburDraft'=>dokumenUangLembur::draft(),
            'uangMakanDraft'=>dokumenUangMakan::draft(),
        ]);
    }

    public function detail($kdsatker, $thn, $bln)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_belanja_51', 'admin_pusat'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id) || ! Gate::any('wilayah', [auth()->user()->kdsatker]) || ! satker::koordinator($kdsatker, auth()->user()->kdsatker)) {
            abort(403);
        }

        $data = dokumenUangLembur::uangLembur($kdsatker, $thn, $bln)->get();
        return view('pembayaran.wilayah.uang_lembur.detail',[
            'data'=>$data,
            'thn'=>$thn,
            'bln'=>$bln,
            'uangLemburKirim'=>dokumenUangLembur::send(),
            'uangMakanKirim'=>dokumenUangMakan::send(),
            'uangLemburDraft'=>dokumenUangLembur::draft(),
            'uangMakanDraft'=>dokumenUangMakan::draft(),
        ]);
    }

    public function dokumen(dokumenUangLembur $dokumenUangLembur)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_belanja_51', 'admin_pusat'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id) || ! Gate::any('wilayah', [auth()->user()->kdsatker]) || ! satker::koordinator($dokumenUangLembur->kdsatker, auth()->user()->kdsatker)) {
            abort(403);
        }
        
        return response()->file(Storage::path($dokumenUangLembur->file),[
            'Content-Type' => 'application/pdf',
        ]);

    }

    public function dokumen_excel(dokumenUangLembur $dokumenUangLembur)
    {

        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_belanja_51', 'admin_pusat'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id) || ! Gate::any('wilayah', [auth()->user()->kdsatker]) || ! satker::koordinator($dokumenUangLembur->kdsatker, auth()->user()->kdsatker)) {
            abort(403);
        }
        
        $name = $dokumenUangLembur->kdsatker. "-" .$dokumenUangLembur->nmbulan .".". explode('.', $dokumenUangLembur->file_excel)[1];
        return Storage::download($dokumenUangLembur->file_excel, $name);
    }
}
