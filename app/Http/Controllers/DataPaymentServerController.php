<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\dataHonorarium;
// use App\Helper\Alika\API2\dataLain;
use App\Helper\AlikaNew\PenghasilanLain;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\dataPembayaranLainnya;
use Illuminate\Pagination\LengthAwarePaginator;


class DataPaymentServerController extends Controller
{
    public function index()
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [''];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        $limit = 15;
        if (request('page')) {
            $offset = (request('page') - 1) * $limit;
        } else {
            $offset = 0;
        }

        if (request('nip')) {
            $dataLain = PenghasilanLain::getAll(request('nip'), request('tahun'), $limit, $offset)->data;
            $count = PenghasilanLain::count(request('nip'), request('tahun'))->data;
        } else {
            $dataLain = PenghasilanLain::getAll(null, null, $limit, $offset)->data;
            $count = PenghasilanLain::count()->data;
        }
        $data = $this->paginate($dataLain, $limit, request('page'), $count, ['path' => ' '])->withQueryString();

        return view('data-payment.server.index', [
            'data' => $data,
            'pageTitle' => 'Data Server',
            'honorariumKirim' => dataHonorarium::send(),
            'dataPembayaranLainnyaDraft' => dataPembayaranLainnya::draft(),
        ]);
    }

    public function edit($id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['adm_server'];
        } else {
            $gate = [''];
        }

        if (!Gate::allows($gate, auth()->user()->id)) {
            abort(403);
        }

        return view('data-payment.server.edit', [
            'data' => PenghasilanLain::getById($id)->data,
            'pageTitle' => 'Edit Data Server',
            'honorariumKirim' => dataHonorarium::send(),
            'dataPembayaranLainnyaDraft' => dataPembayaranLainnya::draft(),
        ]);
    }

    public function update(Request $request, $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['adm_server'];
        } else {
            $gate = [''];
        }

        if (!Gate::allows($gate, auth()->user()->id)) {
            abort(403);
        }
        $request->validate([
            'bulan' => 'required||min:2|max:2',
            'tahun' => 'required|min:4|max:4',
            'kdsatker' => 'required|min:6|max:6',
            'nip' => 'required|min:18|max:18',
            'bruto' => 'required|numeric',
            'netto' => 'required|numeric',
            'jenis' => 'required',
            'uraian' => 'required',
            'tanggal' => 'required',
        ]);

        $request->validate([
            'bulan' => 'numeric',
            'tahun' => 'numeric',
            'kdsatker' => 'numeric',
            'nip' => 'numeric',
        ]);
        try {
            $response   = PenghasilanLain::put($id, [
                'bulan' => $request->bulan,
                'tahun' => $request->tahun,
                'kdsatker' => $request->kdsatker,
                'nip' => $request->nip,
                'bruto' => $request->bruto,
                'pph' => $request->pph,
                'netto' => $request->netto,
                'jenis' => $request->jenis,
                'uraian' => $request->uraian,
                'tanggal' => $request->tanggal,
                'nospm' => $request->nospm ?? null,
            ]);
            if ($response->failed()) {
                throw new \Exception($response);
            }
        } catch (\Throwable $e) {
            return redirect('/data-payment/server')->with('gagal', $e->getMessage());
        }
        return redirect('/data-payment/server')->with('berhasil', 'Selamat Data Berhasil di Ubah');
    }

    public function delete($id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['adm_server'];
        } else {
            $gate = [''];
        }

        if (!Gate::allows($gate, auth()->user()->id)) {
            abort(403);
        }
        try {
            $response = PenghasilanLain::destroy($id);
            if ($response->getStatusCode() != 200) {
                throw new \Exception($response);
            }
        } catch (\Throwable $e) {
            return redirect('/data-payment/server')->with('gagal', $e->getMessage());
        }
        return redirect('/data-payment/server')->with('berhasil', 'Selamat Data Berhasil di Hapus');
    }

    public function paginate($items, $perPage = 15, $page = null, $count, $options = [])
    {
        return new LengthAwarePaginator($items, $count, $perPage, $page, $options);
    }
}
