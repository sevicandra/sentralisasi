<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function index()
    {
        return view('monitoring.beranda.index',[
            'pageTitle'=> 'Beranda'
        ]);
    }
    
    public function detail()
    {
        switch (request('jns')) {
            case 'gaji-rutin':
                return view('monitoring.beranda.detail.gaji_rutin',[
                    'pageTitle'=> 'Detail Gaji Rutin'
                ]);                
                break;

            case 'kekurangan-gaji':
                return view('monitoring.beranda.detail.kekurangan_gaji',[
                    'pageTitle'=> 'Detail Kekurangan Gaji'
                ]);
                break;

            case 'uang-makan':
                return view('monitoring.beranda.detail.uang_makan',[
                    'pageTitle'=> 'Detail Uang Makan'
                ]);
                break;
                
            case 'uang-lembur':
                return view('monitoring.beranda.detail.uang_lembur',[
                    'pageTitle'=> 'Detail Uang Lembur'
                ]);
                break;
                
            case 'tukin-rutin':
                return view('monitoring.beranda.detail.tukin_rutin',[
                    'pageTitle'=> 'Detail Tukin Rutin'
                ]);
                break;
                
            case 'kekurangan-tukin':
                return view('monitoring.beranda.detail.kekurangan_tukin',[
                    'pageTitle'=> 'Detail Kekurangan Tukin'
                ]);
                break;
            default:
                return view('monitoring.beranda.detail.gaji_rutin',[
                    'pageTitle'=> 'Detail Gaji Rutin'
                ]);
                break;
        }
    }
}
