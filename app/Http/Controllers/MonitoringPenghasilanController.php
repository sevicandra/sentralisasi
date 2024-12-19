<?php

namespace App\Http\Controllers;

use App\Helper\hris;
use App\Models\satker;
use Spipu\Html2Pdf\Html2Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Helper\AlikaNew\Penghasilan;
use App\Helper\AlikaNew\Gaji;
use App\Helper\AlikaNew\KekuranganGaji;
use App\Helper\AlikaNew\UangMakan;
use App\Helper\AlikaNew\UangLembur;
use App\Helper\AlikaNew\KekuranganTukin;
use App\Helper\AlikaNew\Tukin;
use App\Helper\AlikaNew\PenghasilanLain;

// API Alika Old
use App\Helper\Alika\API3\gaji as GajiOld;
use App\Helper\Alika\API3\penghasilan as PenghasilanOld;
use App\Helper\Alika\API3\dataMakan;
use App\Helper\Alika\API3\dataLembur;
use App\Helper\Alika\API3\tukin as TukinOld;
use App\Helper\Alika\API3\dataLain;


class MonitoringPenghasilanController extends Controller
{
    public function index()
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        return view('monitoring.penghasilan.index', [
            'pageTitle' => 'Penghasilan',
            'data' => satker::search()->order()->paginate(15)->withQueryString(),
        ]);
    }

    public function satker(satker $satker)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $pegawai = hris::getPegawaiBySatker($satker->kdsatker);
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
        return view('monitoring.penghasilan.rincian.index', [
            "pageTitle" => "Rincian " . $satker->nmsatker,
            "data" => $data,
            "satker" => $satker,
            "status" => $status
        ]);
    }

    public function satker_penghasilan(satker $satker, $nip = null, $thn = null)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($thn) {
            $thn = $thn;
        } else {
            $thn = date('Y');
        }
        $pegawai_Collection = hris::getPegawai($nip)->first();

        if (!$pegawai_Collection) {
            return abort(404);
        }
        if ($pegawai_Collection->KdSatker != $satker->kdsatker) {
            return abort(403);
        }

        // $penghasilan = collect(Penghasilan::get($nip, $thn)->data);
        $penghasilan = collect(PenghasilanOld::getPenghasilanTahunan($nip, $thn))->map(function ($item) {
            return (object) [
                'bulan' => $item->nama_bulan,
                'gaji' => (object)[
                    "bulan" => $item->bulan,
                    "netto" => $item->netto1,
                    "bruto" => $item->bruto1,
                    "potongan" => $item->potongan1,
                ],
                'kekuranganGaji' => (object)[
                    "bulan" => $item->bulan,
                    "netto" => $item->netto2,
                    "bruto" => $item->bruto2,
                    "potongan" => $item->potongan2,
                ],
                'tukin' => (object)[
                    "bulan" => $item->bulan,
                    "netto" => $item->netto5,
                    "bruto" => $item->bruto5,
                    "potongan" => $item->potongan5,
                ],
                'kekuranganTukin' => (object)[
                    "bulan" => $item->bulan,
                    "netto" => $item->netto6,
                    "bruto" => $item->bruto6,
                    "potongan" => $item->potongan6,
                ],
                'makan' => (object)[
                    "bulan" => $item->bulan,
                    "netto" => $item->netto3,
                    "bruto" => $item->bruto3,
                    "potongan" => $item->potongan3,
                ],
                'lembur' => (object)[
                    "bulan" => $item->bulan,
                    "netto" => $item->netto4,
                    "bruto" => $item->bruto4,
                    "potongan" => $item->potongan4,
                ],
                'lain' => (object)[
                    "bulan" => $item->bulan,
                    "netto" => 0,
                    "bruto" => 0,
                    "potongan" => 0,
                ]
            ];
        });
        // $tahun = Gaji::tahun($nip)->data;
        $tahun = GajiOld::getTahunGaji($nip);

        return view('monitoring.penghasilan.rincian.penghasilan.index', [
            "pageTitle" => "Penghasilan " . $pegawai_Collection->Nama . " / " . $pegawai_Collection->Nip18,
            "data" => $penghasilan,
            "tahun" => $tahun,
            'nip' => $nip,
            'thn' => $thn,
            'satker' => $satker,
        ]);
    }

    public function satker_gaji(satker $satker, $nip = null, $thn = null, $jns = null)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $pegawai_Collection = hris::getPegawai($nip)->first();

        if (!$pegawai_Collection) {
            return abort(404);
        }
        if ($pegawai_Collection->KdSatker != $satker->kdsatker) {
            return abort(403);
        }

        if (!$thn) {
            $thn = date('Y');
        }
        switch ($jns) {
            case 'rutin':
                // $data = Gaji::get($nip, $thn)->data;
                $data = GajiOld::getGaji($nip, $thn);
                break;

            case 'kekurangan':
                // $data = KekuranganGaji::get($nip, $thn)->data;
                $data = GajiOld::getKekuranganGaji($nip, $thn);
                break;

            default:
                // $data = Gaji::get($nip, $thn)->data;
                $data = GajiOld::getGaji($nip, $thn);
                break;
        }

        // $tahun = gaji::Tahun($nip)->data;
        $tahun = GajiOld::getTahunGaji($nip);

        return view('monitoring.penghasilan.rincian.gaji', [
            "pageTitle" => "Gaji " . $pegawai_Collection->Nama . " / " . $pegawai_Collection->Nip18,
            "tahun" => $tahun,
            "data" => collect($data, false),
            "thn" => $thn,
            "jns" => $jns,
            'nip' => $nip,
            'satker' => $satker
        ]);
    }

    public function satker_uang_makan(satker $satker, $nip = null, $thn = null)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $pegawai_Collection = hris::getPegawai($nip)->first();

        if (!$pegawai_Collection) {
            return abort(404);
        }
        if ($pegawai_Collection->KdSatker != $satker->kdsatker) {
            return abort(403);
        }

        if (!$thn) {
            $thn = date('Y');
        }

        // $tahun = UangMakan::tahun($nip)->data;
        $tahun = dataMakan::getTahun($nip);

        // $data = UangMakan::get($nip, $thn)->data;
        $data = dataMakan::getMakan($nip, $thn);

        return view('monitoring.penghasilan.rincian.uang_makan', [
            "pageTitle" => "Uang Makan " . $pegawai_Collection->Nama . " / " . $pegawai_Collection->Nip18,
            'data' => collect($data),
            'nip' => $nip,
            'thn' => $thn,
            'tahun' => $tahun,
            'satker' => $satker
        ]);
    }

    public function satker_uang_lembur(satker $satker, $nip = null, $thn = null)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $pegawai_Collection = hris::getPegawai($nip)->first();

        if (!$pegawai_Collection) {
            return abort(404);
        }
        if ($pegawai_Collection->KdSatker != $satker->kdsatker) {
            return abort(403);
        }

        if (!$thn) {
            $thn = date('Y');
        }


        // $tahun = UangLembur::tahun($nip)->data;
        $tahun = dataLembur::getTahun($nip);

        // $data = UangLembur::get($nip, $thn)->data;
        $data = dataLembur::getLembur($nip, $thn);
        return view('monitoring.penghasilan.rincian.uang_lembur', [
            "pageTitle" => "Uang Lembur " . $pegawai_Collection->Nama . " / " . $pegawai_Collection->Nip18,
            'data' => collect($data),
            'nip' => $nip,
            'thn' => $thn,
            'tahun' => $tahun,
            'satker' => $satker
        ]);
    }

    public function satker_tunjangan_kinerja(satker $satker, $nip = null, $thn = null, $jns = null)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        $pegawai_Collection = hris::getPegawai($nip)->first();

        if (!$pegawai_Collection) {
            return abort(404);
        }
        if ($pegawai_Collection->KdSatker != $satker->kdsatker) {
            return abort(403);
        }

        if (!$thn) {
            $thn = date('Y');
        }
        switch ($jns) {
            case 'rutin':
                // $data = Tukin::get($nip, $thn)->data;
                $data = TukinOld::getTukin($nip, $thn);
                break;

            case 'kekurangan':
                // $data = KekuranganTukin::get($nip, $thn)->data;
                $data = TukinOld::getKekuranganTukin($nip, $thn);
                break;

            default:
                // $data = Tukin::get($nip, $thn)->data;
                $data = TukinOld::getTukin($nip, $thn);
                break;
        }

        // $tahun = Tukin::Tahun($nip)->data;
        $tahun = TukinOld::getTahun($nip);

        return view('monitoring.penghasilan.rincian.tunjangan_kinerja', [
            "pageTitle" => "Tunjangan Kinerja " . $pegawai_Collection->Nama . " / " . $pegawai_Collection->Nip18,
            'tahun' => $tahun,
            'data' => collect($data),
            'nip' => $nip,
            'thn' => $thn,
            'jns' => $jns,
            'satker' => $satker
        ]);
    }

    public function satker_lainnya(satker $satker, $nip = null, $thn = null, $jns = null)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $pegawai_Collection = hris::getPegawai($nip)->first();

        if (!$pegawai_Collection) {
            return abort(404);
        }
        if ($pegawai_Collection->KdSatker != $satker->kdsatker) {
            return abort(403);
        }

        if (!$thn) {
            $thn = date('Y');
        }
        // $jenis = PenghasilanLain::jenis($nip, $thn)->data;
        $jenis = dataLain::getJenis($nip, $thn);

        if (!$jns) {
            $jns = $jenis[0]->jenis ?? 'uang-makan';
        }

        // $tahun = PenghasilanLain::tahun($nip)->data;
        $tahun = dataLain::getTahun($nip);

        // $data = PenghasilanLain::get($nip, $thn, $jns)->data;
        $data = dataLain::getLain($nip, $thn, $jns);
        return view('monitoring.penghasilan.rincian.lainnya.index', [
            "pageTitle" => "Lainnya " . $pegawai_Collection->Nama . " / " . $pegawai_Collection->Nip18,
            'tahun' => $tahun,
            'jenis' => $jenis,
            'data' => collect($data),
            'nip' => $nip,
            'thn' => $thn,
            'jns' => $jns,
            'satker' => $satker
        ]);
    }

    public function satker_lainnya_detail(satker $satker, $nip, $thn, $jns, $bln)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $pegawai_Collection = hris::getPegawai($nip)->first();

        if (!$pegawai_Collection) {
            return abort(404);
        }
        if ($pegawai_Collection->KdSatker != $satker->kdsatker) {
            return abort(403);
        }

        // $data = PenghasilanLain::get($nip, $thn, $jns, $bln)->data;
        $data = dataLain::getLainDetail($nip, $thn, $jns, $bln);

        return view('monitoring.penghasilan.rincian.lainnya.detail', [
            "pageTitle" => "Detail " . $pegawai_Collection->Nama . " / " . $pegawai_Collection->Nip18,
            'data' => collect($data),
            'nip' => $nip,
            'thn' => $thn,
            'jns' => $jns,
            'satker' => $satker
        ]);
    }

    public function satker_penghasilan_daftar()
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        ob_start();
        $html = ob_get_clean();
        $html2pdf = new Html2Pdf('L', 'A4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('Daftar Gaji');
        $html2pdf->writeHTML(view('monitoring.penghasilan.rincian.penghasilan.daftar'));
        $html2pdf->output('daftar-gaji-' . "januari" . "2022" . '.pdf', 'D');
    }

    public function satker_penghasilan_surat()
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        ob_start();
        $html = ob_get_clean();
        $html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('SKP');
        $html2pdf->writeHTML(view('monitoring.penghasilan.rincian.penghasilan.surat'));
        $html2pdf->output('skp-' . "januari" . "2022" . '.pdf', 'D');
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
