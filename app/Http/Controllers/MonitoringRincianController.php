<?php

namespace App\Http\Controllers;

use App\Helper\hris;
use Spipu\Html2Pdf\Html2Pdf;
use App\Helper\AlikaNew\Penghasilan;
use App\Helper\AlikaNew\Gaji;
use App\Helper\AlikaNew\KekuranganGaji;
use App\Helper\AlikaNew\UangMakan;
use App\Helper\AlikaNew\UangLembur;
use App\Helper\AlikaNew\KekuranganTukin;
use App\Helper\AlikaNew\Tukin;
use App\Helper\AlikaNew\PenghasilanLain;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\LengthAwarePaginator;

class MonitoringRincianController extends Controller
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
        return view('monitoring.rincian.index', [
            "pageTitle" => "Rincian",
            "data" => $data,
            "status" => $status
        ]);
    }
    public function penghasilan($nip = null, $thn = null)
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

        if ($thn) {
            $thn = $thn;
        } else {
            $thn = date('Y');
        }

        return view('monitoring.rincian.penghasilan.index', [
            "pageTitle" => "Penghasilan " . $pegawai_Collection->Nama . " / " . $pegawai_Collection->Nip18,
            "data" => collect(Penghasilan::get($nip, $thn)->data),
            "tahun" => Gaji::tahun($nip)->data,
            'nip' => $nip,
            'thn' => $thn
        ]);
    }
    public function gaji($nip = null, $thn = null, $jns = null)
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

        if (!$thn) {
            $thn = date('Y');
        }
        switch ($jns) {
            case 'rutin':
                $data = Gaji::get($nip, $thn)->data;
                break;

            case 'kekurangan':
                $data = KekuranganGaji::get($nip, $thn)->data;
                break;

            default:
                $data = Gaji::get($nip, $thn)->data;
                break;
        }

        $tahun = gaji::Tahun($nip)->data;

        return view('monitoring.rincian.gaji', [
            "pageTitle" => "Gaji " . $pegawai_Collection->Nama . " / " . $pegawai_Collection->Nip18,
            "tahun" => $tahun,
            "data" => collect($data, false),
            "thn" => $thn,
            "jns" => $jns,
            'nip' => $nip
        ]);
    }
    public function uang_makan($nip = null, $thn = null)
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

        if (!$thn) {
            $thn = date('Y');
        }

        $tahun = UangMakan::tahun($nip)->data;

        $data = UangMakan::get($nip, $thn)->data;

        return view('monitoring.rincian.uang_makan', [
            "pageTitle" => "Uang Makan " . $pegawai_Collection->Nama . " / " . $pegawai_Collection->Nip18,
            'data' => collect($data),
            'nip' => $nip,
            'thn' => $thn,
            'tahun' => $tahun
        ]);
    }
    public function uang_lembur($nip = null, $thn = null)
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

        if (!$thn) {
            $thn = date('Y');
        }

        $tahun = UangLembur::tahun($nip)->data;

        $data = UangLembur::get($nip, $thn)->data;
        return view('monitoring.rincian.uang_lembur', [
            "pageTitle" => "Uang Lembur " . $pegawai_Collection->Nama . " / " . $pegawai_Collection->Nip18,
            'data' => collect($data),
            'nip' => $nip,
            'thn' => $thn,
            'tahun' => $tahun
        ]);
    }

    public function tunjangan_kinerja($nip = null, $thn = null, $jns = null)
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
        if (!$thn) {
            $thn = date('Y');
        }
        switch ($jns) {
            case 'rutin':
                $data = Tukin::get($nip, $thn)->data;
                break;

            case 'kekurangan':
                $data = KekuranganTukin::get($nip, $thn)->data;
                break;

            default:
                $data = Tukin::get($nip, $thn)->data;
                break;
        }

        $tahun = Tukin::Tahun($nip)->data;

        return view('monitoring.rincian.tunjangan_kinerja', [
            "pageTitle" => "Tunjangan Kinerja " . $pegawai_Collection->Nama . " / " . $pegawai_Collection->Nip18,
            'tahun' => $tahun,
            'data' => collect($data),
            'nip' => $nip,
            'thn' => $thn,
            'jns' => $jns
        ]);
    }

    public function lainnya($nip = null, $thn = null, $jns = null)
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

        if (!$thn) {
            $thn = date('Y');
        }
        $jenis = PenghasilanLain::jenis($nip, $thn)->data;

        if (!$jns) {
            $jns = $jenis[0]->jenis ?? 'uang-makan';
        }

        $tahun = PenghasilanLain::tahun($nip)->data;


        $data = PenghasilanLain::get($nip, $thn, $jns)->data;

        return view('monitoring.rincian.lainnya.index', [
            "pageTitle" => "Lainnya " . $pegawai_Collection->Nama . " / " . $pegawai_Collection->Nip18,
            'tahun' => $tahun,
            'jenis' => $jenis,
            'data' => collect($data),
            'nip' => $nip,
            'thn' => $thn,
            'jns' => $jns,
        ]);
    }

    public function lainnya_detail($nip, $thn, $jns, $bln)
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

        $data = PenghasilanLain::get($nip, $thn, $jns, $bln)->data;

        return view('monitoring.rincian.lainnya.detail', [
            "pageTitle" => "Detail " . $pegawai_Collection->Nama . " / " . $pegawai_Collection->Nip18,
            'data' => collect($data),
            'nip' => $nip,
            'thn' => $thn,
            'jns' => $jns,
        ]);
    }

    public function penghasilan_daftar()
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_monitoring', 'plt_admin_satker'];
        } else {
            $gate = ['admin_satker'];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
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
        if (Auth::guard('web')->check()) {
            $gate = ['opr_monitoring', 'plt_admin_satker'];
        } else {
            $gate = ['admin_satker'];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        ob_start();
        $html = ob_get_clean();
        $html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('SKP');
        $html2pdf->writeHTML(view('monitoring.rincian.penghasilan.surat'));
        $html2pdf->output('skp-' . "januari" . "2022" . '.pdf', 'D');
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
