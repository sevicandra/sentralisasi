<?php

namespace App\Http\Controllers;

use App\Models\Kop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RefKopController extends Controller
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
        return view('admin.ref-kop.index',[
            'data'=>Kop::index()->paginate(15)->withQueryString()
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

        return view('admin.ref-kop.create');
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
            'eselon1' => 'required',
            'eselon2' => 'required',
            'alamat' => 'required',
        ]);

        Kop::create($request->all());

        return redirect('/admin/ref-kop')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function edit(Kop $kop)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        return view('admin.ref-kop.edit',[
            'data'=>$kop
        ]);
    }

    public function update(Request $request, Kop $kop)
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
            'eselon1' => 'required',
            'eselon2' => 'required',
            'alamat' => 'required',
        ]);

        $kop->update($request->all());

        return redirect('/admin/ref-kop')->with('success', 'Data Berhasil Diubah');
    }

    public function destroy(Kop $kop)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $kop->delete();
        return redirect('/admin/ref-kop')->with('success', 'Data Berhasil Dihapus');
    }
}
