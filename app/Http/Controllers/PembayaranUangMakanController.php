<?php

namespace App\Http\Controllers;

use App\Models\bulan;
use Illuminate\Http\Request;
use App\Models\dokumenUangMakan;
use Illuminate\Support\Facades\Storage;

class PembayaranUangMakanController extends Controller
{
    public function index($thn = null)
    {
        if (!$thn) {
            $thn = date('Y');
        }
        $kdsatker= 411792;
        $data = dokumenUangMakan::uangMakan($kdsatker, $thn)->get();
        $tahun = dokumenUangMakan::tahun(411792);
        return view('Pembayaran.Uang_makan.index',[
            'data'=>$data,
            'tahun'=>$tahun,
            'thn'=>$thn,
            "pageTitle"=>"Dokumen Uang Lembur",
        ]);
    }

    public function create()
    {
        return view('Pembayaran.Uang_makan.create',[
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
        $path = $request->file('file')->store('uang-makan');
        $nmbulan = bulan::nmBulan($request->bulan);
        dokumenUangMakan::create([
            'tahun'=>date('Y'),
            'bulan'=>$request->bulan,
            'jmlpegawai'=>$request->jmlpegawai,
            'keterangan'=>$request->keterangan,
            'kdsatker'=>411792,
            'file'=>$path,
            'nmbulan'=>$nmbulan
        ]);
        return Redirect('/pembayaran/uang-makan/index')->with('berhasil', 'data berhasil ditambahkan');
    }

    public function edit(dokumenUangMakan $dokumenUangMakan)
    {
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
        return Redirect('/pembayaran/uang-makan/index')->with('berhasil', 'data berhasil di ubah');
    }

    public function delete(dokumenUangMakan $dokumenUangMakan)
    {
        if ($dokumenUangMakan->terkirim) {
            return abort(403);
        }
        Storage::delete($dokumenUangMakan->file);
        $dokumenUangMakan->delete();
        return Redirect('/pembayaran/uang-makan/index')->with('berhasil', 'data berhasil di hapus');
    }

    public function kirim(dokumenUangMakan $dokumenUangMakan)
    {
        if ($dokumenUangMakan->terkirim) {
            return abort(403);
        }
        $dokumenUangMakan->update([
            'terkirim'=>true
        ]);
        return Redirect('/pembayaran/uang-makan/index')->with('berhasil', 'data berhasil di kirim');
    }
}
