<?php

namespace App\Http\Controllers;

use App\Models\Kop;
use App\Models\User;
use App\Models\Nomor;
use App\Models\satker;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spipu\Html2Pdf\Html2Pdf;
use Illuminate\Support\Carbon;
use App\Models\AbsensiUangMakan;
use App\Models\adminSatker;
use App\Models\PermohonanBelanja51;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class Belanja51CreateMakanController extends Controller
{
    public function index($thn = null)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['plt_admin_satker', 'opr_belanja_51', 'approver'];
            $gate2 = ['sys_admin'];
        } else {
            $gate = ['admin_satker'];
            $gate2 = [];
        }
        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if (!$thn) {
            $thn = date('Y');
        }
        $tahun = AbsensiUangMakan::tahun(auth()->user()->kdsatker);
        $bulan = AbsensiUangMakan::RekapBulanan(auth()->user()->kdsatker, $thn)->get();
        return view('belanja-51.uang_makan.create.index', [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'thn' => $thn,
        ]);
    }

    public function preview($thn, $bln)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['plt_admin_satker', 'opr_belanja_51', 'approver'];
        } else {
            $gate = ['admin_satker'];
        }
        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        $minDate = Carbon::create($thn, $bln, 1)->format('Y-m-d');
        $maxDate = Carbon::create($thn, $bln)->endOfMonth()->format('Y-m-d');
        $data = AbsensiUangMakan::rekap(auth()->user()->kdsatker, $thn, $bln)
            ->paginate(15)
            ->withQueryString();
        $aprSatker = User::AprSatker(auth()->user()->kdsatker)->get();
        $adminSatker = adminSatker::where('kdsatker', auth()->user()->kdsatker)->first();
        $satker = satker::where('kdsatker', auth()->user()->kdsatker)->first();
        return view('belanja-51.uang_makan.create.preview', [
            'data' => $data,
            'thn' => $thn,
            'bln' => $bln,
            'approval' => $aprSatker,
            'admin' => $adminSatker,
            'satker' => $satker,
            'minDate' => $minDate,
            'maxDate' => $maxDate,
        ]);
    }

    public function store($thn, $bln, Request $request)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['plt_admin_satker', 'opr_belanja_51', 'approver'];
        } else {
            $gate = ['admin_satker'];
        }
        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if (!$thn) {
            $thn = date('Y');
        }
        $request->validate([
            'uraian' => 'required',
            'penandatangan' => 'required',
            'jabatan' => 'required',
        ]);
        $nomor = Nomor::where('kdsatker', auth()->user()->kdsatker, date('Y'))->first();
        $penandatangan = user::where('nip', $request->penandatangan)->first();
        $permohonan = PermohonanBelanja51::create([
            'kdsatker' => auth()->user()->kdsatker,
            'kdunit' => 0000,
            'tahun' => $thn,
            'bulan' => $bln,
            'jenis' => 'makan',
            'uraian' => $request->uraian,
            'status' => 'draft',
            'nip' => $request->penandatangan,
            'nama' => $penandatangan->nama,
            'jabatan' => $request->jabatan,
            'tanggal' => date('Y-m-d'),
            'nomor' => $nomor->nomor.$nomor->ext.$nomor->tahun,
        ]);
        $nomor->update([
            'nomor' => $nomor->nomor + 1,
        ]);
        $kop = Kop::where('kdsatker', auth()->user()->kdsatker)->first();
        $permohonan->history()->create([
            'action' => 'membuat',
            'catatan' => 'Membuat permohonan ' . $permohonan->uraian,
            'nip' => Auth::user()->nip,
            'nama' => Auth::user()->nama,
        ]);
        $minDate = request('min') ?? Carbon::create($thn, $bln, 1)->format('Y-m-d');
        $maxDate = request('max') ?? Carbon::create($thn, $bln)->endOfMonth()->format('Y-m-d');
        $data = AbsensiUangMakan::where('kdsatker', auth()->user()->kdsatker)
            ->whereBetween('tanggal', [$minDate, $maxDate])
            ->whereYear('tanggal', $thn)
            ->whereMonth('tanggal', $bln)
            ->get();
        foreach ($data as $item) {
            $permohonan->dataMakan()->create([
                'golongan' => $item->golongan,
                'nip' => $item->nip,
                'nama' => $item->nama,
                'tanggal' => $item->tanggal,
                'absensimasuk' => $item->absensimasuk,
                'absensikeluar' => $item->absensikeluar,
            ]);
        }
        ob_start();
        $html2pdf = ob_get_clean();
        $html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', array(18, 15, 15, 15), true);
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle($permohonan->uraian);
        $html2pdf->writeHTML(view('belanja-51.uang_makan.document.permohonan', [
            'data' => $permohonan->dataMakan()->rekap()->get(),
            'permohonan' => $permohonan,
            'nomor' => $permohonan->nomor,
            'kop' => $kop,
            'tanggal' => $permohonan->tanggal
        ]));
        $register = $html2pdf->output('', 'S');
        $filename = 'permohonan/file/' . Str::uuid() . '.pdf';
        Storage::put($filename, $register);
        ob_clean();
        $permohonan->update([
            'file' => $filename
        ]);
        $daysInMonth = Carbon::create(2024, 6, 1)->daysInMonth;
        $dataAbsensi = $permohonan->dataMakan()->RekapTanggal();
        ob_start();
        $html2pdf = ob_get_clean();
        $html2pdf = new Html2Pdf('L', 'F4', 'en', false, 'UTF-8', array(10, 15, 10, 15), true);
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('Lampiran ' . $permohonan->uraian);
        $html2pdf->writeHTML(view('belanja-51.uang_makan.document.lampiran', [
            'data' => $dataAbsensi,
            'daysInMonth' => $daysInMonth,
            'thn' => 2024,
            'bln' => 6,
            'permohonan' => $permohonan,
            'nomor' => $permohonan->nomor,
            'kop' => $kop,
            'tanggal' => $permohonan->tanggal
        ]));
        $lampiran = $html2pdf->output('', 'S');
        $lampiranname = 'permohonan/lampiran/' . Str::uuid() . '.pdf';
        Storage::put($lampiranname, $lampiran);
        ob_clean();
        $permohonan->lampiran()->create([
            'file' => $lampiranname,
            'nama' => 'Rekap Absensi ' . $permohonan->uraian,
        ]);
        return redirect('/belanja-51-v2/uang-makan/permohonan/')->with('berhasil', 'permohonan berhasil dibuat');
    }


    public function test()
    {
        $daysInMonth = Carbon::create(2024, 6, 1)->daysInMonth;
        $data = AbsensiUangMakan::RekapTanggal(auth()->user()->kdsatker, 2024, 6);
        // return $data->first()->data->where('tanggal', "2024-06-01")->first()->absensikeluar;
        ob_start();
        // return view('belanja-51.uang_makan.document.lampiran');
        $html2pdf = ob_get_clean();

        $html2pdf = new Html2Pdf('L', 'F4', 'en', false, 'UTF-8', array(10, 15, 10, 15), true);
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('$permohonan->uraian');
        $html2pdf->writeHTML(view('belanja-51.uang_makan.document.lampiran', [
            'data' => $data,
            'daysInMonth' => $daysInMonth,
            'thn' => 2024,
            'bln' => 6,
        ]));

        // Menetapkan header untuk memastikan PDF dikirim ke browser dan ditampilkan
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="document.pdf"');

        // Output PDF ke browser
        return $html2pdf->output('document.pdf', 'I');
    }
}