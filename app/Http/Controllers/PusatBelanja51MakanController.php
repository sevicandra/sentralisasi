<?php

namespace App\Http\Controllers;

use App\Models\NotifikasiBelanja51;
use App\Models\PermohonanBelanja51;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PusatBelanja51MakanController extends Controller
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
        $data = PermohonanBelanja51::DraftMakanPusat(auth()->user()->kdsatker, auth()->user()->kdunit)->paginate(15)->withQueryString();
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
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        $data = PermohonanBelanja51::ArsipMakanPusat(auth()->user()->kdsatker, auth()->user()->kdunit)->paginate(15)->withQueryString();
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
        if (! Gate::any($gate, auth()->user()->id)) {
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
        if (! Gate::any($gate, auth()->user()->id)) {
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
        if (! Gate::any($gate, auth()->user()->id)) {
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
        if (! Gate::any($gate, auth()->user()->id)) {
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
        if (! Gate::any($gate, auth()->user()->id)) {
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
        if (! Gate::any($gate, auth()->user()->id)) {
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
}
