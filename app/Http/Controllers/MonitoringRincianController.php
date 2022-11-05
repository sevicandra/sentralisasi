<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spipu\Html2Pdf\Html2Pdf;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class MonitoringRincianController extends Controller
{

    public function index()
    {
        $token= Http::asForm()->post('https://sso.kemenkeu.go.id/connect/token',[
            'client_secret'=>'90bf0617c2fd45d5a35b288002fc9ece',
            'client_id' =>'alika.djkn',
            'grant_type'=>'client_credentials'
        ]);
        $accesstoken = json_decode($token, false)->access_token;

        if (request('search')) {
            $pegawai = Http::withToken($accesstoken)->get('https://service.kemenkeu.go.id/hris/profil/Pegawai/GetByNip/'.request('search'));
            $pegawai_Collection = collect([json_decode($pegawai, false)->Data])->where('KdSatker', 411792);
        }else{
            $pegawai = Http::withToken($accesstoken)->get('https://service.kemenkeu.go.id/hris/profil/pegawai/getByKodeSatker',[
                "kdSatker"=>411792,
            ]);
            $pegawai_Collection = Collect(json_decode($pegawai, false)->Data)->where('StatusPegawai','Aktif')->sortBy([['Grading', 'desc'],['KodeOrganisasi', 'asc']])->values();
        };

        $data = $this->paginate($pegawai_Collection, 15, request('page'), ['path'=>' ']);
        return view('monitoring.rincian.index',[
            "pageTitle"=>"Rincian",
            "data"=>$data
        ]);
    }

    public function penghasilan($nip=null, $thn=null)
    {
        if ($thn) {
            $thn = $thn;
        }else{
            $thn= date('Y');
        }

        $data=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri').'data-penghasilan',[
            'nip' => $nip,
            'thn' => $thn,
            'X-API-KEY' => config('alika.key')
        ]);

        $tahun=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri').'data-tahun-penghasilan',[
            'nip' => $nip,
            'X-API-KEY' => config('alika.key')
        ]);

        return view('monitoring.rincian.penghasilan.index',[
            "pageTitle"=>"Penghasilan",
            "data"=>collect(json_decode($data, false)),
            "tahun"=>json_decode($tahun, false),
            'nip'=>$nip,
            'thn'=>$thn
        ]);
    }

    public function gaji($nip=null, $thn=null, $jns=null)
    {
        if (!$thn) {
            $thn= date('Y');
        }
        switch ($jns) {
            case 'rutin':
                $data=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri').'data-gaji',[
                    'nip' => $nip,
                    'thn' => $thn,
                    'X-API-KEY' => config('alika.key')
                ]);
                break;
            
            case 'kekurangan':
                $data=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri').'data-kurang',[
                    'nip' => $nip,
                    'thn' => $thn,
                    'X-API-KEY' => config('alika.key')
                ]);
                break;
            
            default:
                $data=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri').'data-gaji',[
                    'nip' => $nip,
                    'thn' => $thn,
                    'X-API-KEY' => config('alika.key')
                ]);
                break;
        }

        $tahun=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri').'data-tahun-gaji',[
            'nip' => $nip,
            'X-API-KEY' => config('alika.key')
        ]);

        return view('monitoring.rincian.gaji',[
            "pageTitle"=>"Gaji",
            "tahun"=>json_decode($tahun. false),
            "data"=>collect(json_decode($data, false)),
            "thn"=>$thn,
            "jns"=>$jns,
            'nip'=>$nip
        ]);
    }

    public function uang_makan($nip = null, $thn = null)
    {
        if (!$thn) {
            $thn=date('Y');
        }
        
        $tahun=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri').'data-tahun-makan',[
            'nip' => $nip,
            'X-API-KEY' => config('alika.key')
        ]);

        $data=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri').'data-makan',[
            'nip' => $nip,
            'thn'=>$thn,
            'X-API-KEY' => config('alika.key')
        ]);

        return view('monitoring.rincian.uang_makan',[
            "pageTitle"=>"Uang Makan",
            'data'=> collect(json_decode($data), false),
            'nip'=>$nip,
            'thn'=>$thn,
            'tahun'=>json_decode($tahun, false)
        ]);
    }

    public function uang_lembur($nip = null, $thn = null)
    {
        if (!$thn) {
            $thn=date('Y');
        }
        
        $tahun=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri').'data-tahun-lembur',[
            'nip' => $nip,
            'X-API-KEY' => config('alika.key')
        ]);

        $data=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri').'data-lembur',[
            'nip' => $nip,
            'thn'=>$thn,
            'X-API-KEY' => config('alika.key')
        ]);
        return view('monitoring.rincian.uang_lembur',[
            "pageTitle"=>"Uang Lembur",
            'data'=> collect(json_decode($data), false),
            'nip'=>$nip,
            'thn'=>$thn,
            'tahun'=>json_decode($tahun, false)
        ]);
    }

    public function tunjangan_kinerja($nip = null, $thn = null, $jns = null)
    {
        switch ($jns) {
            case 'rutin':
                $jenis=0;
                break;
            
            case 'kekurangan':
                $jenis=1;
                break;
            
            default:
                $jenis=0;
                break;
        }

        if (!$thn) {
            $thn=date('Y');
        }
        
        $tahun=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri').'data-tahun-tukin',[
            'nip' => $nip,
            'X-API-KEY' => config('alika.key')
        ]);

        $data=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri').'data-tukin',[
            'nip' => $nip,
            'thn'=>$thn,
            'jns'=>$jenis,
            'X-API-KEY' => config('alika.key')
        ]);

        return view('monitoring.rincian.tunjangan_kinerja',[
            "pageTitle"=>"Tunjangan Kinerja",
            'tahun'=>json_decode($tahun,false),
            'data'=>collect(json_decode($data,false)),
            'nip'=>$nip,
            'thn'=>$thn,
            'jns'=>$jns
        ]);
    }

    public function lainnya($nip = null, $thn = null, $jns = null)
    {
        if (!$thn) {
            $thn=date('Y');
        }

        if (!$jns) {
            $jns='perjadin';
        }

        $tahun=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri').'data-tahun-lain',[
            'nip' => $nip,
            'X-API-KEY' => config('alika.key')
        ]);

        $jenis=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri').'data-jenis-lain',[
            'nip' => $nip,
            'thn'=>$thn,
            'X-API-KEY' => config('alika.key')
        ]);
        

        $data=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri').'data-lain',[
            'nip' => $nip,
            'thn'=>$thn,
            'jns'=>$jns,
            'X-API-KEY' => config('alika.key')
        ]);

        return view('monitoring.rincian.lainnya.index',[
            "pageTitle"=>"Lainnya",
            'tahun'=>json_decode($tahun, false),
            'jenis'=>json_decode($jenis, false),
            'data'=>collect(json_decode($data, false)),
            'nip' => $nip,
            'thn'=>$thn,
            'jns'=>$jns,
        ]);
    }

    public function lainnya_detail($nip, $thn, $jns, $bln)
    {
        $data=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri').'data-detail-lain',[
            'nip' => $nip,
            'thn'=>$thn,
            'jns'=>$jns,
            'bln'=>$bln,
            'X-API-KEY' => config('alika.key')
        ]);

        return view('monitoring.rincian.lainnya.detail',[
            "pageTitle"=>"Detail",
            'data'=>collect(json_decode($data, false)),
            'nip' => $nip,
            'thn'=>$thn,
            'jns'=>$jns,
        ]);
    }

    public function penghasilan_daftar()
    {
        ob_start();
        $html = ob_get_clean();
        $html2pdf = new Html2Pdf('L', 'A4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('Daftar Gaji');
        $html2pdf->writeHTML(view('monitoring.rincian.penghasilan.daftar'));
        $html2pdf->output('daftar-gaji-' . "januari" . "2022" . '.pdf', 'D');
    }

    public function penghasilan_surat()
    {
        ob_start();
        $html = ob_get_clean();
        $html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('SKP');
        $html2pdf->writeHTML(view('monitoring.rincian.penghasilan.surat'));
        $html2pdf->output('skp-' . "januari" . "2022" . '.pdf', 'D');
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
