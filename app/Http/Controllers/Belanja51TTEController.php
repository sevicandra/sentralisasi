<?php

namespace App\Http\Controllers;

use App\Helper\Esign\Tte;
use Illuminate\Http\Request;
use App\Models\PermohonanBelanja51;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class Belanja51TTEController extends Controller
{
    public function index()
    {
        if (Auth::guard('web')->check()) {
            $gate = ['approver'];
        } else {
            $gate = ['admin_satker'];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        $data = PermohonanBelanja51::TTE(auth()->user()->nip)->paginate(15)->withQueryString();
        return view('belanja-51.TTE.index', [
            'data' => $data,
            'pageTitle' => 'TTE',
        ]);
    }

    public function detail(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51', 'approver'];
        } else {
            $gate = ['admin_satker'];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->nip != auth()->user()->nip || $id->status != 'proses') {
            abort(403);
        }
        return view('belanja-51.TTE.detail', [
            'permohonan' => PermohonanBelanja51::with(['dokumen', 'lampiran'])->find($id->id),
            'pageTitle' => $id->uraian,
        ]);
    }

    public function tolak(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51', 'approver'];
        } else {
            $gate = ['admin_satker'];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->nip != auth()->user()->nip || $id->status != 'proses') {
            abort(403);
        }
        $id->update([
            'status' => 'draft',
        ]);
        $id->history()->create([
            'action' => 'tolak',
            'nip' => Auth::user()->nip,
            'nama' => Auth::user()->nama,
        ]);
        return redirect('/belanja-51-v2/tte')->with('berhasil', 'data berhasil ditolak');
    }

    public function TTE(PermohonanBelanja51 $id, Request $request)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51', 'approver'];
        } else {
            $gate = ['admin_satker'];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->nip != auth()->user()->nip || $id->status != 'proses') {
            abort(403);
        }
       
        try {
            $tte = new Tte();
            $result = $tte->esign([
                'tujuan' => "Sekretaris Direktorat Jenderal Kekayaan Negara c.q. Kepala Bagian Keuangan",
                'nomor' => $id->nomor,
                'jenis_dokumen' => "Register Permohonan Uang Makan",
                'perihal' => $id->uraian,
                'linkQR' => config('app.url') . '/belanja-51-v2/document/' . $id->file,
                'file' => $id->file,
            ], session('nik'), $request->passphrase);
            $result_body = $result->getBody()->getContents();
            Storage::put($id->file, $result_body);
            $id->history()->create([
                'action' => 'tte',
                'nip' => Auth::user()->nip,
                'nama' => Auth::user()->nama,
            ]);
            $id->dokumen()->update([
                'status' => 'proses',
            ]);
            $id->update([
                'status' => 'kirim',
            ]);
            foreach ($id->lampiran as $item) {
                $item->TTE($id->nomor, session('nik'), $request->passphrase);
            }
            foreach ($id->dokumen as $item) {
                $item->TTEAxis($id->nomor, session('nik'), $request->passphrase);
            }
            return redirect('/belanja-51-v2/tte')->with('berhasil', 'data berhasil dikirim');
        } catch (\GuzzleHttp\Exception\ClientException $th) {
            $response = $th->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents(), true);
            return redirect('/belanja-51-v2/tte')->with('gagal', $responseBodyAsString['error']);
        }
    }

    public function arsip()
    {
        if (Auth::guard('web')->check()) {
            $gate = ['approver'];
        } else {
            $gate = ['admin_satker'];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        $data = PermohonanBelanja51::ArsipTTE(auth()->user()->nip)->paginate(15)->withQueryString();
        return view('belanja-51.TTE.arsip.index', [
            'data' => $data,
            'pageTitle' => 'TTE',
        ]);
    }

    public function detailArsip(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51', 'approver'];
        } else {
            $gate = ['admin_satker'];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->nip != auth()->user()->nip || ($id->status != 'kirim' && $id->status != 'approve' && $id->status != 'reject')) {
            abort(403);
        }

        return view('belanja-51.TTE.arsip.detail', [
            'permohonan' => PermohonanBelanja51::with(['dokumen', 'lampiran'])->find($id->id),
            'pageTitle' => $id->uraian,
        ]);
    }

    public function history(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51', 'approver'];
        } else {
            $gate = ['admin_satker'];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->nip != auth()->user()->nip) {
            abort(403);
        }


        return view('belanja-51.uang_makan.history', [
            'data' => $id->history()->get(),
            'pageTitle' => $id->uraian,
            'back' => '/belanja-51-v2/tte/arsip',
        ]);
    }
}
