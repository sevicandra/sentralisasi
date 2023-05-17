<?php

namespace App\Http\Controllers;

use App\Models\dataHonorarium;
use App\Models\dataPembayaranLainnya;
use App\Models\dokumenUangMakan;
use App\Models\dokumenUangLembur;

class HomeController extends Controller
{
    public function index()
    {   
        return view('index',[
            'uangLemburKirim'=>dokumenUangLembur::send(),
            'uangMakanKirim'=>dokumenUangMakan::send(),
            'uangLemburDraft'=>dokumenUangLembur::draft(),
            'uangMakanDraft'=>dokumenUangMakan::draft(),
            'honorariumDraft'=>dataHonorarium::draft(),
            'honorariumKirim'=>dataHonorarium::send(),
            'dataPembayaranLainnyaDraft'=>dataPembayaranLainnya::draft(),
        ]);
    }
}
