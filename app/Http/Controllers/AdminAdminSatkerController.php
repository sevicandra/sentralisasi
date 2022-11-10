<?php

namespace App\Http\Controllers;

use App\Models\adminSatker;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class AdminAdminSatkerController extends Controller
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

        return view('admin.admin_satker.index',[
            'data'=>adminSatker::all()
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
        return view('admin.admin_satker.create');
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
            'kdsatker'=>'exists:satkers,kdsatker|required|min:6|max:6|unique:admin_satkers,kdsatker',
            'kdunit'=>'required|min:10|max:10|unique:admin_satkers,kdunit',
            'nmjabatan'=>'required'
        ]);
        
        $request->validate([
            'kdsatker'=>'numeric',
            'kdunit'=>'numeric'
        ]);

        adminSatker::create([
            'kdsatker'=>$request->kdsatker,
            'kdunit'=>$request->kdunit,
            'nmjabatan'=>$request->nmjabatan
        ]);
        return Redirect('/admin/admin-satker')->with('berhasil', 'data berhasil di tambah.');
    }

    public function edit(adminSatker $adminSatker)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        return view('admin.admin_satker.update',[
            'data'=>$adminSatker
        ]);
    }

    public function update(Request $request, adminSatker $adminSatker)
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
            'kdsatker'=>['exists:satkers,kdsatker','required','min:6','max:6',Rule::unique('admin_satkers')->ignore($adminSatker->id)],
            'kdunit'=>['required','min:10','max:10',Rule::unique('admin_satkers')->ignore($adminSatker->id)],
            'nmjabatan'=>'required'
        ]);
        
        $request->validate([
            'kdsatker'=>'numeric',
            'kdunit'=>'numeric'
        ]);

        $adminSatker->update([
            'kdsatker'=>$request->kdsatker,
            'kdunit'=>$request->kdunit,
            'nmjabatan'=>$request->nmjabatan
        ]);
        return Redirect('/admin/admin-satker')->with('berhasil', 'data berhasil di ubah.');
    }

    public function delete(adminSatker $adminSatker)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        $adminSatker->delete();
        return Redirect('/admin/admin-satker')->with('berhasil', 'data berhasil di hapus.');
    }
}
