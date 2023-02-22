<?php

namespace App\Http\Controllers;

use App\Models\satker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AdminSatkerController extends Controller
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
        return view('admin.satker.index',[
            'data'=>satker::search()->order()->paginate(15)->withQueryString()
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
        return view('admin.satker.create');
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
        if ($request->jnssatker === "3") {
            $request->validate([
                'nmsatker'=>'required',
                'kdsatker'=>'required|min:6|max:6|unique:satkers,kdsatker',
                'jnssatker'=>'required',
                'kdkoordinator'=>'required|min:6|max:6',
                'order'=>'required|min:2|max:4',
            ]); 
            $request->validate([
                'kdkoordinator'=>'numeric',
                'kdsatker'=>'numeric',
                'order'=>'numeric',
            ]);
            satker::create([
                'nmsatker'=> $request->nmsatker,
                'kdsatker'=> $request->kdsatker,
                'jnssatker'=> $request->jnssatker,
                'kdkoordinator'=> $request->kdkoordinator,
                'order'=> $request->order,
            ]);
            return Redirect('/admin/satker')->with('berhasil', 'data berhasil ditambah');
        }else{
            $request->validate([
                'nmsatker'=>'required',
                'kdsatker'=>'required|min:6|max:6|unique:satkers,kdsatker',
                'jnssatker'=>'required',
                'order'=>'required|min:2|max:4',
            ]);
            $request->validate([
                'kdsatker'=>'numeric',
                'order'=>'numeric',
            ]);
            if ($request->jnssatker === "2") {
                satker::create([
                    'nmsatker'=> $request->nmsatker,
                    'kdsatker'=> $request->kdsatker,
                    'jnssatker'=> $request->jnssatker,
                    'kdkoordinator'=> '411792',
                    'order'=> $request->order,
                ]);
            }else{
                $request->validate([
                    'nmsatker'=>'required',
                    'kdsatker'=>'required|min:6|max:6|unique:satkers,kdsatker',
                    'jnssatker'=>'required',
                    'order'=>'required|min:2|max:4',
                    'order'=>'numeric',
                ]);
                $request->validate([
                    'kdsatker'=>'numeric',
                    'order'=>'numeric',
                ]);
                satker::create([
                    'nmsatker'=> $request->nmsatker,
                    'kdsatker'=> $request->kdsatker,
                    'jnssatker'=> $request->jnssatker,
                    'order'=> $request->order,
                ]);
            }
            return Redirect('/admin/satker')->with('berhasil', 'data berhasil ditambah');
        }
    }

    public function edit(satker $satker)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        return view('admin.satker.edit',[
            'data'=>$satker
        ]);
    }

    public function update(Request $request,satker $satker)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($request->jnssatker === "3") {
            if ($request->kdsatker === $satker->kdsatker) {
                $request->validate([
                    'nmsatker'=>'required',
                    'jnssatker'=>'required',
                    'kdkoordinator'=>'required|min:6|max:6',
                    'order'=>'required|min:2|max:4',
                ]); 
                $request->validate([
                    'kdkoordinator'=>'numeric',
                    'order'=>'numeric',
                ]);
                $satker->update([
                    'nmsatker'=> $request->nmsatker,
                    'jnssatker'=> $request->jnssatker,
                    'kdkoordinator'=> $request->kdkoordinator,
                    'order'=>$request->order,
                ]);
            }else{
                $request->validate([
                    'nmsatker'=>'required',
                    'kdsatker'=>'required|min:6|max:6|unique:satkers,kdsatker',
                    'jnssatker'=>'required',
                    'kdkoordinator'=>'required|min:6|max:6',
                    'order'=>'required|min:2|max:4',
                ]); 
                $request->validate([
                    'kdkoordinator'=>'numeric',
                    'kdsatker'=>'numeric',
                    'order'=>'numeric',
                ]);
                $satker->update([
                    'nmsatker'=> $request->nmsatker,
                    'kdsatker'=> $request->kdsatker,
                    'jnssatker'=> $request->jnssatker,
                    'kdkoordinator'=> $request->kdkoordinator,
                    'order'=>$request->order
                ]);
            }

            return Redirect('/admin/satker')->with('berhasil', 'data berhasil ditambah');
        }else{
            if ($request->kdsatker === $satker->kdsatker) {
                $request->validate([
                    'nmsatker'=>'required',
                    'jnssatker'=>'required',
                    'order'=>'required|min:2|max:4',
                ]);
                $request->validate([
                    'kdsatker'=>'numeric',
                    'order'=>'numeric',
                ]);
                if ($request->jnssatker === "2") {
                    $satker->update([
                        'nmsatker'=> $request->nmsatker,
                        'jnssatker'=> $request->jnssatker,
                        'order'=>$request->order,
                    ]);
                }else{
                    $satker->update([
                        'nmsatker'=> $request->nmsatker,
                        'jnssatker'=> $request->jnssatker,
                        'order'=>$request->order,
                    ]);
                }
            }else{
                $request->validate([
                    'nmsatker'=>'required',
                    'kdsatker'=>'required|min:6|max:6|unique:satkers,kdsatker',
                    'jnssatker'=>'required',
                    'order'=>'required|min:2|max:4',
                ]);
                $request->validate([
                    'kdsatker'=>'numeric',
                    'order'=>'numeric',
                ]);
                if ($request->jnssatker === "2") {
                    $satker->update([
                        'nmsatker'=> $request->nmsatker,
                        'kdsatker'=> $request->kdsatker,
                        'jnssatker'=> $request->jnssatker,
                        'order'=>$request->order,
                    ]);
                }else{
                    $satker->update([
                        'nmsatker'=> $request->nmsatker,
                        'kdsatker'=> $request->kdsatker,
                        'jnssatker'=> $request->jnssatker,
                        'order'=>$request->order,
                    ]);
                }
            }
            return Redirect('/admin/satker')->with('berhasil', 'data berhasil ditambah');
        }
    }

    public function delete(satker $satker)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        $satker->delete();
        return redirect('/admin/satker')->with('berhasil', 'data berhasil dihapus');
    }
}
