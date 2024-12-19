<?php

namespace App\Http\Controllers;

use stdClass;
use App\Helper\hris;
use Spipu\Html2Pdf\Html2Pdf;
use App\Helper\AlikaNew\Gaji;
use App\Helper\AlikaNew\Profil;
use App\Helper\AlikaNew\Satker;
use App\Helper\AlikaNew\UangMakan;
use App\Helper\AlikaNew\SPTPegawai;
use App\Helper\AlikaNew\UangLembur;
use App\Helper\AlikaNew\RefSPTTahunan;
use App\Helper\AlikaNew\PenghasilanLain;
use App\Helper\AlikaNew\Penghasilan;

// API Alika Old
use App\Helper\Alika\API3\spt;
use App\Helper\Alika\API3\dataMakan;
use App\Helper\Alika\API3\dataLain;
use App\Helper\Alika\API3\dataLembur;
use App\Helper\Alika\API3\gaji as GajiOld;
use App\Helper\Alika\API3\penghasilan as PenghasilanOld;
use App\Helper\Alika\API3\satkerAlika;
use App\Helper\Alika\API3\detailLain;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\LengthAwarePaginator;

class MonitoringLaporanController extends Controller
{
    public function index()
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_monitoring', 'plt_admin_satker'];
        } else {
            $gate = ['admin_satker'];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $pegawai = hris::getPegawaiBySatker(auth()->user()->kdsatker);
        $status = $pegawai->unique('StatusPegawai')->pluck('StatusPegawai');
        $search = request('search');
        if (request('status')) {
            $pegawai_Collection = Collect($pegawai, false)->map(function ($data) {
                return (object)[
                    'Nama' => $data->Nama,
                    'Nip18' => $data->Nip18,
                    'StatusPegawai' => $data->StatusPegawai,
                    'Grading' => $data->Grading,
                    'KodeOrganisasi' => $data->KodeOrganisasi,
                ];
            })->where('StatusPegawai', request('status'))->filter(function ($value) use ($search) {
                foreach ($value as $field) {
                    if (preg_match('/' . $search . '/i', $field)) {
                        return true;
                    }
                }
                return false;
            })->sortBy([['Grading', 'desc'], ['KodeoOrganisasi', 'asc']])->values();
        } else {
            $pegawai_Collection = Collect($pegawai, false)->map(function ($data) {
                return (object)[
                    'Nama' => $data->Nama,
                    'Nip18' => $data->Nip18,
                    'StatusPegawai' => $data->StatusPegawai,
                    'Grading' => $data->Grading,
                    'KodeOrganisasi' => $data->KodeOrganisasi,
                ];
            })->where('StatusPegawai', 'Aktif')->filter(function ($value) use ($search) {
                foreach ($value as $field) {
                    if (preg_match('/' . $search . '/i', $field)) {
                        return true;
                    }
                }
                return false;
            })->sortBy([['Grading', 'desc'], ['KodeOrganisasi', 'asc']])->values();
        }

        $data = $this->paginate($pegawai_Collection, 15, request('page'), ['path' => ' '])->withQueryString();
        return view('monitoring.laporan.index', [
            "pageTitle" => "Laporan",
            "data" => $data,
            "status" => $status
        ]);
    }
    public function profil($nip)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_monitoring', 'plt_admin_satker'];
        } else {
            $gate = ['admin_satker'];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
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

        return view('monitoring.laporan.profil.index', [
            "pageTitle" => "Profil " . $pegawai_Collection->Nama . " / " . $pegawai_Collection->Nip18,
            "pegawai" => $pegawai_Collection,
            "keluarga" => collect($keluarga)->sortBy('TanggalLahir'),
            "rekening" => $rekenig
        ]);
    }
    public function pph_pasal_21($nip, $thn = null)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_monitoring', 'plt_admin_satker'];
        } else {
            $gate = ['admin_satker'];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $pegawai_Collection = hris::getPegawai($nip)->first();

        if (!$pegawai_Collection) {
            return abort(404);
        }
        if ($pegawai_Collection->KdSatker != auth()->user()->kdsatker) {
            return abort(403);
        }
        // $tahun = SPTPegawai::tahunByNip($nip)->data;
        $tahun = spt::getTahun($nip);
        
        if ($thn === null) {
            $thn = collect($tahun)->first()->tahun;
        }

        if (!isset(collect($tahun)->where('tahun', $thn)->first()->tahun)) {
            abort(404);
        }

        // $peg = SPTPegawai::get($nip, $thn)->data;
        $peg = spt::getSptPegawai($nip, $thn);

        // $gaji = SPTPegawai::gaji($nip, $thn)->data;
        $gaji = spt::getViewGaji($nip, $thn);

        // $kekuranganGaji = SPTPegawai::kekuranganGaji($nip, $thn)->data;
        $kekuranganGaji = spt::getViewKurang($nip, $thn);

        // $tukin = SPTPegawai::tukin($nip, $thn)->data;
        $tukin = spt::getViewTukin($nip, $thn);

        // $tarif = RefSPTTahunan::get($thn)->data;
        $tarif = detailLain::getTarif($thn);
        return view('monitoring.laporan.pph_pasal_21.index', [
            "pageTitle" => "PPh Pasal 21 " . $pegawai_Collection->Nama . " / " . $pegawai_Collection->Nip18,
            "thn" => $thn,
            "nip" => $nip,
            "peg" => $peg,
            "gaji" => $gaji,
            "kurang" => $kekuranganGaji,
            "tukin" => $tukin,
            "tarif" => $tarif,
            "tahun" => collect($tahun)->all()
        ]);
    }

    public function pph_pasal_21_final($nip, $thn = null)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_monitoring', 'plt_admin_satker'];
        } else {
            $gate = ['admin_satker'];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $pegawai_Collection = hris::getPegawai($nip)->first();

        if (!$pegawai_Collection) {
            return abort(404);
        }
        if ($pegawai_Collection->KdSatker != auth()->user()->kdsatker) {
            return abort(403);
        }

        // $tahun = SPTPegawai::tahunByNip($nip)->data;
        $tahun = spt::getTahun($nip);

        if ($thn === null) {
            $thn = collect($tahun)->first()->tahun;
        }

        if (!isset(collect($tahun)->where('tahun', $thn)->first()->tahun)) {
            abort(404);
        }

        // $makan = UangMakan::pph($nip, $thn)->data;
        $data_makan = dataMakan::getPph($nip, $thn);
        $makan = new stdClass();

        $makan->nip = $data_makan->nip;
        $makan->tahun = $data_makan->tahun;
        $makan->bruto = $data_makan->jumlah_bruto;
        $makan->pph = $data_makan->jumlah_pph;
        $makan->netto = $data_makan->jumlah_bruto - $data_makan->jumlah_pph;

        // $lembur = UangLembur::pph($nip, $thn)->data;
        $data_lembur = dataLembur::getPph($nip, $thn);
        $lembur = new stdClass();

        $lembur->nip = $data_lembur->nip;
        $lembur->tahun = $data_lembur->tahun;
        $lembur->bruto = $data_lembur->jumlah_bruto;
        $lembur->pph = $data_lembur->jumlah_pph;
        $lembur->netto = $data_lembur->jumlah_bruto - $data_lembur->jumlah_pph;

        // $lain = PenghasilanLain::pph($nip, $thn)->data;
        $lain = collect(dataLain::getPph($nip, $thn))->map(function ($item) {
            return (object) [
                'jenis' => $item->jenis,
                'bruto' => $item->jumlah_bruto,
                'pph' => $item->jumlah_pph,
                'netto' => $item->jumlah_bruto - $item->jumlah_pph
            ];
        });
        return view('monitoring.laporan.pph_pasal_21_final.index', [
            "pageTitle" => "PPh Pasal 21 Final " . $pegawai_Collection->Nama . " / " . $pegawai_Collection->Nip18,
            "thn" => $thn,
            "nip" => $nip,
            "tahun" => collect($tahun)->all(),
            "makan" => $makan,
            "lembur" => $lembur,
            'lain' => $lain
        ]);
    }

    public function penghasilan_tahunan($nip, $thn = null)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_monitoring', 'plt_admin_satker'];
        } else {
            $gate = ['admin_satker'];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $pegawai_Collection = hris::getPegawai($nip)->first();

        if (!$pegawai_Collection) {
            return abort(404);
        }
        if ($pegawai_Collection->KdSatker != auth()->user()->kdsatker) {
            return abort(403);
        }

        // $tahun = Gaji::tahun($nip)->data;
        $tahun = GajiOld::getTahunGaji($nip);

        if ($thn === null) {
            $thn = collect($tahun)->first()->tahun;
        }

        if (!isset(collect($tahun)->where('tahun', $thn)->first()->tahun)) {
            abort(404);
        }
        // $penghasilan = Penghasilan::get($nip, $thn)->data;
        $penghasilan = collect(PenghasilanOld::getPenghasilanTahunan($nip, $thn))->map(function ($item) {
            return (object) [
                'bulan' => $item->nama_bulan,
                'gaji' => (object)[
                    "bulan"=> $item->bulan,
                    "netto"=> $item->netto1,
                    "bruto"=> $item->bruto1,
                    "potongan"=> $item->potongan1,
                ],
                'kekuranganGaji' => (object)[
                    "bulan"=> $item->bulan,
                    "netto"=> $item->netto2,
                    "bruto"=> $item->bruto2,
                    "potongan"=> $item->potongan2,
                ],
                'tukin' => (object)[
                    "bulan"=> $item->bulan,
                    "netto"=> $item->netto5,
                    "bruto"=> $item->bruto5,
                    "potongan"=> $item->potongan5,
                ],
                'kekuranganTukin' => (object)[
                    "bulan"=> $item->bulan,
                    "netto"=> $item->netto6,
                    "bruto"=> $item->bruto6,
                    "potongan"=> $item->potongan6,
                ],
                'makan' => (object)[
                    "bulan"=> $item->bulan,
                    "netto"=> $item->netto3,
                    "bruto"=> $item->bruto3,
                    "potongan"=> $item->potongan3,
                ],
                'lembur' => (object)[
                    "bulan"=> $item->bulan,
                    "netto"=> $item->netto4,
                    "bruto"=> $item->bruto4,
                    "potongan"=> $item->potongan4,
                ],
                'lain' => (object)[
                    "bulan"=> $item->bulan,
                    "netto"=> 0,
                    "bruto"=> 0,
                    "potongan"=> 0,
                ]
            ];
        });

        return view('monitoring.laporan.penghasilan_tahunan.index', [
            "pageTitle" => "Penghasilan Tahunan " . $pegawai_Collection->Nama . " / " . $pegawai_Collection->Nip18,
            "data" => $penghasilan,
            "thn" => $thn,
            "nip" => $nip,
            "tahun" => $tahun
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
            $gate = ['opr_monitoring', 'plt_admin_satker'];
        } else {
            $gate = ['admin_satker'];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $pegawai_Collection = hris::getPegawai($nip)->first();

        if (!$pegawai_Collection) {
            return abort(404);
        }
        if ($pegawai_Collection->KdSatker != auth()->user()->kdsatker) {
            return abort(403);
        }

        // $peg = SPTPegawai::get($nip, $thn)->data;
        $peg = spt::getSptPegawai($nip, $thn);
        // $gaji = SPTPegawai::gaji($nip, $thn)->data;
        $gaji = spt::getViewGaji($nip, $thn);
        // $kekuranganGaji = SPTPegawai::kekuranganGaji($nip, $thn)->data;
        $kekuranganGaji = spt::getViewKurang($nip, $thn);
        // $tukin = SPTPegawai::tukin($nip, $thn)->data;
        $tukin = spt::getViewTukin($nip, $thn);
        // $tarif = RefSPTTahunan::get($thn)->data;
        $tarif = detailLain::getTarif($thn);
        // $profil = Profil::get($pegawai_Collection->KdSatker, $thn)->data;
        $profil= detailLain::getProfil($pegawai_Collection->KdSatker, $thn);
        // $satker = Satker::get($pegawai_Collection->KdSatker)->data;
        $satker = satkerAlika::getDetailSatker($pegawai_Collection->KdSatker);
        ob_start();
        $html2pdf = ob_get_clean();

        $html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('Form 1721-A2');
        $html2pdf->writeHTML(view('monitoring.laporan.pph_pasal_21.cetak', [
            "thn" => $thn,
            "nip" => $nip,
            "peg" => $peg,
            "gaji" => $gaji,
            "kurang" => $kekuranganGaji,
            "tukin" => $tukin,
            "tarif" => $tarif,
            "profil" => $profil,
            "satker" => $satker,
            "pegawai" => $pegawai_Collection
        ]));
        $html2pdf->output('1721A2-' . $nip . '.pdf', 'D');
    }

    public function pph_pasal_21_final_cetak($nip, $thn)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_monitoring', 'plt_admin_satker'];
        } else {
            $gate = ['admin_satker'];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $pegawai_Collection = hris::getPegawai($nip)->first();

        if (!$pegawai_Collection) {
            return abort(404);
        }
        if ($pegawai_Collection->KdSatker != auth()->user()->kdsatker) {
            return abort(403);
        }
        // $makan = UangMakan::pph($nip, $thn)->data;
        $data_makan = dataMakan::getPph($nip, $thn);
        $makan = new stdClass();

        $makan->nip = $data_makan->nip;
        $makan->tahun = $data_makan->tahun;
        $makan->bruto = $data_makan->jumlah_bruto;
        $makan->pph = $data_makan->jumlah_pph;
        $makan->netto = $data_makan->jumlah_bruto - $data_makan->jumlah_pph;

        // $lembur = UangLembur::pph($nip, $thn)->data;
        $data_lembur = dataLembur::getPph($nip, $thn);
        $lembur = new stdClass();

        $lembur->nip = $data_lembur->nip;
        $lembur->tahun = $data_lembur->tahun;
        $lembur->bruto = $data_lembur->jumlah_bruto;
        $lembur->pph = $data_lembur->jumlah_pph;
        $lembur->netto = $data_lembur->jumlah_bruto - $data_lembur->jumlah_pph;

        // $lain = PenghasilanLain::pph($nip, $thn)->data;
        $lain = collect(dataLain::getPph($nip, $thn))->map(function ($item) {
            return (object) [
                'jenis' => $item->jenis,
                'bruto' => $item->jumlah_bruto,
                'pph' => $item->jumlah_pph,
                'netto' => $item->jumlah_bruto - $item->jumlah_pph
            ];
        });
        // $profil = Profil::get($pegawai_Collection->KdSatker, $thn)->data;
        $profil= detailLain::getProfil($pegawai_Collection->KdSatker, $thn);
        // $satker = Satker::get($pegawai_Collection->KdSatker)->data;
        $satker = satkerAlika::getDetailSatker($pegawai_Collection->KdSatker);
        ob_start();
        $html2pdf = ob_get_clean();

        $html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('Form 1721-VII');
        $html2pdf->writeHTML(view('monitoring.laporan.pph_pasal_21_final.cetak', [
            "thn" => $thn,
            "nip" => $nip,
            "makan" => $makan,
            "lembur" => $lembur,
            'lain' => $lain,
            "profil" => $profil,
            "satker" => $satker,
            "pegawai" => $pegawai_Collection
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
