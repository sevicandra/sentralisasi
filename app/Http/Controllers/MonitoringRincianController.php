<?php

namespace App\Http\Controllers;

use App\Helper\hris;
use App\Helper\Alika\API3\gaji;
use Spipu\Html2Pdf\Html2Pdf;
use App\Helper\Alika\API3\penghasilan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class MonitoringRincianController extends Controller
{

    public function index()
    {
        if (Auth::guard('web')->check()) {
            $gate=['opr_monitoring', 'plt_admin_satker'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $pegawai = hris::getPegawaiBySatker(auth()->user()->kdsatker);
        $status = $pegawai->unique('StatusPegawai')->pluck('StatusPegawai');
        $search = request('search');
        if (request('status')) {
            $pegawai_Collection = Collect($pegawai, false)->map(function($data){
                return(object)[
                    'Nama'=>$data->Nama,
                    'Nip18'=>$data->Nip18,
                    'StatusPegawai'=>$data->StatusPegawai,
                    'Grading'=>$data->Grading,
                    'KodeOrganisasi'=>$data->KodeOrganisasi,
                ];
            })->where('StatusPegawai',request('status'))->filter(function ($value) use ($search) {
                foreach ($value as $field) {
                    if (preg_match('/' . $search . '/i', $field)) {
                        return true;
                    }
                }
                return false;
            })->sortBy([['Grading', 'desc'],['KodeoOrganisasi', 'asc']])->values();
        }else{
            $pegawai_Collection = Collect($pegawai, false)->map(function($data){
                return (object)[
                    'Nama'=>$data->Nama,
                    'Nip18'=>$data->Nip18,
                    'StatusPegawai'=>$data->StatusPegawai,
                    'Grading'=>$data->Grading,
                    'KodeOrganisasi'=>$data->KodeOrganisasi,
                ];
            })->where('StatusPegawai','Aktif')->filter(function ($value) use ($search) {
                foreach ($value as $field) {
                    if (preg_match('/' . $search . '/i', $field)) {
                        return true;
                    }
                }
                return false;
            })->sortBy([['Grading', 'desc'],['KodeOrganisasi', 'asc']])->values();
        }

        $data = $this->paginate($pegawai_Collection, 15, request('page'), ['path'=>' '])->withQueryString();
        return view('monitoring.rincian.index',[
            "pageTitle"=>"Rincian",
            "data"=>$data,
            "status"=>$status
        ]);
    }

    public function penghasilan($nip=null, $thn=null)
    {
        if (Auth::guard('web')->check()) {
            $gate=['opr_monitoring', 'plt_admin_satker'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $pegawai_Collection = hris::getPegawai($nip)->first();

        if (!$pegawai_Collection) {
            return abort(404);
        }
        if ($pegawai_Collection->KdSatker != auth()->user()->kdsatker) {
            return abort(403);
        }

        if ($thn) {
            $thn = $thn;
        }else{
            $thn= date('Y');
        }

        return view('monitoring.rincian.penghasilan.index',[
            "pageTitle"=>"Penghasilan ".$pegawai_Collection->Nama. " / ". $pegawai_Collection->Nip18,
            "data"=>collect(penghasilan::getPenghasilan($nip, $thn)),
            "tahun"=>penghasilan::getTahunPenghasilan($nip),
            'nip'=>$nip,
            'thn'=>$thn
        ]);
    }

    public function gaji($nip=null, $thn=null, $jns=null)
    {
        if (Auth::guard('web')->check()) {
            $gate=['opr_monitoring', 'plt_admin_satker'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $pegawai_Collection = hris::getPegawai($nip)->first();

        if (!$pegawai_Collection) {
            return abort(404);
        }
        if ($pegawai_Collection->KdSatker != auth()->user()->kdsatker) {
            return abort(403);
        }

        if (!$thn) {
            $thn= date('Y');
        }
        switch ($jns) {
            case 'rutin':
                $data=gaji::getGaji($nip, $thn);
                break;
            
            case 'kekurangan':
                $data=gaji::getKekuranganGaji($nip, $thn);
                break;
            
            default:
                $data=gaji::getGaji($nip, $thn);
                break;
        }

        $tahun=gaji::getTahunGaji($nip);

        return view('monitoring.rincian.gaji',[
            "pageTitle"=>"Gaji ".$pegawai_Collection->Nama. " / ". $pegawai_Collection->Nip18,
            "tahun"=>$tahun,
            "data"=>collect($data, false),
            "thn"=>$thn,
            "jns"=>$jns,
            'nip'=>$nip
        ]);
    }

    public function uang_makan($nip = null, $thn = null)
    {
        if (Auth::guard('web')->check()) {
            $gate=['opr_monitoring', 'plt_admin_satker'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $pegawai_Collection = hris::getPegawai($nip)->first();

        if (!$pegawai_Collection) {
            return abort(404);
        }
        if ($pegawai_Collection->KdSatker != auth()->user()->kdsatker) {
            return abort(403);
        }

        if (!$thn) {
            $thn=date('Y');
        }
        
        $tahun=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri3').'data-tahun-makan',[
            'nip' => $nip,
            'X-API-KEY' => config('alika.key')
        ]);

        $data=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri3').'data-makan',[
            'nip' => $nip,
            'thn'=>$thn,
            'X-API-KEY' => config('alika.key')
        ]);

        return view('monitoring.rincian.uang_makan',[
            "pageTitle"=>"Uang Makan ".$pegawai_Collection->Nama. " / ". $pegawai_Collection->Nip18,
            'data'=> collect(json_decode($data), false),
            'nip'=>$nip,
            'thn'=>$thn,
            'tahun'=>json_decode($tahun, false)
        ]);
    }

    public function uang_lembur($nip = null, $thn = null)
    {
        if (Auth::guard('web')->check()) {
            $gate=['opr_monitoring', 'plt_admin_satker'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $token= Http::asForm()->post(config('hris.token_uri'),[
            'client_secret'=>config('hris.secret'),
            'client_id' =>config('hris.id'),
            'grant_type'=>config('hris.grant')
        ]);
        $accesstoken = json_decode($token, false)->access_token;
        $pegawai = Http::withToken($accesstoken)->get(config('hris.uri').'profil/Pegawai/GetByNip/'.$nip);
        $pegawai_Collection = collect([json_decode($pegawai, false)->Data])->first();

        if (!$pegawai_Collection) {
            return abort(404);
        }
        if ($pegawai_Collection->KdSatker != auth()->user()->kdsatker) {
            return abort(403);
        }

        if (!$thn) {
            $thn=date('Y');
        }
        
        $tahun=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri3').'data-tahun-lembur',[
            'nip' => $nip,
            'X-API-KEY' => config('alika.key')
        ]);

        $data=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri3').'data-lembur',[
            'nip' => $nip,
            'thn'=>$thn,
            'X-API-KEY' => config('alika.key')
        ]);
        return view('monitoring.rincian.uang_lembur',[
            "pageTitle"=>"Uang Lembur ".$pegawai_Collection->Nama. " / ". $pegawai_Collection->Nip18,
            'data'=> collect(json_decode($data), false),
            'nip'=>$nip,
            'thn'=>$thn,
            'tahun'=>json_decode($tahun, false)
        ]);
    }

    public function tunjangan_kinerja($nip = null, $thn = null, $jns = null)
    {
        if (Auth::guard('web')->check()) {
            $gate=['opr_monitoring', 'plt_admin_satker'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $token= Http::asForm()->post(config('hris.token_uri'),[
            'client_secret'=>config('hris.secret'),
            'client_id' =>config('hris.id'),
            'grant_type'=>config('hris.grant')
        ]);
        $accesstoken = json_decode($token, false)->access_token;
        $pegawai = Http::withToken($accesstoken)->get(config('hris.uri').'profil/Pegawai/GetByNip/'.$nip);
        $pegawai_Collection = collect([json_decode($pegawai, false)->Data])->first();

        if (!$pegawai_Collection) {
            return abort(404);
        }
        if ($pegawai_Collection->KdSatker != auth()->user()->kdsatker) {
            return abort(403);
        }

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
        
        $tahun=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri3').'data-tahun-tukin',[
            'nip' => $nip,
            'X-API-KEY' => config('alika.key')
        ]);

        $data=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri3').'data-tukin',[
            'nip' => $nip,
            'thn'=>$thn,
            'jns'=>$jenis,
            'X-API-KEY' => config('alika.key')
        ]);

        return view('monitoring.rincian.tunjangan_kinerja',[
            "pageTitle"=>"Tunjangan Kinerja ".$pegawai_Collection->Nama. " / ". $pegawai_Collection->Nip18,
            'tahun'=>json_decode($tahun,false),
            'data'=>collect(json_decode($data,false)),
            'nip'=>$nip,
            'thn'=>$thn,
            'jns'=>$jns
        ]);
    }

    public function lainnya($nip = null, $thn = null, $jns = null)
    {
        if (Auth::guard('web')->check()) {
            $gate=['opr_monitoring', 'plt_admin_satker'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $token= Http::asForm()->post(config('hris.token_uri'),[
            'client_secret'=>config('hris.secret'),
            'client_id' =>config('hris.id'),
            'grant_type'=>config('hris.grant')
        ]);
        $accesstoken = json_decode($token, false)->access_token;
        $pegawai = Http::withToken($accesstoken)->get(config('hris.uri').'profil/Pegawai/GetByNip/'.$nip);
        $pegawai_Collection = collect([json_decode($pegawai, false)->Data])->first();

        if (!$pegawai_Collection) {
            return abort(404);
        }
        if ($pegawai_Collection->KdSatker != auth()->user()->kdsatker) {
            return abort(403);
        }

        if (!$thn) {
            $thn=date('Y');
        }

        if (!$jns) {
            $jns='perjadin';
        }

        $tahun=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri3').'data-tahun-lain',[
            'nip' => $nip,
            'X-API-KEY' => config('alika.key')
        ]);

        $jenis=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri3').'data-jenis-lain',[
            'nip' => $nip,
            'thn'=>$thn,
            'X-API-KEY' => config('alika.key')
        ]);
        

        $data=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri3').'data-lain',[
            'nip' => $nip,
            'thn'=>$thn,
            'jns'=>$jns,
            'X-API-KEY' => config('alika.key')
        ]);

        return view('monitoring.rincian.lainnya.index',[
            "pageTitle"=>"Lainnya ".$pegawai_Collection->Nama. " / ". $pegawai_Collection->Nip18,
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
        if (Auth::guard('web')->check()) {
            $gate=['opr_monitoring', 'plt_admin_satker'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $token= Http::asForm()->post(config('hris.token_uri'),[
            'client_secret'=>config('hris.secret'),
            'client_id' =>config('hris.id'),
            'grant_type'=>config('hris.grant')
        ]);
        $accesstoken = json_decode($token, false)->access_token;
        $pegawai = Http::withToken($accesstoken)->get(config('hris.uri').'profil/Pegawai/GetByNip/'.$nip);
        $pegawai_Collection = collect([json_decode($pegawai, false)->Data])->first();

        if (!$pegawai_Collection) {
            return abort(404);
        }
        if ($pegawai_Collection->KdSatker != auth()->user()->kdsatker) {
            return abort(403);
        }
        
        $data=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri3').'data-detail-lain',[
            'nip' => $nip,
            'thn'=>$thn,
            'jns'=>$jns,
            'bln'=>$bln,
            'X-API-KEY' => config('alika.key')
        ]);

        return view('monitoring.rincian.lainnya.detail',[
            "pageTitle"=>"Detail ".$pegawai_Collection->Nama. " / ". $pegawai_Collection->Nip18,
            'data'=>collect(json_decode($data, false)),
            'nip' => $nip,
            'thn'=>$thn,
            'jns'=>$jns,
        ]);
    }

    public function penghasilan_daftar()
    {
        if (Auth::guard('web')->check()) {
            $gate=['opr_monitoring', 'plt_admin_satker'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
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
        if (Auth::guard('web')->check()) {
            $gate=['opr_monitoring', 'plt_admin_satker'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
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
