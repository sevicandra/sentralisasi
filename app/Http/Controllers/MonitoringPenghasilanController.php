<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spipu\Html2Pdf\Html2Pdf;

class MonitoringPenghasilanController extends Controller
{
    public function index()
    {
        return view('monitoring.penghasilan.index',[
            'pageTitle'=>'Penghasilan'
        ]);
    }

    public function satker()
    {
        return view('monitoring.rincian.index');
    }

    public function satker_penghasilan()
    {
        return view('monitoring.rincian.penghasilan.index',[
            "pageTitle"=>"Penghasilan"
        ]);
    }

    public function satker_gaji()
    {
        return view('monitoring.rincian.gaji',[
            "pageTitle"=>"Gaji"
        ]);
    }

    public function satker_uang_makan()
    {
        return view('monitoring.rincian.uang_makan',[
            "pageTitle"=>"Uang Makan"
        ]);
    }

    public function satker_uang_lembur()
    {
        return view('monitoring.rincian.uang_lembur',[
            "pageTitle"=>"Uang Lembur"
        ]);
    }

    public function satker_tunjangan_kinerja()
    {
        return view('monitoring.rincian.tunjangan_kinerja',[
            "pageTitle"=>"Tunjangan Kinerja"
        ]);
    }

    public function satker_lainnya()
    {
        return view('monitoring.rincian.lainnya.index',[
            "pageTitle"=>"Lainnya"
        ]);
    }

    public function satker_lainnya_detail()
    {
        return view('monitoring.rincian.lainnya.detail',[
            "pageTitle"=>"Detail"
        ]);
    }

    public function satker_penghasilan_daftar()
    {
        ob_start();
        $html = ob_get_clean();
        $html2pdf = new Html2Pdf('L', 'A4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('Daftar Gaji');
        $html2pdf->writeHTML(view('monitoring.rincian.penghasilan.daftar'));
        $html2pdf->output('daftar-gaji-' . "januari" . "2022" . '.pdf', 'D');
    }

    public function satker_penghasilan_surat()
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
