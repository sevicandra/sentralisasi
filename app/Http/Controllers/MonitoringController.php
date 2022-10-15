<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function index()
    {
        return view('monitoring.beranda.index');
    }
    
    public function daftar()
    {
        switch (request('jns')) {
            case 'gaji-rutin':
                return view('monitoring.beranda.gaji_rutin');                
                break;

            case 'kekurangan-gaji':
                return view('monitoring.beranda.kekurangan_gaji');
                break;

            case 'uang-makan':
                return view('monitoring.beranda.uang_makan');
                break;
                
            case 'uang-lembur':
                return view('monitoring.beranda.uang_lembur');
                break;
                
            case 'tukin-rutin':
                return view('monitoring.beranda.tukin_rutin');
                break;
                
            case 'kekurangan-tukin':
                return view('monitoring.beranda.kekurangan_tukin');
                break;
            default:
                return view('monitoring.beranda.gaji_rutin');
                break;
        }
    }
}
