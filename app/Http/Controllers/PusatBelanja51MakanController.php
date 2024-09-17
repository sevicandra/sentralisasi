<?php

namespace App\Http\Controllers;

use App\Models\Kop;
use Illuminate\Support\Str;
use Spipu\Html2Pdf\Html2Pdf;
use Illuminate\Support\Carbon;
use App\Models\NotifikasiBelanja51;
use App\Models\PermohonanBelanja51;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\FilePermohonanBelanja51;
use Illuminate\Support\Facades\Storage;

class PusatBelanja51MakanController extends Controller
{
    public function index()
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat'];
        } else {
            $gate = [];
        }
        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        $data = PermohonanBelanja51::DraftMakanPusat(auth()->user()->kdsatker, auth()->user()->kdunit)
            ->paginate(15)
            ->withQueryString();
        return view('belanja-51-pusat.uang_makan.index', [
            'data' => $data,
            'pageTitle' => 'Uang Makan',
            'notifBelanja51Tolak' => NotifikasiBelanja51::NotifikasiPusat(auth()->user()->kdsatker, auth()->user()->kdunit),
        ]);
    }
    public function arsip()
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat'];
        } else {
            $gate = [];
        }
        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        $data = PermohonanBelanja51::ArsipMakanPusat(auth()->user()->kdsatker, auth()->user()->kdunit)
            ->paginate(15)
            ->withQueryString();
        return view('belanja-51-pusat.uang_makan.arsip.index', [
            'data' => $data,
            'pageTitle' => 'Uang Makan',
            'notifBelanja51Tolak' => NotifikasiBelanja51::NotifikasiPusat(auth()->user()->kdsatker, auth()->user()->kdunit),
        ]);
    }
    public function detail(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat'];
        } else {
            $gate = [];
        }
        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        if ($id->kdsatker != auth()->user()->kdsatker || $id->kdunit != auth()->user()->kdunit) {
            abort(403);
        }

        return view('belanja-51-pusat.uang_makan.detail', [
            'permohonan' => PermohonanBelanja51::with(['lampiran'])->find($id->id),
            'pageTitle' => $id->uraian,
            'notifBelanja51Tolak' => NotifikasiBelanja51::NotifikasiPusat(auth()->user()->kdsatker, auth()->user()->kdunit),
        ]);
    }
    public function detailArsip(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat'];
        } else {
            $gate = [];
        }
        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->kdsatker != auth()->user()->kdsatker || $id->kdunit != auth()->user()->kdunit) {
            abort(403);
        }
        return view('belanja-51-pusat.uang_makan.arsip.detail', [
            'permohonan' => PermohonanBelanja51::with(['lampiran'])->find($id->id),
            'pageTitle' => $id->uraian,
            'notifBelanja51Tolak' => NotifikasiBelanja51::NotifikasiPusat(auth()->user()->kdsatker, auth()->user()->kdunit),
        ]);
    }
    public function destroy(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat'];
        } else {
            $gate = [];
        }
        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->kdsatker != auth()->user()->kdsatker || $id->kdunit != auth()->user()->kdunit) {
            abort(403);
        }
        if ($id->status != 'draft') {
            return redirect('/belanja-51-pusat/uang-makan/permohonan')->with('gagal', 'data tidak dapat di hapus');
        }
        $id->delete();
        return redirect('/belanja-51-pusat/uang-makan/permohonan')->with('berhasil', 'data berhasil di hapus');
    }
    public function kirim(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat'];
        } else {
            $gate = [];
        }
        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->kdsatker != auth()->user()->kdsatker || $id->kdunit != auth()->user()->kdunit) {
            abort(403);
        }
        if ($id->status != 'draft') {
            return redirect('/belanja-51-pusat/uang-makan/permohonan')->with('gagal', 'data tidak dapat di kirim');
        }
        $id->update([
            'status' => 'proses',
        ]);
        $id->history()->create([
            'action' => 'kirim',
            'nip' => Auth::user()->nip,
            'nama' => Auth::user()->nama,
        ]);
        return redirect('/belanja-51-pusat/uang-makan/permohonan')->with('berhasil', 'data berhasil di kirim');
    }
    public function batal(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat'];
        } else {
            $gate = [];
        }
        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->kdsatker != auth()->user()->kdsatker || $id->kdunit != auth()->user()->kdunit) {
            abort(403);
        }
        if ($id->status != 'proses') {
            return redirect('/belanja-51-pusat/uang-makan/arsip')->with('gagal', 'data tidak dapat dibatalkan');
        }
        $id->update([
            'status' => 'draft',
        ]);
        $id->history()->create([
            'action' => 'batal',
            'nip' => Auth::user()->nip,
            'nama' => Auth::user()->nama,
        ]);
        return redirect('/belanja-51-pusat/uang-makan/arsip')->with('berhasil', 'data berhasil dibatalkan');
    }
    public function history(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat'];
        } else {
            $gate = [];
        }
        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->kdsatker != auth()->user()->kdsatker || $id->kdunit != auth()->user()->kdunit) {
            abort(403);
        }

        return view('belanja-51-pusat.uang_makan.history', [
            'data' => $id->history()->get(),
            'pageTitle' => $id->uraian,
            'back' => '/belanja-51-pusat/uang-makan/arsip',
            'notifBelanja51Tolak' => NotifikasiBelanja51::NotifikasiPusat(auth()->user()->kdsatker, auth()->user()->kdunit),
        ]);
    }

    public function regenerateSurat(PermohonanBelanja51 $id){
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat'];
        } else {
            $gate = [];
        }
        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->kdsatker != auth()->user()->kdsatker || $id->kdunit != auth()->user()->kdunit) {
            abort(403);
        }
        if ($id->status != 'draft') {
            return redirect('/belanja-51-pusat/uang-makan/permohonan')->with('gagal', 'data tidak dapat diproses');
        }
        $kop = Kop::where('kdsatker', auth()->user()->kdsatker)
            ->where('kdunit', auth()->user()->kdunit)
            ->first();
        ob_start();
        $html2pdf = ob_get_clean();
        $html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', [18, 15, 15, 15], true);
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle($id->uraian);
        $html2pdf->writeHTML(
            view('belanja-51-pusat.uang_makan.document.permohonan', [
                'data' => $id->dataMakan()->rekap()->get(),
                'permohonan' => $id,
                'nomor' => $id->nomor,
                'kop' => $kop,
                'tanggal' => $id->tanggal,
            ]),
        );
        $register = $html2pdf->output('', 'S');
        $filename = 'permohonan/file/' . Str::uuid() . '.pdf';
        Storage::put($filename, $register);
        ob_clean();
        return redirect()->back()->with('berhasil', 'generate ulang surat berhasil');
    }

    public function regenerateLampiran(PermohonanBelanja51 $id, FilePermohonanBelanja51 $file)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat'];
        } else {
            $gate = [];
        }
        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->kdsatker != auth()->user()->kdsatker || $id->kdunit != auth()->user()->kdunit) {
            abort(403);
        }
        if ($id->status != 'draft') {
            return redirect('/belanja-51-pusat/uang-makan/permohonan')->with('gagal', 'data tidak dapat di proses');
        }
        $kop = Kop::where('kdsatker', auth()->user()->kdsatker)
            ->where('kdunit', auth()->user()->kdunit)
            ->first();
        $daysInMonth = Carbon::create($id->tahun, $id->bulan, 1)->daysInMonth;
        $dataAbsensi = $id->dataMakan()->RekapTanggal();
        ob_start();
        $html2pdf = ob_get_clean();
        $html2pdf = new Html2Pdf('L', 'F4', 'en', false, 'UTF-8', [10, 15, 10, 15], true);
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('Lampiran ' . $id->uraian);
        $html2pdf->writeHTML(
            view('belanja-51-pusat.uang_makan.document.lampiran', [
                'data' => $dataAbsensi,
                'daysInMonth' => $daysInMonth,
                'thn' => $id->tahun,
                'bln' => $id->bulan,
                'permohonan' => $id,
                'nomor' => $id->nomor,
                'kop' => $kop,
                'tanggal' => $id->tanggal,
            ]),
        );
        $register = $html2pdf->output('', 'S');
        Storage::put($file->file, $register);
        ob_clean();
        return redirect()->back()->with('berhasil', 'generate ulang lampiran berhasil');
    }
}
