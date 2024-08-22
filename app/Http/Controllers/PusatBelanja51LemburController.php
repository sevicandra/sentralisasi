<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermohonanBelanja51;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class PusatBelanja51LemburController extends Controller
{
    public function index()
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        $data = PermohonanBelanja51::DraftLemburPusat(auth()->user()->kdsatker, auth()->user()->kdunit)->paginate(15)->withQueryString();
        return view('belanja-51-pusat.uang_lembur.index', [
            'data' => $data,
            'pageTitle' => 'Uang Lembur',
        ]);
    }
    public function arsip()
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        $data = PermohonanBelanja51::ArsipLemburPusat(auth()->user()->kdsatker, auth()->user()->kdunit)->paginate(15)->withQueryString();
        return view('belanja-51-pusat.uang_lembur.arsip.index', [
            'data' => $data,
            'pageTitle' => 'Uang Lembur',
        ]);
    }
    public function detail(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->kdsatker != auth()->user()->kdsatker || $id->kdunit != auth()->user()->kdunit) {
            abort(403);
        }
        return view('belanja-51-pusat.uang_lembur.detail', [
            'permohonan' => PermohonanBelanja51::with(['lampiran'])->find($id->id),
            'pageTitle' => $id->uraian,
            'spkl' => $id->spkl,
            'sptjm' => $id->sptjm,
            'lpt' => $id->lpt,
        ]);
    }
    public function detailArsip(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->kdsatker != auth()->user()->kdsatker || $id->kdunit != auth()->user()->kdunit) {
            abort(403);
        }
        return view('belanja-51-pusat.uang_lembur.arsip.detail', [
            'permohonan' => PermohonanBelanja51::with(['dokumen', 'lampiran'])->find($id->id),
            'pageTitle' => $id->uraian,
        ]);
    }
    public function destroy(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->kdsatker != auth()->user()->kdsatker || $id->kdunit != auth()->user()->kdunit) {
            abort(403);
        }
        if ($id->status != 'draft') {
            return redirect('/belanja-51-pusat/uang-lembur/permohonan')->with('gagal', 'data tidak dapat di hapus');
        }
        $id->delete();
        return redirect('/belanja-51-pusat/uang-lembur/permohonan')->with('berhasil', 'data berhasil di hapus');
    }
    public function kirim(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->kdsatker != auth()->user()->kdsatker || $id->kdunit != auth()->user()->kdunit) {
            abort(403);
        }
        if ($id->status != 'draft') {
            return redirect('/belanja-51-pusat/uang-lembur/permohonan')->with('gagal', 'data tidak dapat di kirim');
        }
        if (!$id->lpt || !$id->spkl || !$id->sptjm) {
            return redirect('/belanja-51-pusat/uang-lembur/permohonan')->with('gagal', 'data tidak dapat di kirim, lampiran tidak lengkap');
        }
        $id->update([
            'status' => 'proses',
        ]);
        $id->history()->create([
            'action' => 'kirim',
            'nip' => Auth::user()->nip,
            'nama' => Auth::user()->nama,
        ]);
        return redirect('/belanja-51-pusat/uang-lembur/permohonan')->with('berhasil', 'data berhasil di kirim');
    }
    public function batal(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->kdsatker != auth()->user()->kdsatker || $id->kdunit != auth()->user()->kdunit) {
            abort(403);
        }
        if ($id->status != 'proses') {
            return redirect('/belanja-51-pusat/uang-lembur/arsip')->with('gagal', 'data tidak dapat dibatalkan');
        }
        $id->update([
            'status' => 'draft',
        ]);
        $id->history()->create([
            'action' => 'batal',
            'nip' => Auth::user()->nip,
            'nama' => Auth::user()->nama,
        ]);
        return redirect('/belanja-51-pusat/uang-lembur/arsip')->with('berhasil', 'data berhasil dibatalkan');
    }
    public function history(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->kdsatker != auth()->user()->kdsatker || $id->kdunit != auth()->user()->kdunit) {
            abort(403);
        }


        return view('belanja-51-pusat.uang_lembur.history', [
            'data' => $id->history()->get(),
            'pageTitle' => $id->uraian,
            'back' => '/belanja-51-pusat/uang-lembur/arsip',
        ]);
    }
    public function uploadSPKL(PermohonanBelanja51 $id, Request $request)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->kdsatker != auth()->user()->kdsatker) {
            abort(403);
        }
        if ($id->status != 'draft') {
            abort(403);
        }
        $validator = Validator::make($request->all(), [
            'spkl' => 'required|mimetypes:application/pdf|file|max:10240',
        ], [
            'spkl.mimetypes' => 'file harus berupa pdf',
            'spkl.max' => 'file tidak boleh lebih dari 10 MB',
            'spkl.required' => 'file tidak boleh kosong',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('gagal', $validator->errors()->all()[0]);
        }
        $path = $request->file('spkl')->store('permohonan/lampiran');
        $id->spkl()->create([
            'type' => 'spkl',
            'nama' => 'Surat Perintah Kerja Lembur ' . $id->uraian,
            'file' => $path,
        ]);

        return redirect()->back()->with('berhasil', 'data lampiran SPKL berhasil di upload');
    }
    public function uploadSPTJM(PermohonanBelanja51 $id, Request $request)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->kdsatker != auth()->user()->kdsatker) {
            abort(403);
        }
        if ($id->status != 'draft') {
            abort(403);
        }
        $validator = Validator::make($request->all(), [
            'sptjm' => 'required|mimetypes:application/pdf|file|max:10240',
        ], [
            'sptjm.mimetypes' => 'file harus berupa pdf',
            'sptjm.max' => 'file tidak boleh lebih dari 10 MB',
            'sptjm.required' => 'file tidak boleh kosong',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('gagal', $validator->errors()->all()[0]);
        }
        $path = $request->file('sptjm')->store('permohonan/lampiran');
        $id->sptjm()->create([
            'type' => 'sptjm',
            'nama' => 'Surat Pernyataan Tanggung Jawab ' . $id->uraian,
            'file' => $path,
        ]);

        return redirect()->back()->with('berhasil', 'data lampiran SPTJM berhasil di upload');
    }
    public function uploadLPT(PermohonanBelanja51 $id, Request $request)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->kdsatker != auth()->user()->kdsatker) {
            abort(403);
        }
        if ($id->status != 'draft') {
            abort(403);
        }
        $validator = Validator::make($request->all(), [
            'lpt' => 'required|mimetypes:application/pdf|file|max:10240',
        ], [
            'lpt.mimetypes' => 'file harus berupa pdf',
            'lpt.max' => 'file tidak boleh lebih dari 10 MB',
            'lpt.required' => 'file tidak boleh kosong',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('gagal', $validator->errors()->all()[0]);
        }
        $path = $request->file('lpt')->store('permohonan/lampiran');
        $id->lpt()->create([
            'type' => 'lpt',
            'nama' => 'Laporan Pelaksanaan Tugas ' . $id->uraian,
            'file' => $path,
        ]);

        return redirect()->back()->with('berhasil', 'data lampiran LPT berhasil di upload');
    }
    public function deleteSPKL(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->kdsatker != auth()->user()->kdsatker || $id->kdunit != auth()->user()->kdunit) {
            abort(403);
        }
        if ($id->status != 'draft') {
            abort(403);
        }
        $id->spkl->delete();
        return redirect()->back()->with('berhasil', 'data lampiran SPKL berhasil di hapus');
    }
    public function deleteSPTJM(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->kdsatker != auth()->user()->kdsatker || $id->kdunit != auth()->user()->kdunit) {
            abort(403);
        }
        if ($id->status != 'draft') {
            abort(403);
        }
        $id->sptjm->delete();
        return redirect()->back()->with('berhasil', 'data lampiran SPTJM berhasil di upload');
    }
    public function deleteLPT(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->kdsatker != auth()->user()->kdsatker || $id->kdunit != auth()->user()->kdunit) {
            abort(403);
        }
        if ($id->status != 'draft') {
            abort(403);
        }
        $id->lpt->delete();
        return redirect()->back()->with('berhasil', 'data lampiran LPT berhasil di upload');
    }
}
