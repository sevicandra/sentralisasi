<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\Alika\API2\dataSpt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Helper\Alika\API2\refJabatan;
use App\Helper\Alika\API2\refPangkat;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

class SptController extends Controller
{
    public function index(){
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_spt'];
            $gate2=['sys_admin'];
        }else{
            $gate=['admin_satker'];
            $gate2=[];

        }

        if (! Gate::any($gate, auth()->user()->id)) {
            if (! Gate::any($gate2, auth()->user()->id)) {
                abort(403);
            }
            return Redirect('/spt-monitoring');
        }

        if (!request('thn')) {
            $tahun = date('Y')-1;
        }else{
            $tahun = request('thn');
        };
        $spt = Collect(dataSpt::getDataSpt(auth()->user()->kdsatker, $tahun), false);
        $data = $this->paginate($spt, 15, request('page'), ['path'=>' '])->withQueryString();
        
        return view('spt.index.index', [
            'data' => $data,
            'tahun'=>dataSpt::getTahun(auth()->user()->kdsatker)
        ]);
    }

    public function create(){
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_spt'];
            $gate2=['sys_admin'];
        }else{
            $gate=['admin_satker'];
            $gate2=[];

        }

        if (! Gate::any($gate, auth()->user()->id)) {
            if (! Gate::any($gate2, auth()->user()->id)) {
                abort(403);
            }
            return Redirect('/spt-monitoring');
        }

        return view('spt.index.create',[
            'refJab' => refJabatan::get(),
            'refPang' => refPangkat::get()
        ]);
    }

    public function store(Request $request){
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_spt'];
            $gate2=['sys_admin'];
        }else{
            $gate=['admin_satker'];
            $gate2=[];

        }

        if (! Gate::any($gate, auth()->user()->id)) {
            if (! Gate::any($gate2, auth()->user()->id)) {
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
        ],[
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
        dataSpt::create([
            'tahun' => $request->tahun,
            'nip' => $request->nip,
            'npwp' => $request->npwp,
            'alamat' => $request->alamat,
            'kdgol' => $request->kdgol,
            'kdkawin' => $request->kdkawin,
            'kdjab' => $request->kdjab,
            'kdsatker' => auth()->user()->kdsatker
        ]);
        return redirect('/spt')->with('berhasil', 'Data berhasil ditambah');
    }

    public function edit($id){
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_spt'];
            $gate2=['sys_admin'];
        }else{
            $gate=['admin_satker'];
            $gate2=[];

        }

        if (! Gate::any($gate, auth()->user()->id)) {
            if (! Gate::any($gate2, auth()->user()->id)) {
                abort(403);
            }
            return Redirect('/spt-monitoring');
        }
        $data = dataSpt::getSpt($id);

        if ($data->kdsatker != auth()->user()->kdsatker) {
            abort(403);
        }

        return view('spt.index.edit',[
            'data' => $data,
            'refJab' => refJabatan::get(),
            'refPang' => refPangkat::get()
        ]);
    }

    public function update(Request $request, $id){
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_spt'];
            $gate2=['sys_admin'];
        }else{
            $gate=['admin_satker'];
            $gate2=[];

        }

        if (! Gate::any($gate, auth()->user()->id)) {
            if (! Gate::any($gate2, auth()->user()->id)) {
                abort(403);
            }
            return Redirect('/spt-monitoring');
        }
        $data = dataSpt::getSpt($id);

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
        ],[
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
        dataSpt::update([
            'id' => $id,
            'tahun' => $request->tahun,
            'nip' => $request->nip,
            'npwp' => $request->npwp,
            'alamat' => $request->alamat,
            'kdgol' => $request->kdgol,
            'kdkawin' => $request->kdkawin,
            'kdjab' => $request->kdjab,
            'kdsatker' => auth()->user()->kdsatker
        ]);
        return redirect('/spt')->with('berhasil', 'Data berhasil diubah');
    }
    
    public function delete($id){
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_spt'];
            $gate2=['sys_admin'];
        }else{
            $gate=['admin_satker'];
            $gate2=[];

        }

        if (! Gate::any($gate, auth()->user()->id)) {
            if (! Gate::any($gate2, auth()->user()->id)) {
                abort(403);
            }
            return Redirect('/spt-monitoring');
        }
        $data = dataSpt::getSpt($id);

        if ($data->kdsatker != auth()->user()->kdsatker) {
            abort(403);
        }

        dataSpt::delete($id);
        return redirect('/spt?thn='.$data->tahun);
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function import(){
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_spt'];
            $gate2=['sys_admin'];
        }else{
            $gate=['admin_satker'];
            $gate2=[];

        }

        if (! Gate::any($gate, auth()->user()->id)) {
            if (! Gate::any($gate2, auth()->user()->id)) {
                abort(403);
            }
            return Redirect('/spt-monitoring');
        }
        return view('spt.index.import');
    }

    public function importAlika(Request $request){
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_spt'];
            $gate2=['sys_admin'];
        }else{
            $gate=['admin_satker'];
            $gate2=[];

        }

        if (! Gate::any($gate, auth()->user()->id)) {
            if (! Gate::any($gate2, auth()->user()->id)) {
                abort(403);
            }
            return Redirect('/spt-monitoring');
        }
        
        $request->validate([
            'file_excel'=>'required|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ],[
            'file_excel.required' => 'File harus diisi',
            'file_excel.mimetypes' => 'File harus berformat xls',
        ]);
        $file = $request->file('file_excel');
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($file);
        $sheetData = $spreadsheet->getSheetByName('spt')->toArray();
        $slicedSheet = collect(array_slice($sheetData, 2));
        $errors= collect();

        foreach ($slicedSheet as $item){
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
            ],[
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
                $detail->errors=(object) [];
                $errorMessage = json_decode($validator->errors()->toJson());
                if (isset($errorMessage->tahun)) {
                    $detail->errors->tahun = $errorMessage->tahun[0];
                }else{
                    $detail->errors->tahun = "ok";
                }

                if (isset($errorMessage->nip)) {
                    $detail->errors->nip = $errorMessage->nip[0];
                }else{
                    $detail->errors->nip = "ok";
                }

                if (isset($errorMessage->npwp)) {
                    $detail->errors->npwp = $errorMessage->npwp[0];
                }else{
                    $detail->errors->npwp = "ok";
                }

                if (isset($errorMessage->kdgol)) {
                    $detail->errors->kdgol = $errorMessage->kdgol[0];
                }else{
                    $detail->errors->kdgol = "ok";
                }

                if (isset($errorMessage->alamat)) {
                    $detail->errors->alamat = $errorMessage->alamat[0];
                }else{
                    $detail->errors->alamat = "ok";
                }

                if (isset($errorMessage->kdkawin)) {
                    $detail->errors->kdkawin = $errorMessage->kdkawin[0];
                }else{
                    $detail->errors->kdkawin = "ok";
                }

                if (isset($errorMessage->kdjab)) {
                    $detail->errors->kdjab = $errorMessage->kdjab[0];
                }else{
                    $detail->errors->kdjab = "ok";
                }
                $detail->row=$item[0];
                $detail->status=FALSE;
                $errors->push($detail);
            }else{
                $detail = (object) [];
                $detail->errors=(object) [];
                $detail->errors->tahun = "ok";
                $detail->errors->nip = "ok";
                $detail->errors->npwp = "ok";
                $detail->errors->kdgol = "ok";
                $detail->errors->alamat = "ok";
                $detail->errors->kdkawin = "ok";
                $detail->errors->kdjab = "ok";
                $detail->row=$item[0];
                $detail->status=TRUE;
                $errors->push($detail);
            }
        }

        if ($errors->min('status') === TRUE) {
            foreach ($slicedSheet as $item){
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

                dataSpt::create([
                    'tahun' => $row['tahun'],
                    'nip' => $row['nip'],
                    'npwp' => $row['npwp'],
                    'alamat' => $row['alamat'],
                    'kdgol' => $row['kdgol'],
                    'kdkawin' => $row['kdkawin'],
                    'kdjab' => $row['kdjab'],
                    'kdsatker' => auth()->user()->kdsatker
                ]);
                
            }
            return redirect('/spt')->with('berhasil', 'Data berhasil di impor');
        }else{
            return redirect('/spt/import')->with('gagal', 'Data tidak berhasil di impor')->with('rowsErrors', collect($errors));
        }
    }
}
