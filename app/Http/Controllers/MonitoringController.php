<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class MonitoringController extends Controller
{
    public function index()
    {
        switch (request('jns')) {
            case 'gaji-rutin':
                $endpoint= "gaji-rutin";
                break;

            case 'kekurangan-gaji':
                $endpoint= "kekurangan-gaji";
                break;

            case 'uang-makan':
                $endpoint= "uang-makan";
                break;
                
            case 'uang-lembur':
                $endpoint= "uang-lembur";
                break;
                
            case 'tukin-rutin':
                $endpoint= "tukin-rutin";
                break;
                
            case 'kekurangan-tukin':
                $endpoint= "kekurangan-tukin";
                break;
            default:
                $endpoint= "gaji-rutin";
                break;
        }

        if (request('thn') != null) {
            $tahun = request('thn');
        }else{
            $tahun = date('Y');
        }

        $response = Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get( config('alika.uri').$endpoint,[
            'tahun' => $tahun,
            'kdsatker' => 411792,
            'X-API-KEY' => config('alika.key')
        ]);

        $thnsatker = Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri').'tahun-satker',[
            'kdsatker' => 411792,
            'X-API-KEY' => 'hGfdg456ghD4f566afjh6Fg@hgb#jijk'
        ]);

        return view('monitoring.beranda.index',[
            'pageTitle'=> 'Beranda',
            'data'=>json_decode($response, false),
            'tahun'=>json_decode($thnsatker,false)
        ]);
    }
    
    public function detail()
    {
        switch (request('jns')) {
            case 'gaji-rutin':
                $endpoint= "detail-gaji-rutin";
                break;

            case 'kekurangan-gaji':
                $endpoint= "detail-kekurangan-gaji";
                break;

            case 'uang-makan':
                $endpoint= "detail-uang-makan";
                break;
                
            case 'uang-lembur':
                $endpoint= "detail-uang-lembur";
                break;
                
            case 'tukin-rutin':
                $endpoint= "detail-tukin-rutin";
                break;
                
            case 'kekurangan-tukin':
                $endpoint= "detail-kekurangan-tukin";
                break;
            default:
                $endpoint= "detail-gaji-rutin";
                break;
        }

        if (request('thn') != null) {
            $tahun = request('thn');
        }else{
            $tahun = date('Y');
        }

        if (request('bln') != null) {
            $bulan = request('bln');
        }else{
            $bulan = date('mm');
        }

        $response = Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get( config('alika.uri').$endpoint,[
            'bulan' => $bulan,
            'tahun' => $tahun,
            'kdsatker' => 411792,
            'X-API-KEY' => config('alika.key')
        ]);
        $data = $this->paginate(json_decode($response, false), 10, request('page'),['path'=>'detail'])->withQueryString();
        switch (request('jns')) {
            case 'gaji-rutin':

                return view('monitoring.beranda.detail.gaji_rutin',[
                    'pageTitle'=> 'Detail Gaji Rutin',
                    'data'=>$data
                ]);                
                break;

            case 'kekurangan-gaji':
                return view('monitoring.beranda.detail.kekurangan_gaji',[
                    'pageTitle'=> 'Detail Kekurangan Gaji',
                    'data'=>$data
                ]);
                break;

            case 'uang-makan':
                return view('monitoring.beranda.detail.uang_makan',[
                    'pageTitle'=> 'Detail Uang Makan',
                    'data'=>$data
                ]);
                break;
                
            case 'uang-lembur':
                return view('monitoring.beranda.detail.uang_lembur',[
                    'pageTitle'=> 'Detail Uang Lembur',
                    'data'=>$data
                ]);
                break;
                
            case 'tukin-rutin':
                return view('monitoring.beranda.detail.tukin_rutin',[
                    'pageTitle'=> 'Detail Tukin Rutin',
                    'data'=>$data
                ]);
                break;
                
            case 'kekurangan-tukin':
                return view('monitoring.beranda.detail.kekurangan_tukin',[
                    'pageTitle'=> 'Detail Kekurangan Tukin',
                    'data'=>$data
                ]);
                break;
            default:
                return view('monitoring.beranda.detail.gaji_rutin',[
                    'pageTitle'=> 'Detail Gaji Rutin',
                    'data'=>$data
                ]);
                break;
        }
    }
    
    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
