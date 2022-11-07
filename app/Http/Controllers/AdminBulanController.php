<?php

namespace App\Http\Controllers;

use App\Models\bulan;
use Illuminate\Http\Request;

class AdminBulanController extends Controller
{
    public function index()
    {
        return view('admin.bulan.index',[
            'data'=>bulan::orderBy('bulan')->get()
        ]);
    }

    public function create()
    {
        return view('admin.bulan.create');
    }

    public function store(Request $request)
    {
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
        return view('admin.bulan.edit',[
            'data'=>$bulan
        ]);
    }

    public function update(Request $request, bulan $bulan)
    {
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
