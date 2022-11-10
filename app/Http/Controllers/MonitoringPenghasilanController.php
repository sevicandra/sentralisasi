<?php

namespace App\Http\Controllers;

use App\Models\satker;
use Illuminate\Http\Request;
use Spipu\Html2Pdf\Html2Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class MonitoringPenghasilanController extends Controller
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
        
        return view('monitoring.penghasilan.index',[
            'pageTitle'=>'Penghasilan',
            'data'=>satker::orderBy('jnssatker')->search()->paginate(15)->withQueryString(),
        ]);
    }

    public function satker(satker $satker)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
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

        if (request('search')) {
            $pegawai = Http::withToken($accesstoken)->get(config('hris.uri').'profil/Pegawai/GetByNip/'.request('search'));
            $pegawai_Collection = collect([json_decode($pegawai, false)->Data])->where('KdSatker', $satker->kdsatker);
        }else{
            $pegawai = Http::withToken($accesstoken)->get(config('hris.uri').'profil/pegawai/getByKodeSatker',[
                "kdSatker"=>$satker->kdsatker,
            ]);
            $pegawai_Collection = Collect(json_decode($pegawai, false)->Data)->where('StatusPegawai','Aktif')->sortBy([['Grading', 'desc'],['KodeOrganisasi', 'asc']])->values();
        };
        $data = $this->paginate($pegawai_Collection, 15, request('page'), ['path'=>' ']);
        return view('monitoring.penghasilan.rincian.index',[
            "pageTitle"=>"Rincian ".$satker->nmsatker,
            "data"=>$data
        ]);
    }

    public function satker_penghasilan(satker $satker, $nip=null, $thn=null)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($thn) {
            $thn = $thn;
        }else{
            $thn= date('Y');
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
        if ($pegawai_Collection->KdSatker != $satker->kdsatker) {
            return abort(403);
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

        return view('monitoring.penghasilan.rincian.penghasilan.index',[
            "pageTitle"=>"Penghasilan ".$pegawai_Collection->Nama. " / ". $pegawai_Collection->Nip18,
            "data"=>collect(json_decode($data, false)),
            "tahun"=>json_decode($tahun, false),
            'nip'=>$nip,
            'thn'=>$thn,
            'satker'=>$satker,
        ]);
    }

    public function satker_gaji(satker $satker,$nip=null, $thn=null, $jns=null)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
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
        if ($pegawai_Collection->KdSatker != $satker->kdsatker) {
            return abort(403);
        }

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

        return view('monitoring.penghasilan.rincian.gaji',[
            "pageTitle"=>"Gaji ".$pegawai_Collection->Nama. " / ". $pegawai_Collection->Nip18,
            "tahun"=>json_decode($tahun. false),
            "data"=>collect(json_decode($data, false)),
            "thn"=>$thn,
            "jns"=>$jns,
            'nip'=>$nip,
            'satker'=>$satker
        ]);
    }

    public function satker_uang_makan(satker $satker,$nip = null, $thn = null)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
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
        if ($pegawai_Collection->KdSatker != $satker->kdsatker) {
            return abort(403);
        }

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

        return view('monitoring.penghasilan.rincian.uang_makan',[
            "pageTitle"=>"Uang Makan ".$pegawai_Collection->Nama. " / ". $pegawai_Collection->Nip18,
            'data'=> collect(json_decode($data), false),
            'nip'=>$nip,
            'thn'=>$thn,
            'tahun'=>json_decode($tahun, false),
            'satker'=>$satker
        ]);
    }

    public function satker_uang_lembur(satker $satker, $nip = null, $thn = null)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
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
        if ($pegawai_Collection->KdSatker != $satker->kdsatker) {
            return abort(403);
        }

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
        return view('monitoring.penghasilan.rincian.uang_lembur',[
            "pageTitle"=>"Uang Lembur ".$pegawai_Collection->Nama. " / ". $pegawai_Collection->Nip18,
            'data'=> collect(json_decode($data), false),
            'nip'=>$nip,
            'thn'=>$thn,
            'tahun'=>json_decode($tahun, false),
            'satker'=>$satker
        ]);
    }

    public function satker_tunjangan_kinerja(satker $satker, $nip = null, $thn = null, $jns = null)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
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
        if ($pegawai_Collection->KdSatker != $satker->kdsatker) {
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

        return view('monitoring.penghasilan.rincian.tunjangan_kinerja',[
            "pageTitle"=>"Tunjangan Kinerja ".$pegawai_Collection->Nama. " / ". $pegawai_Collection->Nip18,
            'tahun'=>json_decode($tahun,false),
            'data'=>collect(json_decode($data,false)),
            'nip'=>$nip,
            'thn'=>$thn,
            'jns'=>$jns,
            'satker'=>$satker
        ]);
    }

    public function satker_lainnya(satker $satker, $nip = null, $thn = null, $jns = null)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
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
        if ($pegawai_Collection->KdSatker != $satker->kdsatker) {
            return abort(403);
        }

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

        return view('monitoring.penghasilan.rincian.lainnya.index',[
            "pageTitle"=>"Lainnya ".$pegawai_Collection->Nama. " / ". $pegawai_Collection->Nip18,
            'tahun'=>json_decode($tahun, false),
            'jenis'=>json_decode($jenis, false),
            'data'=>collect(json_decode($data, false)),
            'nip' => $nip,
            'thn'=>$thn,
            'jns'=>$jns,
            'satker'=>$satker
        ]);
    }

    public function satker_lainnya_detail(satker $satker, $nip, $thn, $jns, $bln)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
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
        if ($pegawai_Collection->KdSatker != $satker->kdsatker) {
            return abort(403);
        }
        
        $data=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri').'data-detail-lain',[
            'nip' => $nip,
            'thn'=>$thn,
            'jns'=>$jns,
            'bln'=>$bln,
            'X-API-KEY' => config('alika.key')
        ]);

        return view('monitoring.penghasilan.rincian.lainnya.detail',[
            "pageTitle"=>"Detail ".$pegawai_Collection->Nama. " / ". $pegawai_Collection->Nip18,
            'data'=>collect(json_decode($data, false)),
            'nip' => $nip,
            'thn'=>$thn,
            'jns'=>$jns,
            'satker'=>$satker
        ]);
    }

    public function satker_penghasilan_daftar()
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        ob_start();
        $html = ob_get_clean();
        $html2pdf = new Html2Pdf('L', 'A4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('Daftar Gaji');
        $html2pdf->writeHTML(view('monitoring.penghasilan.rincian.penghasilan.daftar'));
        $html2pdf->output('daftar-gaji-' . "januari" . "2022" . '.pdf', 'D');
    }

    public function satker_penghasilan_surat()
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        ob_start();
        $html = ob_get_clean();
        $html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('SKP');
        $html2pdf->writeHTML(view('monitoring.penghasilan.rincian.penghasilan.surat'));
        $html2pdf->output('skp-' . "januari" . "2022" . '.pdf', 'D');
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
