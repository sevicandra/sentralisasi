<?php

namespace App\Http\Controllers;

use App\Models\Nomor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RefNomorController extends Controller
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
        return view('admin.ref-nomor.index',[
            'data'=>Nomor::index()->paginate(15)->withQueryString()
        ]);
    }

    public function create()
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        return view('admin.ref-nomor.create');
    }

    public function store(Request $request)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $request->validate([
            'kdsatker' => 'required',
            'nomor' => 'required',
            'tahun' => 'required',
            'ext' => 'required',
        ]);
        Nomor::create($request->all());

        return redirect('/admin/ref-nomor')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function edit(Nomor $nomor)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        return view('admin.ref-nomor.edit',[
            'data'=>$nomor
        ]);
    }

    public function update(Request $request, Nomor $nomor)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $request->validate([
            'kdsatker' => 'required',
            'nomor' => 'required',
            'tahun' => 'required',
            'ext' => 'required',
        ]);
        $nomor->update($request->all());

        return redirect('/admin/ref-nomor')->with('success', 'Data Berhasil Diubah');
    }

    public function destroy(Nomor $nomor)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $nomor->delete();
        return redirect('/admin/ref-nomor')->with('success', 'Data Berhasil Dihapus');
    }
}
