<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        })->get();
    }
}
