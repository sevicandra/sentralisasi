<?php

namespace App\Http\Controllers;

use App\Models\role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AdminRoleController extends Controller
{
    public function index()
    {
        return view('admin.role.index',[
            'data'=>role::all()
        ]);
    }

    public function create()
    {
        return view('admin.role.create');
    }

    public function store(Request $request)
    {
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
}
