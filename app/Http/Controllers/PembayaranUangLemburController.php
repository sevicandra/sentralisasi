<?php

namespace App\Http\Controllers;

use App\Models\bulan;
use Illuminate\Http\Request;
use App\Models\dokumenUangMakan;
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
            'uangLemburKirim'=>dokumenUangLembur::send(),
            'uangMakanKirim'=>dokumenUangMakan::send(),
            'uangLemburDraft'=>dokumenUangLembur::draft(),
            'uangMakanDraft'=>dokumenUangMakan::draft(),
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
            'uangLemburKirim'=>dokumenUangLembur::send(),
            'uangMakanKirim'=>dokumenUangMakan::send(),
            'uangLemburDraft'=>dokumenUangLembur::draft(),
            'uangMakanDraft'=>dokumenUangMakan::draft(),
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
            'bulan'=>'required|numeric',
            'jmlpegawai'=>'required|numeric',
            'keterangan'=>'required',
            'tahun'=>'required|max_digits:4|min_digits:4',
            'file'=>'mimetypes:application/pdf|file|max:10240'
        ],[
            'bulan.required'=>'bulan wajib di isi.',
            'jmlpegawai.required'=>'jumlah pegawai wajib di isi.',
            'jmlpegawai.numeric'=>'jumlah pegawai harus berupa angka.',
            'keterangan.required'=>'keterangan wajib di isi.',
            'tahun.required'=>'tahun wajib di isi.',
            'tahun.max_digits'=>'tahun harus 4 karakter',
            'tahun.min_digits'=>'tahun harus 4 karakter',
            'tahun.required'=>'tahun wajib di isi.',
            'file.required'=>'file wajib di isi.',
            'file.mimetypes'=>'file harus berupa pdf.',
            'file.max'=>'ukuran maksimal file 10MB',
        ]);

        if ($request->tahun === date('Y')) {
            $max = date('m')-1;
            $request->validate([
                'bulan'=>"numeric|max:$max"
            ],[
                'bulan.max'=>'periode pembayaran belum di buka'
            ]);
        }elseif($request->tahun > date('Y')){
            $max_tahun=date('Y');
            $max_bulan=0;
            $request->validate([
                'tahun'=>"numeric|max:$max_tahun",
                'bulan'=>"numeric|max:$max_bulan"
            ],[
                'tahun.max'=>'periode pembayaran belum di buka',
                'bulan.max'=>'periode pembayaran belum di buka'
            ]);
        }

        $path = $request->file('file')->store('uang-lembur');
        $nmbulan = bulan::nmBulan($request->bulan);
        dokumenUangLembur::create([
            'tahun'=>$request->tahun,
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
            'uangLemburKirim'=>dokumenUangLembur::send(),
            'uangMakanKirim'=>dokumenUangMakan::send(),
            'uangLemburDraft'=>dokumenUangLembur::draft(),
            'uangMakanDraft'=>dokumenUangMakan::draft(),
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
                'bulan'=>'required|numeric',
                'jmlpegawai'=>'required|numeric',
                'keterangan'=>'required',
                'tahun'=>'required|max_digits:4|min_digits:4',
                'file'=>'mimetypes:application/pdf|file|max:10240'
            ],[
            'bulan.required'=>'bulan wajib di isi.',
            'jmlpegawai.required'=>'jumlah pegawai wajib di isi.',
            'jmlpegawai.numeric'=>'jumlah pegawai harus berupa angka.',
            'keterangan.required'=>'keterangan wajib di isi.',
            'tahun.required'=>'tahun wajib di isi.',
            'tahun.max_digits'=>'tahun harus 4 karakter',
            'tahun.min_digits'=>'tahun harus 4 karakter',
            'tahun.required'=>'tahun wajib di isi.',
            'file.required'=>'file wajib di isi.',
            'file.mimetypes'=>'file harus berupa pdf.',
            'file.max'=>'ukuran maksimal file 10MB',
        ]);

        if ($request->tahun === date('Y')) {
            $max = date('m')-1;
            $request->validate([
                'bulan'=>"numeric|max:$max"
            ],[
                'bulan.max'=>'periode pembayaran belum di buka'
            ]);
        }elseif($request->tahun > date('Y')){
            $max_tahun=date('Y');
            $max_bulan=0;
            $request->validate([
                'tahun'=>"numeric|max:$max_tahun",
                'bulan'=>"numeric|max:$max_bulan"
            ],[
                'tahun.max'=>'periode pembayaran belum di buka',
                'bulan.max'=>'periode pembayaran belum di buka'
            ]);
        }
            $path = $request->file('file')->store('uang-lembur');
            $oldfile=$dokumenUangLembur->file;
            $nmbulan = bulan::nmBulan($request->bulan);
            $dokumenUangLembur->update([
                'bulan'=>$request->bulan,
                'tahun'=>$request->tahun,
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
                'tahun'=>'required|max_digits:4|min_digits:4',
            ],[
                'bulan.required'=>'bulan wajib di isi.',
                'jmlpegawai.required'=>'jumlah pegawai wajib di isi.',
                'jmlpegawai.numeric'=>'jumlah pegawai harus berupa angka.',
                'keterangan.required'=>'keterangan wajib di isi.',
                'tahun.required'=>'tahun wajib di isi.',
                'tahun.max_digits'=>'tahun harus 4 karakter',
                'tahun.min_digits'=>'tahun harus 4 karakter',
                'tahun.required'=>'tahun wajib di isi.',
                'file.required'=>'file wajib di isi.',
                'file.mimetypes'=>'file harus berupa pdf.',
                'file.max'=>'ukuran maksimal file 10MB',
            ]);
            $nmbulan = bulan::nmBulan($request->bulan);
            $dokumenUangLembur->update([
                'bulan'=>$request->bulan,
                'tahun'=>$request->tahun,
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

    public function dokumen(dokumenUangLembur $dokumenUangLembur)
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

        if ($dokumenUangLembur->kdsatker != auth()->user()->kdsatker) {
            abort(403);
        }
        
        return response()->file(Storage::path($dokumenUangLembur->file),[
            'Content-Type' => 'application/pdf',
        ]);

    }
}
