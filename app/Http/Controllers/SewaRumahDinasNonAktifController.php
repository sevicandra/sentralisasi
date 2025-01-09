<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sewaRumahDinas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class SewaRumahDinasNonAktifController extends Controller
{
    public function index()
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_rumdin', 'admin_pusat'];
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

        return view('rumah-dinas.non-aktif.index',[
            'data'=>sewaRumahDinas::nonAktif()->paginate(15)->withQueryString(),
            'rumdinReject'=>sewaRumahDinas::countReject(),
            'rumdinUsulan'=>sewaRumahDinas::countUsulan(),
            'rumdinPenghentian'=>sewaRumahDinas::countPenghentian(),
            'pageTitle'=>'Sewa Rumah Dinas',
        ]);
    }

    public function dokumen(sewaRumahDinas $sewaRumahDinas)
    {
        
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_rumdin', 'admin_pusat'];
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

        if ($sewaRumahDinas->kdsatker != auth()->user()->kdsatker && $sewaRumahDinas->status != 'non-aktif') {
            abort(403);
        }
        
        return response()->file(Storage::path($sewaRumahDinas->file),[
            'Content-Type' => 'application/pdf',
        ]);

    }
}
