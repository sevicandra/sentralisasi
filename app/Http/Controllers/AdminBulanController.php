<?php

namespace App\Http\Controllers;

use App\Models\bulan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class AdminBulanController extends Controller
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
        return view('admin.bulan.index',[
            'data'=>bulan::orderBy('bulan')->get()
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
        return view('admin.bulan.create');
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
            'bulan'=>'required|numeric',
            'nmbulan'=>'required'
        ]);
        bulan::create([
            'bulan'=>$request->bulan,
            'nmbulan'=>$request->nmbulan,
        ]);
        return Redirect('/admin/bulan')->with('berhasil', 'Data berhasil di tambah.');
    }

    public function edit(bulan $bulan)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        return view('admin.bulan.edit',[
            'data'=>$bulan
        ]);
    }

    public function update(Request $request, bulan $bulan)
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
            'bulan'=>'required|numeric',
            'nmbulan'=>'required'
        ]);
        $bulan->update([
            'bulan'=>$request->bulan,
            'nmbulan'=>$request->nmbulan,
        ]);
        return Redirect('/admin/bulan')->with('berhasil', 'Data berhasil di ubah.');
    }
}
