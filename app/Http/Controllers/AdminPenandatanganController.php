<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\AlikaNew\Profil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;

class AdminPenandatanganController extends Controller
{
    public function index()
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin', 'plt_admin_satker'];
        } else {
            $gate = ['admin_satker'];
        }
        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        return view('admin.penandatangan.index', [
            'data' => Profil::get(auth()->user()->kdsatker)
        ]);
    }

    public function create()
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin', 'plt_admin_satker'];
        } else {
            $gate = ['admin_satker'];
        }
        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        return view('admin.penandatangan.create');
    }

    public function store(Request $request)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin', 'plt_admin_satker'];
        } else {
            $gate = ['admin_satker'];
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
            $response = Profil::post([
                'tahun' => $request->tahun,
                'kdsatker' => auth()->user()->kdsatker,
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
            ]);

            if ($response->failed()) {
                throw new \Exception($response);
            }
            Cache::forget('alikaProfil_' . auth()->user()->kdsatker . '_');
            Cache::forget('alikaProfil_' . auth()->user()->kdsatker . '_'. $request->tahun);
            return redirect('/admin/penandatangan')->with('berhasil', 'Penandatangan berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect('/admin/penandatangan')->with('gagal', $th->getMessage());
        }
    }

    public function edit($id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin', 'plt_admin_satker'];
        } else {
            $gate = ['admin_satker'];
        }
        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        $data = Profil::getPenandatangan($id)->data;
        if ($data->kdsatker != auth()->user()->kdsatker) {
            abort(403);
        }
        return view('admin.penandatangan.edit', [
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin', 'plt_admin_satker'];
        } else {
            $gate = ['admin_satker'];
        }
        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if (Profil::getPenandatangan($id)->data->kdsatker != auth()->user()->kdsatker) {
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
            $response = Profil::put($id, [
                'tahun' => $request->tahun,
                'kdsatker' => auth()->user()->kdsatker,
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
            ]);
            if ($response->failed()) {
                throw new \Exception($response);
            }
            Cache::forget('alikaProfil_' . auth()->user()->kdsatker . '_');
            Cache::forget('alikaProfil_' . auth()->user()->kdsatker . '_'. $request->tahun);
            return redirect('/admin/penandatangan')->with('berhasil', 'Penandatangan berhasil diubah');
        } catch (\Throwable $th) {
            return redirect('/admin/penandatangan')->with('gagal', $th->getMessage());
        }
    }
}
