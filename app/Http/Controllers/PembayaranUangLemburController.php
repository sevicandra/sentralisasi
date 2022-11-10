<?php

namespace App\Http\Controllers;

use App\Models\bulan;
use Illuminate\Http\Request;
use App\Models\dokumenUangLembur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PembayaranUangLemburController extends Controller
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
        if (!$thn) {
            $thn = date('Y');
        }
        $kdsatker= auth()->user()->kdsatker;
        $data = dokumenUangLembur::uangLembur($kdsatker, $thn)->get();
        $tahun = dokumenUangLembur::tahun($kdsatker);
        return view('Pembayaran.Uang_lembur.index',[
            'data'=>$data,
            'tahun'=>$tahun,
            'thn'=>$thn,
            "pageTitle"=>"Uang Lembur",
        ]);
    }

    public function create()
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
        return view('Pembayaran.Uang_lembur.create',[
            'bulan'=>bulan::orderBy('bulan')->get(),
            "pageTitle"=>"Uang Lembur",
        ]);
    }

    public function store(Request $request)
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
        
        $request->validate([
            'bulan'=>'required',
            'jmlpegawai'=>'required|numeric',
            'keterangan'=>'required',
            'file'=>'mimetypes:application/pdf|file|max:10240'
        ]);
        $path = $request->file('file')->store('uang-lembur');
        $nmbulan = bulan::nmBulan($request->bulan);
        dokumenUangLembur::create([
            'tahun'=>date('Y'),
            'bulan'=>$request->bulan,
            'jmlpegawai'=>$request->jmlpegawai,
            'keterangan'=>$request->keterangan,
            'kdsatker'=>auth()->user()->kdsatker,
            'file'=>$path,
            'nmbulan'=>$nmbulan,
            "pageTitle"=>"Uang Lembur",
        ]);
        return Redirect('/belanja-51/uang-lembur/index')->with('berhasil', 'data berhasil ditambahkan');
    }

    public function edit(dokumenUangLembur $dokumenUangLembur)
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
        if ($dokumenUangLembur->kdsatker != auth()->user()->kdsatker) {
            abort(403);
        }
        if ($dokumenUangLembur->terkirim) {
            return abort(403);
        }
        return view('Pembayaran.Uang_lembur.edit',[
            'data'=>$dokumenUangLembur,
            'bulan'=>bulan::orderBy('bulan')->get(),
            "pageTitle"=>"Uang Lembur",
        ]);
    }

    public function update(Request $request, dokumenUangLembur $dokumenUangLembur)
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
        if ($dokumenUangLembur->kdsatker != auth()->user()->kdsatker) {
            abort(403);
        }
        if ($dokumenUangLembur->terkirim) {
            return abort(403);
        }
        if ($request->file) {
            $request->validate([
                'bulan'=>'required',
                'jmlpegawai'=>'required|numeric',
                'keterangan'=>'required',
                'file'=>'mimetypes:application/pdf|file|max:10240'
            ]);
            $path = $request->file('file')->store('uang-lembur');
            $oldfile=$dokumenUangLembur->file;
            $nmbulan = bulan::nmBulan($request->bulan);
            $dokumenUangLembur->update([
                'bulan'=>$request->bulan,
                'jmlpegawai'=>$request->jmlpegawai,
                'keterangan'=>$request->keterangan,
                'file'=>$path,
                'nmbulan'=>$nmbulan
            ]);

            Storage::delete($oldfile);
        }else{
            $request->validate([
                'bulan'=>'required',
                'jmlpegawai'=>'required|numeric',
                'keterangan'=>'required',
            ]);
            $nmbulan = bulan::nmBulan($request->bulan);
            $dokumenUangLembur->update([
                'bulan'=>$request->bulan,
                'jmlpegawai'=>$request->jmlpegawai,
                'keterangan'=>$request->keterangan,
                'nmbulan'=>$nmbulan
            ]);
        }
        return Redirect('/belanja-51/uang-lembur/index')->with('berhasil', 'data berhasil di ubah');
    }

    public function delete(dokumenUangLembur $dokumenUangLembur)
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
        if ($dokumenUangLembur->kdsatker != auth()->user()->kdsatker) {
            abort(403);
        }
        if ($dokumenUangLembur->terkirim) {
            return abort(403);
        }
        Storage::delete($dokumenUangLembur->file);
        $dokumenUangLembur->delete();
        return Redirect('/belanja-51/uang-lembur/index')->with('berhasil', 'data berhasil di hapus');
    }

    public function kirim(dokumenUangLembur $dokumenUangLembur)
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
        if ($dokumenUangLembur->kdsatker != auth()->user()->kdsatker) {
            abort(403);
        }
        if ($dokumenUangLembur->terkirim) {
            return abort(403);
        }
        $dokumenUangLembur->update([
            'terkirim'=>true
        ]);
        return Redirect('/belanja-51/uang-lembur/index')->with('berhasil', 'data berhasil di kirim');
    }
}
