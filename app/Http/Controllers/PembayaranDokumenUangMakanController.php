<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PembayaranDokumenUangMakanController extends Controller
{
    public function index()
    {
        return view('pembayaran.dokumen_uang_makan.index');
    }

    public function detail()
    {
        return view('pembayaran.dokumen_uang_makan.detail');
    }
}
