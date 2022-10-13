<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function index()
    {
        return view('monitoring.index');
    }

    public function index_rincian()
    {
        return view('monitoring.rincian.index');
    }

    public function rincian_penghasilan()
    {
        return view('monitoring.rincian.penghasilan');
    }

    public function rincian_gaji()
    {
        return view('monitoring.rincian.gaji');
    }

    public function rincian_uang_makan()
    {
        return view('monitoring.rincian.uang_makan');
    }

    public function rincian_uang_lembur()
    {
        return view('monitoring.rincian.uang_lembur');
    }

    public function rincian_tunjangan_kinerja()
    {
        return view('monitoring.rincian.tunjangan_kinerja');
    }

    public function rincian_lainnya()
    {
        return view('monitoring.rincian.lainnya');
    }
}
