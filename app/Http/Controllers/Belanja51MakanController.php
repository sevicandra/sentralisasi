<?php

namespace App\Http\Controllers;

use Spipu\Html2Pdf\Html2Pdf;
use App\Models\PermohonanBelanja51;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class Belanja51MakanController extends Controller
{
    public function index()
    {
        if (Auth::guard('web')->check()) {
            $gate = ['plt_admin_satker', 'opr_belanja_51', 'approver'];
        } else {
            $gate = ['admin_satker'];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        $data = PermohonanBelanja51::DraftMakan(auth()->user()->kdsatker)->paginate(15)->withQueryString();
        return view('belanja-51.uang_makan.index', [
            'data' => $data
        ]);
    }
    public function arsip()
    {
        if (Auth::guard('web')->check()) {
            $gate = ['plt_admin_satker', 'opr_belanja_51', 'approver'];
        } else {
            $gate = ['admin_satker'];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        $data = PermohonanBelanja51::ArsipMakan(auth()->user()->kdsatker)->paginate(15)->withQueryString();
        return view('belanja-51.uang_makan.arsip.index', [
            'data' => $data
        ]);
    }
    public function detail(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['plt_admin_satker', 'opr_belanja_51', 'approver'];
        } else {
            $gate = ['admin_satker'];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->kdsatker != auth()->user()->kdsatker) {
            abort(403);
        }
        return view('belanja-51.uang_makan.detail', [
            'permohonan' => PermohonanBelanja51::with(['lampiran', 'history'])->find($id->id),
        ]);
    }
    public function detailArsip(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['plt_admin_satker', 'opr_belanja_51', 'approver'];
        } else {
            $gate = ['admin_satker'];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->kdsatker != auth()->user()->kdsatker) {
            abort(403);
        }
        return view('belanja-51.uang_makan.arsip.detail', [
            'permohonan' => PermohonanBelanja51::with(['lampiran', 'history'])->find($id->id),
        ]);
    }
    public function destroy(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['plt_admin_satker', 'opr_belanja_51', 'approver'];
        } else {
            $gate = ['admin_satker'];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->kdsatker != auth()->user()->kdsatker) {
            abort(403);
        }
        if ($id->status != 'draft') {
            return redirect('/belanja-51-v2/uang-makan/permohonan')->with('gagal', 'data tidak dapat di hapus');
        }
        $id->delete();
        return redirect('/belanja-51-v2/uang-makan/permohonan')->with('berhasil', 'data berhasil di hapus');
    }
    public function kirim(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['plt_admin_satker', 'opr_belanja_51', 'approver'];
        } else {
            $gate = ['admin_satker'];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->kdsatker != auth()->user()->kdsatker) {
            abort(403);
        }
        if ($id->status != 'draft') {
            return redirect('/belanja-51-v2/uang-makan/permohonan')->with('gagal', 'data tidak dapat di kirim');
        }
        $id->update([
            'status' => 'proses',
        ]);
        return redirect('/belanja-51-v2/uang-makan/permohonan')->with('berhasil', 'data berhasil di kirim');
    }
    public function batal(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['plt_admin_satker', 'opr_belanja_51', 'approver'];
        } else {
            $gate = ['admin_satker'];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->kdsatker != auth()->user()->kdsatker) {
            abort(403);
        }
        if ($id->status != 'proses') {
            return redirect('/belanja-51-v2/uang-makan/arsip')->with('gagal', 'data tidak dapat dibatalkan');
        }
        $id->update([
            'status' => 'draft',
        ]);
        return redirect('/belanja-51-v2/uang-makan/arsip')->with('berhasil', 'data berhasil dibatalkan');
    }
}
