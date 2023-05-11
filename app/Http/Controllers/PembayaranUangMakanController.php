<?php

namespace App\Http\Controllers;

use App\Models\bulan;
use Illuminate\Http\Request;
use App\Models\dokumenUangMakan;
use App\Models\dokumenUangLembur;
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
        return view('Pembayaran.Uang_makan.create',[
            'bulan'=>bulan::orderBy('bulan')->get(),
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

        $path = $request->file('file')->store('uang-makan');
        $nmbulan = bulan::nmBulan($request->bulan);
        dokumenUangMakan::create([
            'tahun'=>$request->tahun,
            'bulan'=>$request->bulan,
            'jmlpegawai'=>$request->jmlpegawai,
            'keterangan'=>$request->keterangan,
            'kdsatker'=>auth()->user()->kdsatker,
            'file'=>$path,
            'nmbulan'=>$nmbulan
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
            'bulan'=>bulan::orderBy('bulan')->get(),
            'uangLemburKirim'=>dokumenUangLembur::send(),
            'uangMakanKirim'=>dokumenUangMakan::send(),
            'uangLemburDraft'=>dokumenUangLembur::draft(),
            'uangMakanDraft'=>dokumenUangMakan::draft(),
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

            $path = $request->file('file')->store('uang-makan');
            $oldfile=$dokumenUangMakan->file;
            $nmbulan = bulan::nmBulan($request->bulan);
            $dokumenUangMakan->update([
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
                'tahun'=>'required|max_digits:4|min_digits:4',
                'keterangan'=>'required',
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
            $dokumenUangMakan->update([
                'bulan'=>$request->bulan,
                'tahun'=>$request->tahun,
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

    public function dokumen(dokumenUangMakan $dokumenUangMakan)
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
        
        return response()->file(Storage::path($dokumenUangMakan->file),[
            'Content-Type' => 'application/pdf',
        ]);
    }
}
