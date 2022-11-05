<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class satker extends Model
{
    use Uuids;
    use HasFactory;
    protected $fillable = [
        'kdsatker',
        'nmsatker',
        'kdkoordinator',
    ];

    public function scopeSearch()
    {
        if (request('search')) {
            return $this->where('kdsatker', 'LIKE','%'.request('search').'%')->orWhere('nmsatker','LIKE', '%'.request('search').'%');
        }
    }

}
