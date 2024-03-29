<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class adminSatker extends Authenticatable
{
    use Uuids;
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'kdunit',
        'nmjabatan',
        'kdsatker',
    ];

    protected $hidden = [
        'id',
        'remember_token',
    ];

    public function scopeSatker()
    {
        return $this    ->join('satkers', 'admin_satkers.kdsatker', '=', 'satkers.kdsatker')
                        ->select('admin_satkers.*', 'satkers.nmsatker');
    }
    public function scopeOrder($data)
    {
        return $data    ->orderBy('kdunit');
    }
    public function role()
    {
        return $this->belongsTo(role::class, 'role', 'kode');
    }

    public function is($access){
        foreach($this->role()->get() as $role){
            if ($role->kode === $access) {
                return true;
            }
        }
        return false;
    }
}
