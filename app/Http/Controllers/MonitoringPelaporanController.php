<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonitoringPelaporanController extends Controller
{
    public function index()
    {
        return view('monitoring.pelaporan.index');
    }

    public function satker()
    {
        return view('monitoring.laporan.index',[
            "pageTitle"=>"Laporan"
        ]);
    }
    
    public function satker_profil()
    {
        return view('monitoring.laporan.profil.index',[
            "pageTitle"=>"Profil"
        ]);
    }

    public function satker_pph_pasal_21()
    {
        return view('monitoring.laporan.pph_pasal_21.index',[
            "pageTitle"=>"PPh Pasal 21"
        ]);
    }

    public function satker_pph_pasal_21_final()
    {
        return view('monitoring.laporan.pph_pasal_21_final.index',[
            "pageTitle"=>"PPh Pasal 21 Final"
        ]);
    }

    public function satker_penghasilan_tahunan()
    {
        return view('monitoring.laporan.penghasilan_tahunan.index',[
            "pageTitle"=>"Penghasilan Tahunan"
        ]);
    }

    public function satker_profil_kp4()
    {
        ob_start();
        $html = ob_get_clean();

        $html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', array(20, 10, 20, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('KP4');
        $html2pdf->writeHTML(view('monitoring.laporan.profil.kp4'));
        $html2pdf->output('kp4-' . 199606202018011002 . '.pdf', 'D');
    }

    public function satker_pph_pasal_21_cetak()
    {
        ob_start();
        $html = ob_get_clean();

        $html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('Form 1721-A2');
        $html2pdf->writeHTML(view('monitoring.laporan.pph_pasal_21.cetak'));
        $html2pdf->output('1721A2-' . 199606202018011002 . '.pdf', 'D');
    }

    public function satker_pph_pasal_21_final_cetak()
    {
        ob_start();
        $html = ob_get_clean();

        $html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('Form 1721-VII');
        $html2pdf->writeHTML(view('monitoring.laporan.pph_pasal_21_final.cetak'));
        $html2pdf->output('1721VII-' . 199606202018011002 . '.pdf', 'D');
    }

    public function satker_penghasilan_tahunan_daftar()
    {
        return view('monitoring.laporan.penghasilan_tahunan.daftar');
    }

    public function satker_penghasilan_tahunan_surat()
    {
        return view('monitoring.laporan.penghasilan_tahunan.surat');
    }
}
