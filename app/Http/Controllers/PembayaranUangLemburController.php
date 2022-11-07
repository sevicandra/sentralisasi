<?php

namespace App\Http\Controllers;

use App\Models\bulan;
use Illuminate\Http\Request;
use App\Models\dokumenUangLembur;
use Illuminate\Support\Facades\Storage;

class PembayaranUangLemburController extends Controller
{
    public function index($thn = null)
    {
        if (!$thn) {
            $thn = date('Y');
        }
        $kdsatker= 411792;
        $data = dokumenUangLembur::uangLembur($kdsatker, $thn)->get();
        $tahun = dokumenUangLembur::tahun(411792);
        return view('Pembayaran.Uang_lembur.index',[
            'data'=>$data,
            'tahun'=>$tahun,
            'thn'=>$thn,
            "pageTitle"=>"Dokumen Uang Lembur",
        ]);
    }

    public function create()
    {
        return view('Pembayaran.Uang_lembur.create',[
            'bulan'=>bulan::orderBy('bulan')->get()  
        ]);
    }

    public function store(Request $request)
    {
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
            'kdsatker'=>411792,
            'file'=>$path,
            'nmbulan'=>$nmbulan
        ]);
        return Redirect('/pembayaran/uang-lembur/index')->with('berhasil', 'data berhasil ditambahkan');
    }

    public function edit(dokumenUangLembur $dokumenUangLembur)
    {
        if ($dokumenUangLembur->terkirim) {
            return abort(403);
        }
        return view('Pembayaran.Uang_lembur.edit',[
            'data'=>$dokumenUangLembur,
            'bulan'=>bulan::orderBy('bulan')->get()
        ]);
    }

    public function update(Request $request, dokumenUangLembur $dokumenUangLembur)
    {
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
        return Redirect('/pembayaran/uang-lembur/index')->with('berhasil', 'data berhasil di ubah');
    }

    public function delete(dokumenUangLembur $dokumenUangLembur)
    {
        if ($dokumenUangLembur->terkirim) {
            return abort(403);
        }
        Storage::delete($dokumenUangLembur->file);
        $dokumenUangLembur->delete();
        return Redirect('/pembayaran/uang-lembur/index')->with('berhasil', 'data berhasil di hapus');
    }

    public function kirim(dokumenUangLembur $dokumenUangLembur)
    {
        if ($dokumenUangLembur->terkirim) {
            return abort(403);
        }
        $dokumenUangLembur->update([
            'terkirim'=>true
        ]);
        return Redirect('/pembayaran/uang-lembur/index')->with('berhasil', 'data berhasil di kirim');
    }
}
