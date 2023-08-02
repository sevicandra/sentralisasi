<?php

namespace App\Http\Controllers;

use App\Models\satker;
use Illuminate\Http\Request;
use App\Helper\Alika\API2\dataSpt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\LengthAwarePaginator;

class SptMonitoringController extends Controller
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

        return view('spt.monitoring.index',[
            'data'=>satker::search()->order()->paginate(15)->withQueryString(),
            "pageTitle"=>"Monitoring SPT",
        ]);
    }

    public function satker(satker $satker){
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        if (!request('thn')) {
            $tahun = date('Y');
        }else{
            $tahun = request('thn');
        };
        $spt = Collect(dataSpt::getDataSpt($satker->kdsatker, $tahun), false);
        $data = $this->paginate($spt, 15, request('page'), ['path'=>' '])->withQueryString();
        
        return view('spt.monitoring.detail.index', [
            'data' => $data,
            "pageTitle"=>"SPT ".$satker->nmsatker,
            'tahun'=>dataSpt::getTahun($satker->kdsatker)
        ]);
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
