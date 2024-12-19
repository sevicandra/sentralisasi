<?php

namespace App\Http\Controllers;

use App\Models\satker;
use Illuminate\Http\Request;
use App\Helper\AlikaNew\RefJabatan;
use App\Helper\AlikaNew\RefPangkat;
use App\Helper\AlikaNew\SPTPegawai;

// API Alika Old
use App\Helper\Alika\API2\dataSpt;
use App\Helper\Alika\API2\refPangkat as RefPangkatOld;
use App\Helper\Alika\API2\refJabatan as RefJabatanOld;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;

class SptMonitoringController extends Controller
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

        return view('spt.monitoring.index', [
            'data' => satker::search()->order()->paginate(15)->withQueryString(),
            "pageTitle" => "Monitoring SPT",
        ]);
    }

    public function satker(satker $satker)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
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
        // $tahun = SPTPegawai::tahunByKdSatker($satker->kdsatker)->data;
        $tahun = dataSpt::getTahun(auth()->user()->kdsatker);
        if (!request('thn')) {
            $thn = collect($tahun)->last()->tahun;
        } else {
            $thn = request('thn');
        };
        // $spt = SPTPegawai::getByKdSatker($satker->kdsatker, $thn, $limit, $offset, request('nip'))->data;
        $data_spt= collect(dataSpt::getDataSpt(auth()->user()->kdsatker, $thn, $limit, $offset));
        if (request('nip')) {
            $data_spt = $data_spt->where('nip', request('nip'));
        }
        $spt = $data_spt->map(function ($item) {
            return (object) [
                'id' => $item->id,
                'npwp' => $item->npwp,
                'nama_pangkat' => $item->nmgol,
                'nama_jabatan'=> $item->nm_jabatan,
                'kdkawin' => $item->kdkawin,
                'alamat' => $item->alamat,
                'nip' => $item->nip,
            ];
        });
        // $count = SPTPegawai::countByKdSatker($satker->kdsatker, $thn)->data;
        $count = collect(dataSpt::getDataSpt(auth()->user()->kdsatker, $thn))->count();
        $data = $this->paginate($spt, $limit, request('page'), $count, ['path' => ' '])->withQueryString();

        return view('spt.monitoring.detail.index', [
            'data' => $data,
            "pageTitle" => "SPT " . $satker->nmsatker,
            "kdsatker" => $satker->kdsatker,
            'tahun' => $tahun,
            'thn' => $thn
        ]);
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
        // $data = SPTPegawai::getById($id)->data;
        $data = dataSpt::getSpt($id);
        if ($data->kdsatker != $kdsatker) {
            abort(403);
        }

        // $refJab = RefJabatan::get()->data;
        $refJab = RefJabatanOld::get();
        // $refPang = RefPangkat::get()->data;
        $refPang = RefPangkatOld::get();

        return view('spt.monitoring.detail.edit', [
            'data' => $data,
            'refJab' => $refJab,
            'refPang' => $refPang,
            "pageTitle" => "SPT " . satker::where('kdsatker', $kdsatker)->first()->nmsatker,
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

        // $data = SPTPegawai::getById($id)->data;
        $data = dataSpt::getSpt($id);
        if ($data->kdsatker != $kdsatker) {
            abort(403);
        }

        $request->validate([
            'tahun' => 'required|min_digits:4|max_digits:4',
            'nip' => 'required|min_digits:18|max_digits:18',
            'npwp' => 'required|min_digits:15|max_digits:16',
            'kdgol' => 'required|min_digits:2|max_digits:2',
            'alamat' => 'required',
            'kdkawin' => 'required|min_digits:4|max_digits:4',
            'kdjab' => 'required|min_digits:5|max_digits:5',
        ], [
            'tahun.required' => 'Tahun harus diisi',
            'nip.required' => 'NIP harus diisi',
            'npwp.required' => 'NPWP harus diisi',
            'kdgol.required' => 'Golongan harus diisi',
            'alamat.required' => 'Alamat harus diisi',
            'kdkawin.required' => 'Kawin harus diisi',
            'kdjab.required' => 'Jabatan harus diisi',
            'tahun.min_digits' => 'Tahun minimal 4 digit',
            'tahun.max_digits' => 'Tahun maksimal 4 digit',
            'nip.min_digits' => 'NIP minimal 18 digit',
            'nip.max_digits' => 'NIP maksimal 18 digit',
            'npwp.min_digits' => 'NPWP minimal 15 digit',
            'npwp.max_digits' => 'NPWP maksimal 16 digit',
            'kdgol.min_digits' => 'Golongan minimal 2 digit',
            'kdgol.max_digits' => 'Golongan maksimal 2 digit',
            'kdkawin.min_digits' => 'Kawin minimal 4 digit',
            'kdkawin.max_digits' => 'Kawin maksimal 4 digit',
            'kdjab.min_digits' => 'Jabatan minimal 5 digit',
            'kdjab.max_digits' => 'Jabatan maksimal 5 digit',
        ]);
        try {
            // $response = SPTPegawai::put($id, [
            //     'tahun' => $request->tahun,
            //     'nip' => $request->nip,
            //     'npwp' => $request->npwp,
            //     'alamat' => $request->alamat,
            //     'kdgol' => $request->kdgol,
            //     'kdkawin' => $request->kdkawin,
            //     'kdjab' => $request->kdjab,
            //     'kdsatker' => $data->kdsatker
            // ]);

            $response= dataSpt::update([
                'tahun' => $request->tahun,
                'nip' => $request->nip,
                'npwp' => $request->npwp,
                'alamat' => $request->alamat,
                'kdgol' => $request->kdgol,
                'kdkawin' => $request->kdkawin,
                'kdjab' => $request->kdjab,
                'kdsatker' => auth()->user()->kdsatker,
                'id' => $id
            ]);

            if ($response->failed()) {
                throw new \Exception($response);
            }
            Cache::forget('alikaSPTPegawaiTahunByKdSatker_' . auth()->user()->kdsatker);
            return redirect('/spt-monitoring/' . $kdsatker . '?thn=' . $request->tahun)->with('berhasil', 'Data berhasil diubah');
        } catch (\Throwable $th) {

            return redirect('/spt-monitoring/' . $kdsatker . '?thn=' . $request->tahun)->with('gagal', $th->getMessage());
        }
    }

    public function delete($kdsatker, $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        // $data = SPTPegawai::getById($id)->data;
        $data = dataSpt::getSpt($id);
        if ($data->kdsatker != $kdsatker) {
            abort(403);
        }
        try {
            // $response = SPTPegawai::destroy($id);
            $response = dataSpt::delete($id);
            if ($response->failed()) {
                throw new \Exception($response);
            }
            Cache::forget('alikaSPTPegawaiTahunByKdSatker_' . auth()->user()->kdsatker);
            return redirect('/spt-monitoring/' . $kdsatker . '?thn=' . $data->tahun)->with('berhasil', 'Data berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect('/spt-monitoring/' . $kdsatker . '?thn=' . $data->tahun)->with('gagal', $th->getMessage());
        }
    }

    public function paginate($items, $perPage = 15, $page = null, $count, $options = [])
    {
        return new LengthAwarePaginator($items, $count, $perPage, $page, $options);
    }
}
