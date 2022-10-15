<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spipu\Html2Pdf\Html2Pdf;

class MonitoringRincianController extends Controller
{

    public function index()
    {
        return view('monitoring.rincian.index');
    }

    public function penghasilan()
    {
        return view('monitoring.rincian.penghasilan.index');
    }

    public function gaji()
    {
        return view('monitoring.rincian.gaji');
    }

    public function uang_makan()
    {
        return view('monitoring.rincian.uang_makan');
    }

    public function uang_lembur()
    {
        return view('monitoring.rincian.uang_lembur');
    }

    public function tunjangan_kinerja()
    {
        return view('monitoring.rincian.tunjangan_kinerja');
    }

    public function lainnya()
    {
        return view('monitoring.rincian.lainnya.index');
    }

    public function lainnya_detail()
    {
        return view('monitoring.rincian.lainnya.detail');
    }

    public function penghasilan_daftar()
    {
        ob_start();
        $html = ob_get_clean();
        $html2pdf = new Html2Pdf('L', 'A4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('Daftar Gaji');
        $html2pdf->writeHTML(view('monitoring.rincian.penghasilan.daftar'));
        $html2pdf->output('daftar-gaji-' . "januari" . "2022" . '.pdf', 'D');
    }

    public function penghasilan_surat()
    {
        ob_start();
        $html = ob_get_clean();
        $html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('SKP');
        $html2pdf->writeHTML(view('monitoring.rincian.penghasilan.surat'));
        $html2pdf->output('skp-' . "januari" . "2022" . '.pdf', 'D');
    }
}
