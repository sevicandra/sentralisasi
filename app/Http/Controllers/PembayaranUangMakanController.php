<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PembayaranUangMakanController extends Controller
{
    public function index()
    {
        return view('Pembayaran.Uang_makan.index');
    }

    public function create()
    {
        return view('Pembayaran.Uang_makan.create');
    }

    public function store()
    {
        return Redirect('/pembayaran/uang-makan')->with('berhasil', 'data berhasil ditambahkan');
    }

    public function edit()
    {
        return view('Pembayaran.Uang_makan.edit');
    }

    public function update()
    {
        return Redirect('/pembayaran/uang-makan')->with('berhasil', 'data berhasil di ubah');
    }
}
