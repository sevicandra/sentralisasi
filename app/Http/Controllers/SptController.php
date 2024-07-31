<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\AlikaNew\RefJabatan;
use App\Helper\AlikaNew\RefPangkat;
use App\Helper\AlikaNew\SPTPegawai;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

class SptController extends Controller
{
    public function index()
    {
        if (Auth::guard('web')->check()) {
            $gate = ['plt_admin_satker', 'opr_spt'];
            $gate2 = ['sys_admin'];
        } else {
            $gate = ['admin_satker'];
            $gate2 = [];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            if (!Gate::any($gate2, auth()->user()->id)) {
                abort(403);
            }
            return Redirect('/spt-monitoring');
        }
        $limit = 15;
        if (request('page')) {
            $offset = (request('page') - 1) * $limit;
        } else {
            $offset = 0;
        }

        $tahun = SPTPegawai::tahunByKdSatker(auth()->user()->kdsatker)->data;
        if (!request('thn')) {
            $thn = collect($tahun)->last()->tahun;
        } else {
            $thn = request('thn');
        };
        $spt = SPTPegawai::getByKdSatker(auth()->user()->kdsatker, $thn, $limit, $offset, request('search'))->data;
        $count = SPTPegawai::countByKdSatker(auth()->user()->kdsatker, $thn)->data;
        $data = $this->paginate($spt, $limit, request('page'), $count, ['path' => ' '])->withQueryString();

        return view('spt.index.index', [
            'data' => $data,
            'tahun' => $tahun,
            'thn' => $thn
        ]);
    }

    public function create()
    {
        if (Auth::guard('web')->check()) {
            $gate = ['plt_admin_satker', 'opr_spt'];
            $gate2 = ['sys_admin'];
        } else {
            $gate = ['admin_satker'];
            $gate2 = [];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            if (!Gate::any($gate2, auth()->user()->id)) {
                abort(403);
            }
            return Redirect('/spt-monitoring');
        }

        $refJab = RefJabatan::get()->data;
        $refPang = RefPangkat::get()->data;

        return view('spt.index.create', [
            'refJab' => $refJab,
            'refPang' => $refPang
        ]);
    }

