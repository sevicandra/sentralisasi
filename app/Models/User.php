<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Uuids;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Uuids;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'nip',
        'nohp',
        'kdsatker',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'remember_token',
    ];

    public function scopeSatker(){
        return $this    ->join('satkers', 'users.kdsatker', '=','satkers.kdsatker')
                        ->select('users.*', 'satkers.nmsatker', 'satkers.order')
        ;
    }

    public function role()
    {
        return $this->belongsToMany(role::class);
    }

    public function is($access){
        foreach($this->role()->get() as $role){
            if ($role->kode === $access) {
                return true;
            }
        }
        return false;
    }

    public function scopeSysAdmin($data)
    {
        if (Auth::guard('web')->check()) {
            if (! Gate::allows('sys_admin', auth()->user()->id)) {
                return $data->where('kdsatker', auth()->user()->kdsatker);
            }
            return $data;
        }
        return $data->where('kdsatker', auth()->user()->kdsatker);
    }

    public function scopeSearch($data)
    {
        if(request('search')){
            return $data    ->where('nama', 'LIKE', '%'.request('search').'%')
                            ->orwhere('nip', 'LIKE', '%'.request('search').'%')
                            ->orwhere('users.kdsatker', 'LIKE', '%'.request('search').'%')
                            ->orwhere('nmsatker', 'LIKE', '%'.request('search').'%');
        }
    }

    public function scopeOrder($data)
    {
        $data->orderBy('order')->orderBy('nip');
    }
}