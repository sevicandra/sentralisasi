<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kop;
use App\Models\User;
use App\Models\Nomor;
use App\Models\satker;
use App\Models\adminSatker;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spipu\Html2Pdf\Html2Pdf;
use App\Models\AbsensiUangLembur;
use App\Models\NotifikasiBelanja51;
use App\Models\PermohonanBelanja51;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PusatBelanja51CreateLemburController extends Controller
{
    public function index($thn = null)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat'];
        } else {
            $gate = [];
        }
        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if (!$thn) {
            $thn = date('Y');
        }
        $tahun = AbsensiUangLembur::tahunPusat(auth()->user()->kdsatker, auth()->user()->kdunit);
        $bulan = AbsensiUangLembur::RekapBulananPusat(auth()->user()->kdsatker, auth()->user()->kdunit, $thn)->get();
        return view('belanja-51-pusat.uang_lembur.create.index', [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'thn' => $thn,
            'pageTitle' => 'Uang Lembur',
            'notifBelanja51Tolak' => NotifikasiBelanja51::NotifikasiPusat(auth()->user()->kdsatker, auth()->user()->kdunit),
        ]);
    }

    public function preview($thn, $bln)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat'];
        } else {
            $gate = [];
        }
        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        $minDate = Carbon::create($thn, $bln, 1)->format('Y-m-d');
        $maxDate = Carbon::create($thn, $bln)->endOfMonth()->format('Y-m-d');
        $data = AbsensiUangLembur::rekapPusat(auth()->user()->kdsatker, auth()->user()->kdunit, $thn, $bln)->get();
        $aprSatker = User::AprSatker(auth()->user()->kdsatker)->get();
        $adminSatker = adminSatker::where('kdsatker', auth()->user()->kdsatker)->first();
        $satker = satker::where('kdsatker', auth()->user()->kdsatker)->first();
        return view('belanja-51-pusat.uang_lembur.create.preview', [
            'data' => $data,
            'thn' => $thn,
            'bln' => $bln,
            'approval' => $aprSatker,
            'admin' => $adminSatker,
            'satker' => $satker,
            'minDate' => $minDate,
            'maxDate' => $maxDate,
            'pageTitle' => 'Uang Lembur',
            'notifBelanja51Tolak' => NotifikasiBelanja51::NotifikasiPusat(auth()->user()->kdsatker, auth()->user()->kdunit),
        ]);
    }

    public function store($thn, $bln, Request $request)
    {
        // return $request;
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat'];
        } else {
            $gate = [];
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
            'data' => 'required|array',
        ], [
            'data.required' => 'Tidak ada data yang dipilih',
            'data.array' => 'Tidak ada data yang dipilih',
            'penandatangan.required' => 'Penandatangan harus diisi',
            'jabatan.required' => 'Jabatan harus diisi',
            'uraian.required' => 'Uraian harus diisi',
        ]);
        $nomor = Nomor::where('kdsatker', auth()->user()->kdsatker)->where('kdunit', auth()->user()->kdunit)->where('tahun', Date('Y'))->first();
        if (!$nomor) {
            $nomor = Nomor::create([
                'kdsatker' => auth()->user()->kdsatker,
                'kdunit' => auth()->user()->kdunit,
                'nomor' => 1,
                'ext' => Nomor::where('kdsatker', auth()->user()->kdsatker)->where('kdunit', auth()->user()->kdunit)->first()->ext,
                'tahun' => Date('Y'),
            ]);
        }
        $permohonan = PermohonanBelanja51::create([
            'kdsatker' => auth()->user()->kdsatker,
            'kdunit' => auth()->user()->kdunit,
            'tahun' => $thn,
            'bulan' => $bln,
            'jenis' => 'lembur',
            'uraian' => $request->uraian,
            'status' => 'draft',
            'nip' => explode('/', $request->penandatangan)[0],
            'nama' => explode('/', $request->penandatangan)[1],
            'jabatan' => $request->jabatan,
            'tanggal' => date('Y-m-d'),
            'nomor' => $nomor->nomor . $nomor->ext . $nomor->tahun,
        ]);
        $nomor->update([
            'nomor' => $nomor->nomor + 1,
        ]);
        $kop = Kop::where('kdsatker', auth()->user()->kdsatker)->where('kdunit', auth()->user()->kdunit)->first();
        $permohonan->history()->create([
            'action' => 'membuat',
            'catatan' => 'Membuat permohonan ' . $permohonan->uraian,
            'nip' => Auth::user()->nip,
            'nama' => Auth::user()->nama,
        ]);
        $minDate = request('min') ?? Carbon::create($thn, $bln, 1)->format('Y-m-d');
        $maxDate = request('max') ?? Carbon::create($thn, $bln)->endOfMonth()->format('Y-m-d');
        $data = AbsensiUangLembur::where('kdsatker', auth()->user()->kdsatker)
            ->where('kdunit', auth()->user()->kdunit)
            ->whereBetween('tanggal', [$minDate, $maxDate])
            ->whereYear('tanggal', $thn)
            ->whereMonth('tanggal', $bln)
            ->whereIn('nip', $request->data)
            ->get();
        foreach ($data as $item) {
            $permohonan->dataLembur()->create([
                'golongan' => $item->golongan,
                'nip' => $item->nip,
                'nama' => $item->nama,
                'tanggal' => $item->tanggal,
                'absensimasuk' => $item->absensimasuk,
                'absensikeluar' => $item->absensikeluar,
                'jenishari' => $item->jenishari,
                'jumlahjam' => $item->jumlahjam,
            ]);
        }
        ob_start();
        $html2pdf = ob_get_clean();
        $html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', array(18, 15, 15, 15), true);
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle($permohonan->uraian);
        $html2pdf->writeHTML(view('belanja-51-pusat.uang_lembur.document.permohonan', [
            'data' => $permohonan->dataLembur()->rekap()->get(),
            'permohonan' => $permohonan,
            'nomor' => $permohonan->nomor,
            'kop' => $kop,
            'tanggal' => $permohonan->tanggal,
            'bulan' => $permohonan->bulan,
            'tahun' => $permohonan->tahun,
        ]));
        $register = $html2pdf->output('', 'S');
        $filename = 'permohonan/file/' . Str::uuid() . '.pdf';
        Storage::put($filename, $register);
        ob_clean();
        $permohonan->update([
            'file' => $filename
        ]);
        $daysInMonth = Carbon::create($thn, $bln, 1)->daysInMonth;
        $dataAbsensi = $permohonan->dataLembur()->RekapTanggal();
        ob_start();
        $html2pdf = ob_get_clean();
        $html2pdf = new Html2Pdf('L', 'F4', 'en', false, 'UTF-8', array(10, 15, 10, 15), true);
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('Lampiran ' . $permohonan->uraian);
        $html2pdf->writeHTML(view('belanja-51-pusat.uang_lembur.document.lampiran', [
            'data' => $dataAbsensi,
            'daysInMonth' => $daysInMonth,
            'thn' => $thn,
            'bln' => $bln,
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
        return redirect('/belanja-51-pusat/uang-lembur/permohonan/')->with('berhasil', 'permohonan berhasil dibuat');
    }
}
