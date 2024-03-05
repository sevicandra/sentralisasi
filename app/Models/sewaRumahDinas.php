<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class sewaRumahDinas extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'nip',
        'nama',
        'kdsatker',
        'tmt',
        'nomor_sip',
        'tanggal_sip',
        'nilai_potongan',
        'status',
        'file',
        'tanggal_selesai',
        'catatan',
        'alasan_penghentian',
        'tanggal_kirim',
        'tanggal_approve',
        'tanggal_usulan_non_aktif'
    ];

    public function scopeDashboardSatker()
    {
        return $this->where('kdsatker', auth()->user()->kdsatker)
            ->where('status', '!=', 'non_aktif')
            ->where('catatan', null)
            ->orderBy('tmt', 'desc');
    }

    public function scopeUsulan()
    {
        return $this->where('status', 'pengajuan')
            ->where('catatan', null)
            ->leftJoin('satkers', 'sewa_rumah_dinas.kdsatker', '=', 'satkers.kdsatker')
            ->select(['sewa_rumah_dinas.*', 'satkers.nmsatker'])
            ->orderBy('updated_at', 'desc');
    }

    public function scopeReject()
    {
        return $this->where('kdsatker', auth()->user()->kdsatker)
            ->where('status', 'draft')
            ->where('catatan', "!=", null)
            ->orderBy('updated_at', 'desc');
    }

    public function scopePenghentian()
    {
        return $this->where('status', 'usulan_non_aktif')
            ->where('catatan', null)
            ->leftJoin('satkers', 'sewa_rumah_dinas.kdsatker', '=', 'satkers.kdsatker')
            ->select(['sewa_rumah_dinas.*', 'satkers.nmsatker'])
            ->orderBy('updated_at', 'desc');
    }

    public function scopeNonAktif()
    {
        return $this->where('kdsatker', auth()->user()->kdsatker)
            ->where('status', 'non_aktif')
            ->orderBy('tanggal_selesai', 'desc');
    }

    public function scopeMonitoring()
    {
        return  DB::table('satkers')
            ->Leftjoin('sewa_rumah_dinas', function (JoinClause $join) {
                $join->on('satkers.kdsatker', '=', 'sewa_rumah_dinas.kdsatker')
                    ->where('status', '!=', 'draft')
                    ->where('status', '!=', 'non_aktif')
                    ->where('status', '!=', 'pengajuan');
            })
            ->groupBy('satkers.kdsatker')
            ->orderBy('satkers.order')
            ->selectRaw('satkers.kdsatker, satkers.nmsatker, count(sewa_rumah_dinas.id) as total');
    }

    public function scopeMonitoringNonAktif()
    {
        return  DB::table('satkers')
            ->Leftjoin('sewa_rumah_dinas', function (JoinClause $join) {
                $join->on('satkers.kdsatker', '=', 'sewa_rumah_dinas.kdsatker')
                    ->where('status', '=', 'non_aktif');
            })
            ->groupBy('satkers.kdsatker')
            ->orderBy('satkers.order')
            ->selectRaw('satkers.kdsatker, satkers.nmsatker, count(sewa_rumah_dinas.id) as total');
    }

    public function scopeMonitoringWilayah($data, $kdsatker)
    {
        return  DB::table('satkers')
            ->where('satkers.kdkoordinator', $kdsatker)
            ->Leftjoin('sewa_rumah_dinas', function (JoinClause $join) {
                $join->on('satkers.kdsatker', '=', 'sewa_rumah_dinas.kdsatker')
                    ->where('status', '!=', 'draft')
                    ->where('status', '!=', 'non_aktif')
                    ->where('status', '!=', 'pengajuan');
            })
            ->groupBy('satkers.kdsatker')
            ->orderBy('satkers.order')
            ->selectRaw('satkers.kdsatker, satkers.nmsatker, count(sewa_rumah_dinas.id) as total');
    }

    public function scopeMonitoringDetail($data, $kdsatker)
    {
        return $data->where('kdsatker', $kdsatker)
            ->where('status', '!=', 'non_aktif')
            ->where('catatan', null)
            ->orderBy('tmt', 'desc');
    }

    public function scopeMonitorinNonAktifDetail($data, $kdsatker)
    {
        return $data->where('kdsatker', $kdsatker)
            ->where('status', '=', 'non_aktif')
            ->where('catatan', null)
            ->orderBy('tmt', 'desc');
    }

    public function scopeCountUsulan()
    {
        if (Auth::guard('web')->check()) {
            if (Gate::any(['sys_admin'], auth()->user()->id)) {
                return  $this->where('status', 'pengajuan')
                    ->where('catatan', null)
                    ->count();
            }
            return 0;
        } else {
            return 0;
        }
    }

    public function scopeCountPenghentian()
    {
        if (Auth::guard('web')->check()) {
            if (Gate::any(['sys_admin'], auth()->user()->id)) {
                return  $this->where('status', 'usulan_non_aktif')
                    ->where('catatan', null)
                    ->count();
            }
            return 0;
        } else {
            return 0;
        }
    }

    public function scopeCountReject()
    {
        if (Auth::guard('web')->check()) {
            if (Gate::any(['plt_admin_satker', 'opr_rumdin'], auth()->user()->id)) {
                return  $this->where('kdsatker', auth()->user()->kdsatker)
                    ->where('status', 'draft')
                    ->where('catatan', "!=", null)
                    ->count();
            }
            return 0;
        } else {
            if (Gate::any(['admin_satker'], auth()->user()->id)) {
                return  $this->where('kdsatker', auth()->user()->kdsatker)
                    ->where('status', 'draft')
                    ->where('catatan', "!=", null)
                    ->count();
            }
            return 0;
        }
    }

    public function scopePotonganAktif($data, $nip)
    {
        return $data->where('nip', $nip)
            ->where(function (Builder $query) {
                $query->where('status', '=', 'draft')->orwhere('status', '=', 'aktif')->orwhere('status', '=', 'pengajuan')->orwhere('status', '=', 'usulan_non_aktif');
            })->leftJoin('satkers', 'sewa_rumah_dinas.kdsatker', '=', 'satkers.kdsatker')
            ->select(['sewa_rumah_dinas.nama', 'sewa_rumah_dinas.nip', 'satkers.nmsatker'])
            ;
    }
}
