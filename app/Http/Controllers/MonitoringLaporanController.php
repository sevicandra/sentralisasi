<?php

namespace App\Http\Controllers;

use App\Helper\hris;
use App\Helper\Alika\API3\spt;
use Spipu\Html2Pdf\Html2Pdf;
use App\Helper\Alika\API3\dataLain;
use App\Helper\Alika\API3\dataMakan;
use App\Helper\Alika\API3\dataLembur;
use App\Helper\Alika\API3\detailLain;
use App\Helper\Alika\API3\penghasilan;
use App\Helper\Alika\API3\satkerAlika;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\LengthAwarePaginator;

class MonitoringLaporanController extends Controller
{
    public function index()
    {
        if (Auth::guard('web')->check()) {
            $gate=['opr_monitoring', 'plt_admin_satker'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $pegawai = hris::getPegawaiBySatker(auth()->user()->kdsatker);
        $status = $pegawai->unique('StatusPegawai')->pluck('StatusPegawai');
        $search = request('search');
        if (request('status')) {
            $pegawai_Collection = Collect($pegawai, false)->map(function($data){
                return(object)[
                    'Nama'=>$data->Nama,
                    'Nip18'=>$data->Nip18,
                    'StatusPegawai'=>$data->StatusPegawai,
                    'Grading'=>$data->Grading,
                    'KodeOrganisasi'=>$data->KodeOrganisasi,
                ];
            })->where('StatusPegawai',request('status'))->filter(function ($value) use ($search) {
                foreach ($value as $field) {
                    if (preg_match('/' . $search . '/i', $field)) {
                        return true;
                    }
                }
                return false;
            })->sortBy([['Grading', 'desc'],['KodeoOrganisasi', 'asc']])->values();
        }else{
            $pegawai_Collection = Collect($pegawai, false)->map(function($data){
                return (object)[
                    'Nama'=>$data->Nama,
                    'Nip18'=>$data->Nip18,
                    'StatusPegawai'=>$data->StatusPegawai,
                    'Grading'=>$data->Grading,
                    'KodeOrganisasi'=>$data->KodeOrganisasi,
                ];
            })->where('StatusPegawai','Aktif')->filter(function ($value) use ($search) {
                foreach ($value as $field) {
                    if (preg_match('/' . $search . '/i', $field)) {
                        return true;
                    }
                }
                return false;
            })->sortBy([['Grading', 'desc'],['KodeOrganisasi', 'asc']])->values();
        }

        $data = $this->paginate($pegawai_Collection, 15, request('page'), ['path'=>' '])->withQueryString();
        return view('monitoring.laporan.index',[
            "pageTitle"=>"Laporan",
            "data"=>$data,
            "status"=>$status
        ]);
    }
    
    public function profil($nip)
    {
        if (Auth::guard('web')->check()) {
            $gate=['opr_monitoring', 'plt_admin_satker'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $pegawai_Collection = hris::getPegawai($nip)->first();
        $keluarga = hris::getKeluarga($nip)->first();
        $rekenig = hris::getRekening($nip)->first();

        if (!$pegawai_Collection) {
            return abort(404);
        }
        if ($pegawai_Collection->KdSatker != auth()->user()->kdsatker) {
            return abort(403);
        }

        return view('monitoring.laporan.profil.index',[
            "pageTitle"=>"Profil ".$pegawai_Collection->Nama. " / ". $pegawai_Collection->Nip18,
            "pegawai"=>$pegawai_Collection,
            "keluarga"=>collect($keluarga)->sortBy('TanggalLahir'),
            "rekening"=>$rekenig
        ]);
    }

    public function pph_pasal_21($nip, $thn=null)
    {
        if (Auth::guard('web')->check()) {
            $gate=['opr_monitoring', 'plt_admin_satker'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $pegawai_Collection = hris::getPegawai($nip)->first();

        if (!$pegawai_Collection) {
            return abort(404);
        }
        if ($pegawai_Collection->KdSatker != auth()->user()->kdsatker) {
            return abort(403);
        }

        $tahun = spt::getTahun($nip);

        if ($thn === null) {
            $thn=collect($tahun)->first()->tahun;
        }

        if (!isset(collect($tahun)->where('tahun', $thn)->first()->tahun)) {
            abort(404);
        }
        
        return view('monitoring.laporan.pph_pasal_21.index',[
            "pageTitle"=>"PPh Pasal 21 " .$pegawai_Collection->Nama. " / ". $pegawai_Collection->Nip18,
            "thn"=>$thn,
            "nip"=>$nip,
            "peg"=>spt::getSptPegawai($nip, $thn),
            "gaji"=>spt::getViewGaji($nip, $thn),
            "kurang"=>spt::getViewKurang($nip, $thn),
            "tukin"=>spt::getViewTukin($nip, $thn),
            "rapel"=>spt::getViewRapel($nip, $thn),
            "tarif"=>detailLain::getTarif($thn),
            "tahun"=>collect($tahun)->all()
        ]);
    }

    public function pph_pasal_21_final($nip, $thn = null)
    {
        if (Auth::guard('web')->check()) {
            $gate=['opr_monitoring', 'plt_admin_satker'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        
        $pegawai_Collection = hris::getPegawai($nip)->first();

        if (!$pegawai_Collection) {
            return abort(404);
        }
        if ($pegawai_Collection->KdSatker != auth()->user()->kdsatker) {
            return abort(403);
        }

        $tahun = spt::getTahun($nip);

        if ($thn === null) {
            $thn=collect($tahun)->first()->tahun;
        }

        if (!isset(collect($tahun)->where('tahun', $thn)->first()->tahun)) {
            abort(404);
        }

        return view('monitoring.laporan.pph_pasal_21_final.index',[
            "pageTitle"=>"PPh Pasal 21 Final ".$pegawai_Collection->Nama. " / ". $pegawai_Collection->Nip18,
            "thn"=>$thn,
            "nip"=>$nip,
            "tahun"=>collect($tahun)->all(),
            "makan"=>dataMakan::getPph($nip, $thn),
            "lembur"=>dataLembur::getPph($nip, $thn),
            'lain'=>dataLain::getPph($nip, $thn)
        ]);
    }

    public function penghasilan_tahunan($nip, $thn=null)
    {
        if (Auth::guard('web')->check()) {
            $gate=['opr_monitoring', 'plt_admin_satker'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $pegawai_Collection = hris::getPegawai($nip)->first();

        if (!$pegawai_Collection) {
            return abort(404);
        }
        if ($pegawai_Collection->KdSatker != auth()->user()->kdsatker) {
            return abort(403);
        }

        $tahun = penghasilan::getTahunPenghasilan($nip);

        if ($thn === null) {
            $thn=collect($tahun)->first()->tahun;
        }

        if (!isset(collect($tahun)->where('tahun', $thn)->first()->tahun)) {
            abort(404);
        }

        return view('monitoring.laporan.penghasilan_tahunan.index',[
            "pageTitle"=>"Penghasilan Tahunan ".$pegawai_Collection->Nama. " / ". $pegawai_Collection->Nip18,
            "data"=>penghasilan::getPenghasilanTahunan($nip, $thn),
            "thn"=>$thn,
            "nip"=>$nip,
            "tahun"=>$tahun
        ]);
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

    public function pph_pasal_21_cetak($nip, $thn)
    {
        
        if (Auth::guard('web')->check()) {
            $gate=['opr_monitoring', 'plt_admin_satker'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $pegawai_Collection = hris::getPegawai($nip)->first();

        if (!$pegawai_Collection) {
            return abort(404);
        }
        if ($pegawai_Collection->KdSatker != auth()->user()->kdsatker) {
            return abort(403);
        }

        ob_start();
        $html = ob_get_clean();
        
        $html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('Form 1721-A2');
        $html2pdf->writeHTML(view('monitoring.laporan.pph_pasal_21.cetak',[
            "thn"=>$thn,
            "nip"=>$nip,
            "peg"=>spt::getSptPegawai($nip, $thn),
            "gaji"=>spt::getViewGaji($nip, $thn),
            "kurang"=>spt::getViewKurang($nip, $thn),
            "tukin"=>spt::getViewTukin($nip, $thn),
            "rapel"=>spt::getViewRapel($nip, $thn),
            "tarif"=>detailLain::getTarif($thn),
            "profil"=>detailLain::getProfil($pegawai_Collection->KdSatker, $thn),
            "satker"=>satkerAlika::getDetailSatker($pegawai_Collection->KdSatker),
            "pegawai"=>$pegawai_Collection
        ]));
        $html2pdf->output('1721A2-' . $nip . '.pdf', 'D');
    }

    public function pph_pasal_21_final_cetak($nip, $thn)
    {
        if (Auth::guard('web')->check()) {
            $gate=['opr_monitoring', 'plt_admin_satker'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $pegawai_Collection = hris::getPegawai($nip)->first();

        if (!$pegawai_Collection) {
            return abort(404);
        }
        if ($pegawai_Collection->KdSatker != auth()->user()->kdsatker) {
            return abort(403);
        }

        ob_start();
        $html = ob_get_clean();

        $html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('Form 1721-VII');
        $html2pdf->writeHTML(view('monitoring.laporan.pph_pasal_21_final.cetak',[
            "thn"=>$thn,
            "nip"=>$nip,
            "makan"=>dataMakan::getPph($nip, $thn),
            "lembur"=>dataLembur::getPph($nip, $thn),
            'lain'=>dataLain::getPph($nip, $thn),
            "profil"=>detailLain::getProfil($pegawai_Collection->KdSatker, $thn),
            "satker"=>satkerAlika::getDetailSatker($pegawai_Collection->KdSatker),
            "pegawai"=>$pegawai_Collection
        ]));
        $html2pdf->output('1721VII-' . $nip . '.pdf', 'D');
    }

    public function penghasilan_tahunan_daftar()
    {
        return view('monitoring.laporan.penghasilan_tahunan.daftar');
    }

    public function penghasilan_tahunan_surat()
    {
        return view('monitoring.laporan.penghasilan_tahunan.surat');
    }
    
    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
