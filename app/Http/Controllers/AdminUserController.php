<?php

namespace App\Http\Controllers;

use App\Models\role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AdminUserController extends Controller
{
    public function index()
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin', 'plt_admin_satker'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        return view('admin.user.index',[
            'data'=>User::satker()->sysAdmin()->search()->order()->paginate(15)->withQueryString()
        ]);
    }

    public function create()
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin', 'plt_admin_satker'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        return view('admin.user.create');
    }

    public function edit(User $user)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker'];
            if (! Gate::any(['sys_admin'], auth()->user()->id)) {
                if (! Gate::any($gate, auth()->user()->id) || $user->kdsatker != auth()->user()->kdsatker) {
                    abort(403);
                }
            }
        }else{
            $gate=['admin_satker'];
            if (! Gate::any($gate, auth()->user()->id) || $user->kdsatker != auth()->user()->kdsatker) {
                abort(403);
            }
        }

        return view('admin.user.edit',[
            'data' => $user
        ]);
    }

    public function store(Request $request)
    {
        
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker'];
            if (! Gate::any(['sys_admin'], auth()->user()->id)) {
                if (! Gate::any($gate, auth()->user()->id)) {
                    abort(403);
                }
    
                $request->validate([
                    'nama'=> 'required',
                    'nip'=> 'required|min:18|max:18|unique:users,nip',
                    'nohp'=> 'required|numeric|unique:users,nohp',
                ]);
        
                $request->validate([
                    'nip'=> 'numeric',
                ]);
        
                User::create([
                    'nama'=> $request->nama,
                    'nip'=> $request->nip,
                    'nohp'=> $request->nohp,
                    'kdsatker'=> auth()->user()->kdsatker,
                ]);
        
                return redirect('/admin/user')->with('berhasil', 'data berhasil di simpan.');
            }

            $request->validate([
                'nama'=> 'required',
                'nip'=> 'required|min:18|max:18|unique:users,nip',
                'nohp'=> 'required|numeric|unique:users,nohp',
                'kdsatker'=> 'required|min:6|max:6',
            ]);
    
            $request->validate([
                'nip'=> 'numeric',
                'kdsatker'=> 'numeric',
            ]);
    
            User::create([
                'nama'=> $request->nama,
                'nip'=> $request->nip,
                'nohp'=> $request->nohp,
                'kdsatker'=> $request->kdsatker,
                'kdunit' => $request->kdunit,
            ]);
    
            return redirect('/admin/user')->with('berhasil', 'data berhasil di simpan.');

        }else{
            $gate=['admin_satker'];
        }
        
        $request->validate([
            'nama'=> 'required',
            'nip'=> 'required|min:18|max:18|unique:users,nip',
            'nohp'=> 'required|numeric|unique:users,nohp',
        ]);

        $request->validate([
            'nip'=> 'numeric',
        ]);

        User::create([
            'nama'=> $request->nama,
            'nip'=> $request->nip,
            'nohp'=> $request->nohp,
            'kdsatker'=> auth()->user()->kdsatker,
        ]);

        return redirect('/admin/user')->with('berhasil', 'data berhasil di simpan.');
    }

    public function update(Request $request, User $user)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker'];
            if (! Gate::any(['sys_admin'], auth()->user()->id)) {
                if (! Gate::any($gate, auth()->user()->id) || $user->kdsatker != auth()->user()->kdsatker) {
                    abort(403);
                }
                $request->validate([
                    'nama'=> 'required',
                    'nip'=> 'required|min:18|max:18',
                    'nohp'=> 'required|numeric',
                ]);
        
                $request->validate([
                    'nip'=> 'numeric',
                ]);
        
                if ($request->nip != $user->nip && $request->nohp != $user->nohp) {
                    $request->validate([
                        'nip'=> 'required|min:18|max:18|unique:users,nip',
                        'nohp'=> 'required|numeric|unique:users,nohp',
                    ]);
                }elseif($request->nip != $user->nip){
                    $request->validate([
                        'nip'=> 'required|min:18|max:18|unique:users,nip',
                    ]);
                }elseif($request->nohp != $user->nohp){
                    $request->validate([
                        'nohp'=> 'required|numeric|unique:users,nohp',
                    ]);
                }
        
                $user->update([
                    'nama'=> $request->nama,
                    'nip'=> $request->nip,
                    'nohp'=> $request->nohp,
                ]);
        
                return redirect('/admin/user')->with('berhasil', 'data berhasil di ubah.');
            }
            $request->validate([
                'nama'=> 'required',
                'nip'=> 'required|min:18|max:18',
                'nohp'=> 'required|numeric',
                'kdsatker'=> 'required|min:6|max:6',
            ]);
    
            $request->validate([
                'nip'=> 'numeric',
                'kdsatker'=> 'numeric',
            ]);
    
            if ($request->nip != $user->nip && $request->nohp != $user->nohp) {
                $request->validate([
                    'nip'=> 'required|min:18|max:18|unique:users,nip',
                    'nohp'=> 'required|numeric|unique:users,nohp',
                ]);
            }elseif($request->nip != $user->nip){
                $request->validate([
                    'nip'=> 'required|min:18|max:18|unique:users,nip',
                ]);
            }elseif($request->nohp != $user->nohp){
                $request->validate([
                    'nohp'=> 'required|numeric|unique:users,nohp',
                ]);
            }
    
            $user->update([
                'nama'=> $request->nama,
                'nip'=> $request->nip,
                'nohp'=> $request->nohp,
                'kdsatker'=> $request->kdsatker,
                'kdunit' => $request->kdunit,
            ]);
    
            return redirect('/admin/user')->with('berhasil', 'data berhasil di ubah.');

        }else{
            $gate=['admin_satker'];
        }
        if (! Gate::any($gate, auth()->user()->id) || $user->kdsatker != auth()->user()->kdsatker) {
            abort(403);
        }
        $request->validate([
            'nama'=> 'required',
            'nip'=> 'required|min:18|max:18',
            'nohp'=> 'required|numeric',
        ]);

        $request->validate([
            'nip'=> 'numeric',
        ]);

        if ($request->nip != $user->nip && $request->nohp != $user->nohp) {
            $request->validate([
                'nip'=> 'required|min:18|max:18|unique:users,nip',
                'nohp'=> 'required|numeric|unique:users,nohp',
            ]);
        }elseif($request->nip != $user->nip){
            $request->validate([
                'nip'=> 'required|min:18|max:18|unique:users,nip',
            ]);
        }elseif($request->nohp != $user->nohp){
            $request->validate([
                'nohp'=> 'required|numeric|unique:users,nohp',
            ]);
        }
    }

    public function delete(User $user)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker'];
            if (! Gate::any(['sys_admin'], auth()->user()->id)) {
                if (! Gate::any($gate, auth()->user()->id) || $user->kdsatker != auth()->user()->kdsatker) {
                    abort(403);
                }
            }
        }else{
            $gate=['admin_satker'];
            if (! Gate::any($gate, auth()->user()->id) || $user->kdsatker != auth()->user()->kdsatker) {
                abort(403);
            }
        }

        $user->role()->detach();
        $user->delete();
        return redirect('/admin/user')->with('berhasil', 'data berhasil di hapus.');
    }

    public function role(User $user)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker'];
            if (! Gate::any(['sys_admin'], auth()->user()->id)) {
                if (! Gate::any($gate, auth()->user()->id) || $user->kdsatker != auth()->user()->kdsatker) {
                    abort(403);
                }
            }
        }else{
            $gate=['admin_satker'];
            if (! Gate::any($gate, auth()->user()->id) || $user->kdsatker != auth()->user()->kdsatker) {
                abort(403);
            }
        }
        return view('admin.user.role.index',[
            'data'=>$user,
            'role'=>$user->role()->sysAdmin()->get(),
        ]);
    }

    public function role_create(User $user)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker'];
            if (! Gate::any(['sys_admin'], auth()->user()->id)) {
                if (! Gate::any($gate, auth()->user()->id) || $user->kdsatker != auth()->user()->kdsatker) {
                    abort(403);
                }
            }
        }else{
            $gate=['admin_satker'];
            if (! Gate::any($gate, auth()->user()->id) || $user->kdsatker != auth()->user()->kdsatker) {
                abort(403);
            }
        }
        
        return view('admin.user.role.create',[
            'data'=>$user,
            'role'=>role::ofUser($user->id)->sysAdmin()->get()
        ]);
    }

    public function role_store(User $user,role $role)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker'];
            if (! Gate::any(['sys_admin'], auth()->user()->id)) {
                if (! Gate::any($gate, auth()->user()->id) || $user->kdsatker != auth()->user()->kdsatker || $role->kode === '01' || $role->kode === '02') {
                    abort(403);
                }
            }
        }else{
            $gate=['admin_satker'];
            if (! Gate::any($gate, auth()->user()->id) || $user->kdsatker != auth()->user()->kdsatker || $role->kode === '01' || $role->kode === '02') {
                abort(403);
            }
        }

        $user->role()->attach($role->id);
        return redirect('/admin/user/'.$user->nip.'/role')->with('berhasil', 'Role berhasil di tambah.');
    }

    public function role_delete(User $user,role $role)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker'];
            if (! Gate::any(['sys_admin'], auth()->user()->id)) {
                if (! Gate::any($gate, auth()->user()->id) || $user->kdsatker != auth()->user()->kdsatker || $role->kode === '01' || $role->kode === '02') {
                    abort(403);
                }
            }
        }else{
            $gate=['admin_satker'];
            if (! Gate::any($gate, auth()->user()->id) || $user->kdsatker != auth()->user()->kdsatker || $role->kode === '01' || $role->kode === '02') {
                abort(403);
            }
        }

        $user->role()->detach($role->id);
        return redirect('/admin/user/'.$user->nip.'/role')->with('berhasil', 'Role berhasil di hapus.');
    }
}
