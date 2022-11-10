<?php

namespace App\Http\Controllers;

use App\Models\bulan;
use Illuminate\Http\Request;
use App\Models\dokumenUangMakan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PembayaranUangMakanController extends Controller
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
        $data = dokumenUangMakan::uangMakan($kdsatker, $thn)->get();
        $tahun = dokumenUangMakan::tahun($kdsatker);
        return view('Pembayaran.Uang_makan.index',[
            'data'=>$data,
            'tahun'=>$tahun,
            'thn'=>$thn,
            "pageTitle"=>"Uang Makan",
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
        return view('Pembayaran.Uang_makan.create',[
            'bulan'=>bulan::orderBy('bulan')->get()  
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
        $path = $request->file('file')->store('uang-makan');
        $nmbulan = bulan::nmBulan($request->bulan);
        dokumenUangMakan::create([
            'tahun'=>date('Y'),
            'bulan'=>$request->bulan,
            'jmlpegawai'=>$request->jmlpegawai,
            'keterangan'=>$request->keterangan,
            'kdsatker'=>auth()->user()->kdsatker,
            'file'=>$path,
            'nmbulan'=>$nmbulan
        ]);
        return Redirect('/belanja-51/uang-makan/index')->with('berhasil', 'data berhasil ditambahkan');
    }

    public function edit(dokumenUangMakan $dokumenUangMakan)
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
        if ($dokumenUangMakan->kdsatker != auth()->user()->kdsatker) {
            abort(403);
        }
        if ($dokumenUangMakan->terkirim) {
            return abort(403);
        }
        return view('Pembayaran.Uang_makan.edit',[
            'data'=>$dokumenUangMakan,
            'bulan'=>bulan::orderBy('bulan')->get()
        ]);
    }

    public function update(Request $request, dokumenUangMakan $dokumenUangMakan)
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
        if ($dokumenUangMakan->kdsatker != auth()->user()->kdsatker) {
            abort(403);
        }
        if ($dokumenUangMakan->terkirim) {
            return abort(403);
        }
        if ($request->file) {
            $request->validate([
                'bulan'=>'required',
                'jmlpegawai'=>'required|numeric',
                'keterangan'=>'required',
                'file'=>'mimetypes:application/pdf|file|max:10240'
            ]);
            $path = $request->file('file')->store('uang-makan');
            $oldfile=$dokumenUangMakan->file;
            $nmbulan = bulan::nmBulan($request->bulan);
            $dokumenUangMakan->update([
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
            $dokumenUangMakan->update([
                'bulan'=>$request->bulan,
                'jmlpegawai'=>$request->jmlpegawai,
                'keterangan'=>$request->keterangan,
                'nmbulan'=>$nmbulan
            ]);
        }
        return Redirect('/belanja-51/uang-makan/index')->with('berhasil', 'data berhasil di ubah');
    }

    public function delete(dokumenUangMakan $dokumenUangMakan)
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
        if ($dokumenUangMakan->kdsatker != auth()->user()->kdsatker) {
            abort(403);
        }
        if ($dokumenUangMakan->terkirim) {
            return abort(403);
        }
        Storage::delete($dokumenUangMakan->file);
        $dokumenUangMakan->delete();
        return Redirect('/belanja-51/uang-makan/index')->with('berhasil', 'data berhasil di hapus');
    }

    public function kirim(dokumenUangMakan $dokumenUangMakan)
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
        if ($dokumenUangMakan->kdsatker != auth()->user()->kdsatker) {
            abort(403);
        }
        if ($dokumenUangMakan->terkirim) {
            return abort(403);
        }
        $dokumenUangMakan->update([
            'terkirim'=>true
        ]);
        return Redirect('/belanja-51/uang-makan/index')->with('berhasil', 'data berhasil di kirim');
    }
}
