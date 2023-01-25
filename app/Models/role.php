<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class role extends Model
{
    use Uuids;
    use HasFactory;
    protected $fillable = [
        'kode',
        'role',
    ];

    public function user()
    {
        return $this->belongsToMany(User::class);
    }

    public function scopeOfUser($data, $user)
    {
        $var = $user;
        return $data->whereDoesntHave('User', function($val)use($var){
            $val->where('id', $var);
        });
    }

    public function scopeSysAdmin($data)
    {
        if (Auth::guard('web')->check()) {
            if (! Gate::allows('sys_admin', auth()->user()->id)) {
                return  $data->where('kode', '!=', '02')->where('kode', '!=', '01');
            }
            return  $data;
        }
        return  $data->where('kode', '!=', '02')->where('kode', '!=', '01');
    }
}
