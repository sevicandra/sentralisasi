<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\Alika\API2\dataLain;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\LengthAwarePaginator;


class DataPaymentServerController extends Controller
{
    public function index()
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[''];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        if (request('page')) {
            $offset = (request('page')-1)*15;
        }else{
            $offset = 0;
        }
        if (request('nip')) {
            $dataLain = dataLain::get(null, 15,$offset);
            $count=count(dataLain::get(null, null,$offset));
        }else{
            $dataLain = dataLain::get(null, 15,$offset);
            $count = dataLain::count();
        }
        $data = $this->paginate($dataLain, 15, request('page'), $count,['path'=>' '])->withQueryString();

        return view('data-payment.server.index',[
            'data' =>$data,
            'pageTitle'=>'Data Server'
        ]);
    }

    public function edit($id)
    {
        if (Auth::guard('web')->check()) {
            $gate=['adm_server'];
        }else{
            $gate=[''];
        }

        if (! Gate::allows($gate, auth()->user()->id)) {
            abort(403);
        }

        return view('data-payment.server.edit',[
            'data'=>dataLain::get($id),
            'pageTitle'=>'Edit Data Server'
        ]);
    }

    public function update(Request $request, $id)
    {
        if (Auth::guard('web')->check()) {
            $gate=['adm_server'];
        }else{
            $gate=[''];
        }

        if (! Gate::allows($gate, auth()->user()->id)) {
            abort(403);
        }
        $request->validate([
            'bulan'=>'required||min:2|max:2',
            'tahun'=>'required|min:4|max:4',
            'kdsatker'=>'required|min:6|max:6',
            'nip'=>'required|min:18|max:18',
            'bruto'=>'required|numeric',
            'netto'=>'required|numeric',
            'jenis'=>'required',
            'uraian'=>'required',
            'tanggal'=>'required',
        ]);

        $request->validate([
            'bulan'=>'numeric',
            'tahun'=>'numeric',
            'kdsatker'=>'numeric',
            'nip'=>'numeric',
        ]);
        try {
            $response   = dataLain::patch([
                'bulan' => $request->bulan ,
                'tahun' => $request->tahun ,
                'kdsatker' => $request->kdsatker ,
                'nip' => $request->nip ,
                'bruto' => $request->bruto ,
                'pph' => $request->pph ,
                'netto' => $request->netto ,
                'jenis' => $request->jenis ,
                'uraian' => $request->uraian ,
                'tanggal' => $request->tanggal ,
                'nospm' => $request->nospm ,
                'id' => $id,
            ]);
            if ($response->getStatusCode() != 200) {
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
            $gate=['adm_server'];
        }else{
            $gate=[''];
        }

        if (! Gate::allows($gate, auth()->user()->id)) {
            abort(403);
        }
        try {
            $response = dataLain::delete($id);
            if ($response->getStatusCode() != 200) {
                throw new \Exception($response);
            }
        } catch (\Throwable $e) {
            return redirect('/data-payment/server')->with('gagal', $e->getMessage());
        }
        return redirect('/data-payment/server')->with('berhasil', 'Selamat Data Berhasil di Hapus');
    }

    public function paginate($items, $perPage = 15, $page = null, $count,$options = [])
    {
        return new LengthAwarePaginator($items, $count, $perPage, $page, $options);
    }
}
