<?php

namespace App\Http\Controllers;

use App\Models\satker;
use Illuminate\Http\Request;
use App\Models\dokumenUangMakan;

class PembayaranDokumenUangMakanController extends Controller
{
    public function index($thn=null, $bln=null)
    {
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
        ]);
    }

    public function detail($thn, $bln)
    {
        $kdsatker=411792;
        $data = dokumenUangMakan::uangMakan($kdsatker, $thn, $bln)->get();
        return view('pembayaran.dokumen_uang_makan.detail',[
            'data'=>$data,
            'thn'=>$thn,
            'bln'=>$bln,
        ]);
    }

    public function reject(dokumenUangMakan $dokumenUangMakan)
    {
        if (!$dokumenUangMakan->terkirim) {
            return abort(403);
        }
        $dokumenUangMakan->update(['terkirim'=>false]);
        return Redirect()->back()->with('berhasil', 'Data berhasil dikembalikan.');
    }
}
