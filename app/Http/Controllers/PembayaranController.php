<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\dokumenUangMakan;
use App\Models\dokumenUangLembur;

class PembayaranController extends Controller
{
    public function index($thn = null)
    {
        if(!$thn){
            $thn = date('Y');
        }
        $kdsatker=411792;
        $tahunum = dokumenUangMakan::tahun($kdsatker);
        $tahunul = dokumenUangLembur::tahun($kdsatker);

        $um = dokumenUangMakan::uangMakan($kdsatker, $thn)->get();
        $ul = dokumenUangLembur::uangLembur($kdsatker, $thn)->get();

        $thn_merged = (object) array_merge(
            (array) $tahunum, (array) $tahunul);
        return view('pembayaran.index',[
            'tahun'=>collect($thn_merged)->unique()->sortDesc(),
            'uangMakan'=>$um,
            'uangLembur'=>$ul,
            'thn'=>$thn
        ]);
    }

    public function detailUM($thn, $bln)
    {
        $kdsatker=411792;
        $data = dokumenUangMakan::uangMakan($kdsatker, $thn, $bln)->get();
        return view('pembayaran.detail',[
            'data'=>$data,
            'thn'=>$thn
        ]);
    }

    public function detailUL($thn, $bln)
    {
        $kdsatker=411792;
        $data = dokumenUangLembur::uangLembur($kdsatker, $thn, $bln)->get();
        return view('pembayaran.detail',[
            'data'=>$data,
            'thn'=>$thn
        ]);
    }
}
