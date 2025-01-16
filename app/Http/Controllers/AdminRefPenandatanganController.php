<?php

namespace App\Http\Controllers;

use App\Models\satker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Helper\AlikaNew\Profil;

// API Alika Old
use App\Helper\Alika\API2\dataPenandatangan;

use Illuminate\Support\Facades\Cache;

class AdminRefPenandatanganController extends Controller
{
    public function index()
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        return view('admin.refPenandatangan.index', [
            'data' => satker::search()->order()->paginate(15)->withQueryString(),
            'pageTitle' => 'Ref Penandatangan',

        ]);
    }

    public function satker($kdsatker)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        // $data = Profil::get($kdsatker)->data;
        $data = dataPenandatangan::getDataPenandatangan($kdsatker);
        return view('admin.refPenandatangan.detail', [
            'data' => $data,
            'kdsatker' => $kdsatker,
        ]);
    }

    public function create($kdsatker)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        return view('admin.refPenandatangan.create', [
            'kdsatker' => $kdsatker,
        ]);
    }

    public function store(Request $request, $kdsatker)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $request->validate([
            'tahun' => 'required|min_digits:4|max_digits:4',
            'nama_ttd_skp' => 'required',
            'nip_ttd_skp' => 'required|min_digits:18|max_digits:18',
            'jab_ttd_skp' => 'required',
            'nama_ttd_kp4' => 'required',
            'nip_ttd_kp4' => 'required|min_digits:18|max_digits:18',
            'jab_ttd_kp4' => 'required',
            'npwp_bendahara' => 'required|min_digits:15|max_digits:16',
            'nama_bendahara' => 'required',
            'nip_bendahara' => 'required|min_digits:18|max_digits:18',
            'tgl_spt' => 'required|date_format:Y-m-d'
        ], [
            'tahun.required' => 'Tahun harus diisi',
            'nama_ttd_skp.required' => 'Nama TTD SKP harus diisi',
            'nip_ttd_skp.required' => 'NIP TTD SKP harus diisi',
            'jab_ttd_skp.required' => 'Jabatan TTD SKP harus diisi',
            'nama_ttd_kp4.required' => 'Nama TTD KP4 harus diisi',
            'nip_ttd_kp4.required' => 'NIP TTD KP4 harus diisi',
            'jab_ttd_kp4.required' => 'Jabatan TTD KP4 harus diisi',
            'npwp_bendahara.required' => 'NPWP Bendahara harus diisi',
            'nama_bendahara.required' => 'Nama Bendahara harus diisi',
            'nip_bendahara.required' => 'NIP Bendahara harus diisi',
            'tgl_spt.required' => 'Tanggal SPT harus diisi',
            'tgl_spt.date_format' => 'Format tanggal salah',
            'tahun.min_digits' => 'Tahun minimal 4 digit',
            'tahun.max_digits' => 'Tahun maksimal 4 digit',
            'nip_ttd_skp.min_digits' => 'NIP TTD SKP minimal 18 digit',
            'nip_ttd_skp.max_digits' => 'NIP TTD SKP maksimal 18 digit',
            'nip_ttd_kp4.min_digits' => 'NIP TTD KP4 minimal 18 digit',
            'nip_ttd_kp4.max_digits' => 'NIP TTD KP4 maksimal 18 digit',
            'nip_bendahara.min_digits' => 'NIP Bendahara minimal 18 digit',
            'nip_bendahara.max_digits' => 'NIP Bendahara maksimal 18 digit',
            'npwp_bendahara.min_digits' => 'NPWP Bendahara minimal 15 digit',
            'npwp_bendahara.max_digits' => 'NPWP Bendahara maksimal 16 digit',
        ]);
        try {
            // $response = Profil::post([
            //     'tahun' => $request->tahun,
            //     'kdsatker' => $request->kdsatker,
            //     'nama_ttd_skp' => $request->nama_ttd_skp,
            //     'nip_ttd_skp' => $request->nip_ttd_skp,
            //     'jab_ttd_skp' => $request->jab_ttd_skp,
            //     'nama_ttd_kp4' => $request->nama_ttd_kp4,
            //     'nip_ttd_kp4' => $request->nip_ttd_kp4,
            //     'jab_ttd_kp4' => $request->jab_ttd_kp4,
            //     'npwp_bendahara' => $request->npwp_bendahara,
            //     'nama_bendahara' => $request->nama_bendahara,
            //     'nip_bendahara' => $request->nip_bendahara,
            //     'tgl_spt' => $request->tgl_spt
            // ]);

            $response = dataPenandatangan::CreateDataPenandatangan([
                'tahun' => $request->tahun,
                'kdsatker' => $kdsatker,
                'nama_ttd_skp' => $request->nama_ttd_skp,
                'nip_ttd_skp' => $request->nip_ttd_skp,
                'jab_ttd_skp' => $request->jab_ttd_skp,
                'nama_ttd_kp4' => $request->nama_ttd_kp4,
                'nip_ttd_kp4' => $request->nip_ttd_kp4,
                'jab_ttd_kp4' => $request->jab_ttd_kp4,
                'npwp_bendahara' => $request->npwp_bendahara,
                'nama_bendahara' => $request->nama_bendahara,
                'nip_bendahara' => $request->nip_bendahara,
                'tgl_spt' => $request->tgl_spt,
            ]);

            if ($response->failed()) {
                throw new \Exception($response);
            }
            Cache::forget('alikaProfil_' . $kdsatker . '_');
            Cache::forget('alikaProfil_' . $kdsatker . '_' . $request->tahun);
            return redirect('/admin/penandatangan')->with('berhasil', 'Penandatangan berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect('/admin/penandatangan')->with('gagal', $th->getMessage());
        }
    }

    public function edit($kdsatker, $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        // $data = Profil::getPenandatangan($id)->data;
        $data = dataPenandatangan::getPenandatangan($id);
        return view('admin.penandatangan.edit', [
            'data' => $data,
        ]);
    }

    public function update(Request $request, $kdsatker, $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $request->validate([
            'tahun' => 'required|min_digits:4|max_digits:4',
            'nama_ttd_skp' => 'required',
            'nip_ttd_skp' => 'required|min_digits:18|max_digits:18',
            'jab_ttd_skp' => 'required',
            'nama_ttd_kp4' => 'required',
            'nip_ttd_kp4' => 'required|min_digits:18|max_digits:18',
            'jab_ttd_kp4' => 'required',
            'npwp_bendahara' => 'required|min_digits:15|max_digits:16',
            'nama_bendahara' => 'required',
            'nip_bendahara' => 'required|min_digits:18|max_digits:18',
            'tgl_spt' => 'required|date_format:Y-m-d'
        ], [
            'tahun.required' => 'Tahun harus diisi',
            'nama_ttd_skp.required' => 'Nama TTD SKP harus diisi',
            'nip_ttd_skp.required' => 'NIP TTD SKP harus diisi',
            'jab_ttd_skp.required' => 'Jabatan TTD SKP harus diisi',
            'nama_ttd_kp4.required' => 'Nama TTD KP4 harus diisi',
            'nip_ttd_kp4.required' => 'NIP TTD KP4 harus diisi',
            'jab_ttd_kp4.required' => 'Jabatan TTD KP4 harus diisi',
            'npwp_bendahara.required' => 'NPWP Bendahara harus diisi',
            'nama_bendahara.required' => 'Nama Bendahara harus diisi',
            'nip_bendahara.required' => 'NIP Bendahara harus diisi',
            'tgl_spt.required' => 'Tanggal SPT harus diisi',
            'tgl_spt.date_format' => 'Format tanggal salah',
            'tahun.min_digits' => 'Tahun minimal 4 digit',
            'tahun.max_digits' => 'Tahun maksimal 4 digit',
            'nip_ttd_skp.min_digits' => 'NIP TTD SKP minimal 18 digit',
            'nip_ttd_skp.max_digits' => 'NIP TTD SKP maksimal 18 digit',
            'nip_ttd_kp4.min_digits' => 'NIP TTD KP4 minimal 18 digit',
            'nip_ttd_kp4.max_digits' => 'NIP TTD KP4 maksimal 18 digit',
            'nip_bendahara.min_digits' => 'NIP Bendahara minimal 18 digit',
            'nip_bendahara.max_digits' => 'NIP Bendahara maksimal 18 digit',
            'npwp_bendahara.min_digits' => 'NPWP Bendahara minimal 15 digit',
            'npwp_bendahara.max_digits' => 'NPWP Bendahara maksimal 16 digit',
        ]);
        try {
            // $response = Profil::put($id, [
            //     'tahun' => $request->tahun,
            //     'kdsatker' => $request->kdsatker,
            //     'nama_ttd_skp' => $request->nama_ttd_skp,
            //     'nip_ttd_skp' => $request->nip_ttd_skp,
            //     'jab_ttd_skp' => $request->jab_ttd_skp,
            //     'nama_ttd_kp4' => $request->nama_ttd_kp4,
            //     'nip_ttd_kp4' => $request->nip_ttd_kp4,
            //     'jab_ttd_kp4' => $request->jab_ttd_kp4,
            //     'npwp_bendahara' => $request->npwp_bendahara,
            //     'nama_bendahara' => $request->nama_bendahara,
            //     'nip_bendahara' => $request->nip_bendahara,
            //     'tgl_spt' => $request->tgl_spt
            // ]);

            $response = dataPenandatangan::UpdateDataPenandatangan([
                'tahun' => $request->tahun,
                'kdsatker' => $kdsatker,
                'nama_ttd_skp' => $request->nama_ttd_skp,
                'nip_ttd_skp' => $request->nip_ttd_skp,
                'jab_ttd_skp' => $request->jab_ttd_skp,
                'nama_ttd_kp4' => $request->nama_ttd_kp4,
                'nip_ttd_kp4' => $request->nip_ttd_kp4,
                'jab_ttd_kp4' => $request->jab_ttd_kp4,
                'npwp_bendahara' => $request->npwp_bendahara,
                'nama_bendahara' => $request->nama_bendahara,
                'nip_bendahara' => $request->nip_bendahara,
                'tgl_spt' => $request->tgl_spt
            ], $id);

            if ($response->failed()) {
                throw new \Exception($response);
            }
            Cache::forget('alikaProfil_' . $kdsatker . '_');
            Cache::forget('alikaProfil_' . $kdsatker . '_' . $request->tahun);
            return redirect('/admin/penandatangan')->with('berhasil', 'Penandatangan berhasil diubah');
        } catch (\Throwable $th) {
            return redirect('/admin/penandatangan')->with('gagal', $th->getMessage());
        }
    }
}
