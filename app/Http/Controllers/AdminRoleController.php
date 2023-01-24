<?php

namespace App\Http\Controllers;

use App\Models\role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

class AdminRoleController extends Controller
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
        return view('admin.role.index',[
            'data'=>role::all()
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
        return view('admin.role.create');
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
            'kode'=>'required',
            'role'=>'required:unique:roles,role'
        ]);

        role::create([
            'kode'=>$request->kode,
            'role'=>$request->role,
        ]);

        return Redirect('/admin/role')->with('berhasil', 'Data berhasil di tambah.');
    }

    public function edit(role $role)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        return view('admin.role.edit',[
            'data'=>$role
        ]);
    }

    public function update(Request $request, role $role)
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
            'kode'=>'required',
            'role'=>['required',Rule::unique('roles')->ignore($role->id)]
        ]);

        $role->update([
            'kode'=>$request->kode,
            'role'=>$request->role
        ]);
        return Redirect('/admin/role')->with('berhasil', 'Data berhasil di ubah.');
    }
}
