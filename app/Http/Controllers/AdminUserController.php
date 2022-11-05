<?php

namespace App\Http\Controllers;

use App\Models\role;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        return view('admin.user.index',[
            'data'=>User::paginate(15)
        ]);
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function edit(User $user)
    {
        return view('admin.user.edit',[
            'data' => $user
        ]);
    }

    public function store(Request $request)
    {
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
        ]);

        return redirect('/admin/user')->with('berhasil', 'data berhasil di simpan.');
    }

    public function update(Request $request, User $user)
    {

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
        ]);

        return redirect('/admin/user')->with('berhasil', 'data berhasil di ubah.');
    }

    public function delete(User $user)
    {
        $user->delete();
        return redirect('/admin/user')->with('berhasil', 'data berhasil di hapus.');
    }

    public function role(User $user)
    {
        return view('admin.user.role.index',[
            'data'=>$user,
            'role'=>$user->role
        ]);
    }

    public function role_create(User $user)
    {
        return view('admin.user.role.create',[
            'data'=>$user,
            'role'=>role::ofUser($user->id)
        ]);
    }

    public function role_store(User $user, $role)
    {
        $user->role()->attach($role);
        return redirect('/admin/user/'.$user->nip.'/role')->with('berhasil', 'Role berhasil di tambah.');
    }

    public function role_delete(User $user, $role)
    {
        $user->role()->detach($role);
        return redirect('/admin/user/'.$user->nip.'/role')->with('berhasil', 'Role berhasil di hapus.');
    }
}
