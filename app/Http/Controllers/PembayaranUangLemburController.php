<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PembayaranUangLemburController extends Controller
{
    public function index()
    {
        return view('Pembayaran.Uang_lembur.index');
    }

    public function create()
    {
        return view('Pembayaran.Uang_lembur.create');
    }

    public function store()
    {
        return Redirect('/pembayaran/uang-lembur')->with('berhasil', 'data berhasil ditambahkan');
    }

    public function edit()
    {
        return view('Pembayaran.Uang_lembur.edit');
    }

    public function update()
    {
        return Redirect('/pembayaran/uang-lembur')->with('berhasil', 'data berhasil di ubah');
    }
}
