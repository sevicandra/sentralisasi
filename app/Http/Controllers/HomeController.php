<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\dokumenUangMakan;
use App\Models\dokumenUangLembur;

class HomeController extends Controller
{
    public function index()
    {   
        return view('index',[
            'uangLemburKirim'=>dokumenUangLembur::send(),
            'uangMakanKirim'=>dokumenUangMakan::send()
        ]);
    }
}