    public function store(Request $request)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['plt_admin_satker', 'opr_spt'];
            $gate2 = ['sys_admin'];
        } else {
            $gate = ['admin_satker'];
            $gate2 = [];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            if (!Gate::any($gate2, auth()->user()->id)) {
                abort(403);
            }
            return Redirect('/spt-monitoring');
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
            $response = SPTPegawai::post([
                'tahun' => $request->tahun,
                'nip' => $request->nip,
                'npwp' => $request->npwp,
                'alamat' => $request->alamat,
                'kdgol' => $request->kdgol,
                'kdkawin' => $request->kdkawin,
                'kdjab' => $request->kdjab,
                'kdsatker' => auth()->user()->kdsatker
            ]);
            if ($response->failed()) {
                throw new \Exception($response->json('message'));
            }
            Cache::forget('alikaSPTPegawaiTahunByKdSatker_' . auth()->user()->kdsatker);
            return redirect('/spt')->with('berhasil', 'Data berhasil ditambah');
        } catch (\Throwable $th) {
            return redirect('/spt')->with('gagal', $th->getMessage());
        }
    }

    public function edit($id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['plt_admin_satker', 'opr_spt'];
            $gate2 = ['sys_admin'];
        } else {
            $gate = ['admin_satker'];
            $gate2 = [];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            if (!Gate::any($gate2, auth()->user()->id)) {
                abort(403);
            }
            return Redirect('/spt-monitoring');
        }
        $data = SPTPegawai::getById($id)->data;

        if ($data->kdsatker != auth()->user()->kdsatker) {
            abort(403);
        }

        $refJab = RefJabatan::get()->data;
        $refPang = RefPangkat::get()->data;

        return view('spt.index.edit', [
            'data' => $data,
            'refJab' => $refJab,
            'refPang' => $refPang
        ]);
    }

    public function update(Request $request, $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['plt_admin_satker', 'opr_spt'];
            $gate2 = ['sys_admin'];
        } else {
            $gate = ['admin_satker'];
            $gate2 = [];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            if (!Gate::any($gate2, auth()->user()->id)) {
                abort(403);
            }
            return Redirect('/spt-monitoring');
        }
        $data = SPTPegawai::getById($id)->data;

        if ($data->kdsatker != auth()->user()->kdsatker) {
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
            $response = SPTPegawai::put($id, [
                'tahun' => $request->tahun,
                'nip' => $request->nip,
                'npwp' => $request->npwp,
                'alamat' => $request->alamat,
                'kdgol' => $request->kdgol,
                'kdkawin' => $request->kdkawin,
                'kdjab' => $request->kdjab,
                'kdsatker' => $data->kdsatker
            ]);
            if ($response->failed()) {
                throw new \Exception($response);
            }
            Cache::forget('alikaSPTPegawaiTahunByKdSatker_' . auth()->user()->kdsatker);
            return redirect('/spt' . '?thn=' . $request->tahun)->with('berhasil', 'Data berhasil diubah');
        } catch (\Throwable $th) {
            return redirect('/spt' . '?thn=' . $request->tahun)->with('gagal', $th->getMessage());
        }
    }

    public function delete($id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['plt_admin_satker', 'opr_spt'];
            $gate2 = ['sys_admin'];
        } else {
            $gate = ['admin_satker'];
            $gate2 = [];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            if (!Gate::any($gate2, auth()->user()->id)) {
                abort(403);
            }
            return Redirect('/spt-monitoring');
        }
        $data = SPTPegawai::getById($id)->data;

        if ($data->kdsatker != auth()->user()->kdsatker) {
            abort(403);
        }

        try {
            $response = SPTPegawai::destroy($id);
            if ($response->failed()) {
                throw new \Exception($response);
            }
            return redirect('/spt?thn=' . $data->tahun)->with('berhasil', 'Data berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect('/spt?thn=' . $data->tahun)->with('gagal', $th->getMessage());
        }
    }

    public function paginate($items, $perPage = 15, $page = null, $count, $options = [])
    {
        return new LengthAwarePaginator($items, $count, $perPage, $page, $options);
    }

    public function import()
    {
        if (Auth::guard('web')->check()) {
            $gate = ['plt_admin_satker', 'opr_spt'];
            $gate2 = ['sys_admin'];
        } else {
            $gate = ['admin_satker'];
            $gate2 = [];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            if (!Gate::any($gate2, auth()->user()->id)) {
                abort(403);
            }
            return Redirect('/spt-monitoring');
        }
        return view('spt.index.import');
    }

    public function importAlika(Request $request)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['plt_admin_satker', 'opr_spt'];
            $gate2 = ['sys_admin'];
        } else {
            $gate = ['admin_satker'];
            $gate2 = [];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            if (!Gate::any($gate2, auth()->user()->id)) {
                abort(403);
            }
            return Redirect('/spt-monitoring');
        }

        $request->validate([
            'file_excel' => 'required|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ], [
            'file_excel.required' => 'File harus diisi',
            'file_excel.mimetypes' => 'File harus berformat xls',
        ]);
        $file = $request->file('file_excel');
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($file);
        $sheetData = $spreadsheet->getSheetByName('spt')->toArray();
        $slicedSheet = collect(array_slice($sheetData, 2));
        $errors = collect();

        foreach ($slicedSheet as $item) {
            if ($item[0] === null) {
                break;
            }
            $row = collect([
                'tahun' => $item[1],
                'nip' => $item[2],
                'npwp' => $item[3],
                'kdgol' => $item[4],
                'alamat' => $item[5],
                'kdkawin' => $item[6],
                'kdjab' => $item[7],
            ]);

            $validator = Validator::make($row->all(), [
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
            if ($validator->fails()) {
                $detail = (object) [];
                $detail->errors = (object) [];
                $errorMessage = json_decode($validator->errors()->toJson());
                if (isset($errorMessage->tahun)) {
                    $detail->errors->tahun = $errorMessage->tahun[0];
                } else {
                    $detail->errors->tahun = "ok";
                }

                if (isset($errorMessage->nip)) {
                    $detail->errors->nip = $errorMessage->nip[0];
                } else {
                    $detail->errors->nip = "ok";
                }

                if (isset($errorMessage->npwp)) {
                    $detail->errors->npwp = $errorMessage->npwp[0];
                } else {
                    $detail->errors->npwp = "ok";
                }

                if (isset($errorMessage->kdgol)) {
                    $detail->errors->kdgol = $errorMessage->kdgol[0];
                } else {
                    $detail->errors->kdgol = "ok";
                }

                if (isset($errorMessage->alamat)) {
                    $detail->errors->alamat = $errorMessage->alamat[0];
                } else {
                    $detail->errors->alamat = "ok";
                }

                if (isset($errorMessage->kdkawin)) {
                    $detail->errors->kdkawin = $errorMessage->kdkawin[0];
                } else {
                    $detail->errors->kdkawin = "ok";
                }

                if (isset($errorMessage->kdjab)) {
                    $detail->errors->kdjab = $errorMessage->kdjab[0];
                } else {
                    $detail->errors->kdjab = "ok";
                }
                $detail->row = $item[0];
                $detail->status = FALSE;
                $errors->push($detail);
            } else {
                $detail = (object) [];
                $detail->errors = (object) [];
                $detail->errors->tahun = "ok";
                $detail->errors->nip = "ok";
                $detail->errors->npwp = "ok";
                $detail->errors->kdgol = "ok";
                $detail->errors->alamat = "ok";
                $detail->errors->kdkawin = "ok";
                $detail->errors->kdjab = "ok";
                $detail->row = $item[0];
                $detail->status = TRUE;
                $errors->push($detail);
            }
        }

        if ($errors->min('status') === TRUE) {
            foreach ($slicedSheet as $item) {
                if ($item[0] === null) {
                    break;
                }

                $row = collect([
                    'tahun' => $item[1],
                    'nip' => $item[2],
                    'npwp' => $item[3],
                    'kdgol' => $item[4],
                    'alamat' => $item[5],
                    'kdkawin' => $item[6],
                    'kdjab' => $item[7],
                ]);
                try {
                    $response = SPTPegawai::post([
                        'tahun' => $row['tahun'],
                        'nip' => $row['nip'],
                        'npwp' => $row['npwp'],
                        'alamat' => $row['alamat'],
                        'kdgol' => $row['kdgol'],
                        'kdkawin' => $row['kdkawin'],
                        'kdjab' => $row['kdjab'],
                        'kdsatker' => auth()->user()->kdsatker
                    ]);
                    if ($response->failed()) {
                        $data = $response->json();
                        throw new \Exception($data['error_description']. " NIP: ". $row['nip']);
                    }
                } catch (\Throwable $th) {
                    Cache::forget('alikaSPTPegawaiTahunByKdSatker_' . auth()->user()->kdsatker);
                    return redirect('/spt/import')->with('gagal', 'Data tidak berhasil di impor')->with('gagal', $th->getMessage());
                }
            }
            Cache::forget('alikaSPTPegawaiTahunByKdSatker_' . auth()->user()->kdsatker);
            return redirect('/spt')->with('berhasil', 'Data berhasil di impor');
        } else {
            return redirect('/spt/import')->with('gagal', 'Data tidak berhasil di impor')->with('rowsErrors', collect($errors));
        }
    }
}
