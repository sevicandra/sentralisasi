<?php

namespace App\Http\Controllers;

use App\Models\dataHonorarium;
use App\Models\sewaRumahDinas;
use App\Models\dokumenUangMakan;
use App\Models\dokumenUangLembur;
use App\Models\NotifikasiBelanja51;
use App\Models\PermohonanBelanja51;
use App\Models\dataPembayaranLainnya;

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
            'rumdinReject'=>sewaRumahDinas::countReject(),
            'rumdinUsulan'=>sewaRumahDinas::countUsulan(),
            'rumdinPenghentian'=>sewaRumahDinas::countPenghentian(),
            'permohonanMakanPusat' =>PermohonanBelanja51::permohonanMakanPusat()->count(),
            'permohonanMakanVertikal' =>PermohonanBelanja51::permohonanMakan()->count(),
            'permohonanLemburPusat' =>PermohonanBelanja51::permohonanLemburPusat()->count(),
            'permohonanLemburVertikal' =>PermohonanBelanja51::permohonanLembur()->count(),
            'notifBelanja51TolakVertikal' =>NotifikasiBelanja51::NotifikasiVertikal(auth()->user()->kdsatker),
            'notifBelanja51TolakPusat' =>NotifikasiBelanja51::NotifikasiVertikal(auth()->user()->kdsatker, auth()->user()->kdunit),
        ]);
    }
}
