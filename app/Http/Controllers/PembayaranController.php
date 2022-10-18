<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        return view('pembayaran.index');
    }

    public function detail()
    {
        return view('pembayaran.detail');
    }
}
