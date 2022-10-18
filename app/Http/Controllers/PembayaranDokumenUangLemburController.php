<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PembayaranDokumenUangLemburController extends Controller
{
    public function index()
    {
        return view('pembayaran.dokumen_uang_lembur.index');
    }

    public function detail()
    {
        return view('pembayaran.dokumen_uang_lembur.detail');
    }
}
