<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sewaRumahDinas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SewaRumahDinasUsulanController extends Controller
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
        
        return view('rumah-dinas.usulan.index',[
            'data'=>sewaRumahDinas::Usulan()->paginate(15)->withQueryString(),
            'rumdinReject'=>sewaRumahDinas::countReject(),
            'rumdinUsulan'=>sewaRumahDinas::countUsulan(),
            'rumdinPenghentian'=>sewaRumahDinas::countPenghentian(),
        ]);
    }

    public function tolak(Request $request,sewaRumahDinas $sewaRumahDinas)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        if ($sewaRumahDinas->status != 'pengajuan') {
            abort(403);
        }

        $validator = Validator::make($request->all(),[
            'catatan'=>'required'
        ]);

        if ($validator->fails()){
            return back()->with('gagal','catatan harus diisi');
        }

        $sewaRumahDinas->update([
            'catatan'=>$request->catatan,
            'status'=>'draft',
            'tanggal_kirim'=>null
        ]);

        return back()->with('berhasil','Data berhasil di tolak');
    }

    public function approve(sewaRumahDinas $sewaRumahDinas)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        if ($sewaRumahDinas->status != 'pengajuan') {
            abort(403);
        }

        $sewaRumahDinas->update([
            'status'=>'aktif',
            'tanggal_approve'=>date('Y-m-d')
        ]);

        return back()->with('berhasil','Data berhasil di update');
    }

    public function dokumen(sewaRumahDinas $sewaRumahDinas)
    {   
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        if ($sewaRumahDinas->status != 'pengajuan') {
            abort(403);
        }
        
        return response()->file(Storage::path($sewaRumahDinas->file),[
            'Content-Type' => 'application/pdf',
        ]);
    }
}
