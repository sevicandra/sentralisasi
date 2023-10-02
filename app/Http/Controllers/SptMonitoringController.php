<?php

namespace App\Http\Controllers;

use App\Models\satker;
use Illuminate\Http\Request;
use App\Helper\Alika\API2\dataSpt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Helper\Alika\API2\refJabatan;
use App\Helper\Alika\API2\refPangkat;
use Illuminate\Pagination\LengthAwarePaginator;

class SptMonitoringController extends Controller
{
    public function index()
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        return view('spt.monitoring.index',[
            'data'=>satker::search()->order()->paginate(15)->withQueryString(),
            "pageTitle"=>"Monitoring SPT",
        ]);
    }

    public function satker(satker $satker)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        if (!request('thn')) {
            $tahun = date('Y')-1;
        }else{
            $tahun = request('thn');
        };
        $spt = Collect(dataSpt::getDataSpt($satker->kdsatker, $tahun), false);
        $data = $this->paginate($spt, 15, request('page'), ['path'=>' '])->withQueryString();

        return view('spt.monitoring.detail.index', [
            'data' => $data,
            "pageTitle"=>"SPT ".$satker->nmsatker,
            "kdsatker"=>$satker->kdsatker,
            'tahun'=>dataSpt::getTahun($satker->kdsatker)
        ]);
    }

    public function edit($kdsatker, $id)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        $data = dataSpt::getSpt($id);
        if ($data->kdsatker != $kdsatker) {
            abort(403);
        }

        return view('spt.monitoring.detail.edit',[
            'data' => $data,
            'refJab' => refJabatan::get(),
            'refPang' => refPangkat::get()
        ]);
    }

    public function update(Request $request, $kdsatker, $id)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

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
            'kdsatker' => $data->kdsatker
        ]);
        return redirect('/spt-monitoring/'.$kdsatker.'?thn='.$request->tahun)->with('berhasil', 'Data berhasil diubah');
    }
    
    public function delete($kdsatker, $id){
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $data = dataSpt::getSpt($id);
        if ($data->kdsatker != $kdsatker) {
            abort(403);
        }
        
        dataSpt::delete($id);
        return redirect('/spt-monitoring/'.$kdsatker.'?thn='.$data->tahun)->with('berhasil', 'Data berhasil dihapus'); 
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
