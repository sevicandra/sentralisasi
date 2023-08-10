<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sewaRumahDinas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class SewaRumahDinasRejectController extends Controller
{
    public function index()
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_rumdin'];
            $gate2=['sys_admin'];
        }else{
            $gate=['admin_satker'];
            $gate2=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            if (! Gate::any($gate2, auth()->user()->id)) {
                abort(403);
            }
            return Redirect('');
        }
        
        return view('rumah-dinas.reject.index',[
            'data'=>sewaRumahDinas::reject()->paginate(15)->withQueryString(),
            'rumdinReject'=>sewaRumahDinas::countReject(),
            'rumdinUsulan'=>sewaRumahDinas::countUsulan(),
            'rumdinPenghentian'=>sewaRumahDinas::countPenghentian(),
        ]);
    }

    public function edit(sewaRumahDinas $sewaRumahDinas)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_rumdin'];
            $gate2=['sys_admin'];
        }else{
            $gate=['admin_satker'];
            $gate2=[];

        }

        if (! Gate::any($gate, auth()->user()->id)) {
            if (! Gate::any($gate2, auth()->user()->id)) {
                abort(403);
            }
            return Redirect('');
        }

        if ($sewaRumahDinas->kdsatker != auth()->user()->kdsatker && $sewaRumahDinas->status != 'draft' && $sewaRumahDinas->catatan != null) {
            abort(403);
        }

        return view('rumah-dinas.edit',[
            'data'=>$sewaRumahDinas,
            'rumdinReject'=>sewaRumahDinas::countReject(),
            'rumdinUsulan'=>sewaRumahDinas::countUsulan(),
            'rumdinPenghentian'=>sewaRumahDinas::countPenghentian(),
        ]);
    }

    public function update(Request $request, sewaRumahDinas $sewaRumahDinas)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_rumdin'];
            $gate2=['sys_admin'];
        }else{
            $gate=['admin_satker'];
            $gate2=[];

        }

        if (! Gate::any($gate, auth()->user()->id)) {
            if (! Gate::any($gate2, auth()->user()->id)) {
                abort(403);
            }
            return Redirect('');
        }

        if ($sewaRumahDinas->kdsatker != auth()->user()->kdsatker && $sewaRumahDinas->status != 'draft' && $sewaRumahDinas->catatan != null) {
            abort(403);
        }

        $request->validate([
            'nama'=>'required',
            'nip'=>'required|min_digits:18|max_digits:18',
            'nomor_sip'=>'required',
            'tanggal_sip'=>'required|date_format:Y-m-d',
            'tmt'=>'required|date_format:Y-m-d',
            'nilai'=>'required|numeric',
            'file'=>'mimetypes:application/pdf|file|max:10240',
        ],[
            'nama.required'=>'nama wajib di isi.',
            'nip.required'=>'nip wajib di isi.',
            'nip.min_digits'=>'nip harus 18 karakter',
            'nip.max_digits'=>'nip harus 18 karakter',
            'nomor_sip.required'=>'nomor sip wajib di isi.',
            'tanggal_sip.required'=>'tanggal sip wajib di isi.',
            'tmt.required'=>'tmt wajib di isi.',
            'nilai.required'=>'nilai wajib di isi.',
            'nilai.numeric'=>'nilai harus berupa angka.',
            'file.mimetypes'=>'file harus berupa pdf.',
            'file.max'=>'ukuran maksimal file 10MB',
        ]);
        if ($request->file) {
            $path = $request->file('file')->store('uang-makan');
            $oldfile=$sewaRumahDinas->file;
            $sewaRumahDinas->update([
                'nama'=>$request->nama,
                'nip'=>$request->nip,
                'nomor_sip'=>$request->nomor_sip,
                'tanggal_sip'=>$request->tanggal_sip,
                'tmt'=>$request->tmt,
                'nilai_potongan'=>$request->nilai,
                'file'=>$path,
            ]);
            Storage::delete($oldfile);
        }else{
            $sewaRumahDinas->update([
                'nama'=>$request->nama,
                'nip'=>$request->nip,
                'nomor_sip'=>$request->nomor_sip,
                'tanggal_sip'=>$request->tanggal_sip,
                'tmt'=>$request->tmt,
                'nilai_potongan'=>$request->nilai,
            ]);
        }
        return redirect('/sewa-rumdin/reject')->with('berhasil','Data berhasil diubah.');
    }

    public function delete(sewaRumahDinas $sewaRumahDinas)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_rumdin'];
            $gate2=['sys_admin'];
        }else{
            $gate=['admin_satker'];
            $gate2=[];

        }

        if (! Gate::any($gate, auth()->user()->id)) {
            if (! Gate::any($gate2, auth()->user()->id)) {
                abort(403);
            }
            return Redirect('');
        }

        if ($sewaRumahDinas->kdsatker != auth()->user()->kdsatker && $sewaRumahDinas->status != 'draft' && $sewaRumahDinas->catatan != null) {
            abort(403);
        }

        Storage::delete($sewaRumahDinas->file);
        $sewaRumahDinas->delete();
        return redirect('/sewa-rumdin/reject')->with('berhasil','Data berhasil dihapus.');
    }

    public function kirim(sewaRumahDinas $sewaRumahDinas)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_rumdin'];
            $gate2=['sys_admin'];
        }else{
            $gate=['admin_satker'];
            $gate2=[];

        }

        if (! Gate::any($gate, auth()->user()->id)) {
            if (! Gate::any($gate2, auth()->user()->id)) {
                abort(403);
            }
            return Redirect('');
        }

        if ($sewaRumahDinas->kdsatker != auth()->user()->kdsatker && $sewaRumahDinas->status != 'draft' && $sewaRumahDinas->catatan != null) {
            abort(403);
        }

        $sewaRumahDinas->update([
            'status'=>'pengajuan',
            'catatan'=>null
        ]);
        return redirect('/sewa-rumdin/reject')->with('berhasil','Data berhasil dikirim.');
    }

    public function dokumen(sewaRumahDinas $sewaRumahDinas)
    {
        
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_rumdin'];
            $gate2=['sys_admin'];
        }else{
            $gate=['admin_satker'];
            $gate2=[];

        }

        if (! Gate::any($gate, auth()->user()->id)) {
            if (! Gate::any($gate2, auth()->user()->id)) {
                abort(403);
            }
            return Redirect('');
        }

        if ($sewaRumahDinas->kdsatker != auth()->user()->kdsatker && $sewaRumahDinas->status != 'draft' && $sewaRumahDinas->catatan != null) {
            abort(403);
        }
        
        return response()->file(Storage::path($sewaRumahDinas->file),[
            'Content-Type' => 'application/pdf',
        ]);

    }
}
