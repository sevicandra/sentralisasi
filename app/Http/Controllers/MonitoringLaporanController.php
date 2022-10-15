<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spipu\Html2Pdf\Html2Pdf;

class MonitoringLaporanController extends Controller
{
    public function index()
    {
        return view('monitoring.laporan.index');
    }
    
    public function profil()
    {
        return view('monitoring.laporan.profil.index');
    }

    public function pph_pasal_21()
    {
        return view('monitoring.laporan.pph_pasal_21.index');
    }

    public function pph_pasal_21_final()
    {
        return view('monitoring.laporan.pph_pasal_21_final.index');
    }

    public function penghasilan_tahunan()
    {
        return view('monitoring.laporan.penghasilan_tahunan.index');
    }

    public function profil_kp4()
    {
        ob_start();
        $html = ob_get_clean();

        $html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', array(20, 10, 20, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('KP4');
        $html2pdf->writeHTML(view('monitoring.laporan.profil.kp4'));
        $html2pdf->output('kp4-' . 199606202018011002 . '.pdf', 'D');
    }

    public function pph_pasal_21_cetak()
    {
        ob_start();
        $html = ob_get_clean();

        $html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('Form 1721-A2');
        $html2pdf->writeHTML(view('monitoring.laporan.pph_pasal_21.cetak'));
        $html2pdf->output('1721A2-' . 199606202018011002 . '.pdf', 'D');
    }

    public function pph_pasal_21_final_cetak()
    {
        ob_start();
        $html = ob_get_clean();

        $html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('Form 1721-VII');
        $html2pdf->writeHTML(view('monitoring.laporan.pph_pasal_21_final.cetak'));
        $html2pdf->output('1721VII-' . 199606202018011002 . '.pdf', 'D');
    }

    public function penghasilan_tahunan_daftar()
    {
        return view('monitoring.laporan.penghasilan_tahunan.daftar');
    }

    public function penghasilan_tahunan_surat()
    {
        return view('monitoring.laporan.penghasilan_tahunan.surat');
    }
}
