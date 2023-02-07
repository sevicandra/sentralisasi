<?php

namespace App\Http\Controllers;

use App\Models\dataHonorarium;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class DataPaymentUploadHonorariumController extends Controller
{
    public function index()
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[''];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        $tahun =dataHonorarium::tahunUpload();
        if (!request('thn')) {
            if (isset($tahun->first()->tahun)) {
                $thn = $tahun->first()->tahun;
            }else{
                $thn = date('Y');
            }
        }else{
            $thn = request('thn');
        }

        $bulan =dataHonorarium::bulanUpload($thn);
        if (!request('bln')) {
            if (isset($bulan->first()->bulan)) {
                $bln = $bulan->first()->bulan;
            }else{
                $bln = date('m');
            }
        }else{
            $bln = request('bln');
        }

        return view('data-payment.honorarium-upload.index',[
            'data'=>dataHonorarium::upload($thn, $bln),
            'tahun'=>$tahun,
            'bulan'=>$bulan,
            'thn'=>$thn,
            'bln'=>$bln,
            'pageTitle'=>'Data Honorarium Uploaded'
        ]);
    }

    public function dokumen($file)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[''];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        return response()->file(Storage::path('honorarium/'.$file.'.pdf'),[
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function drop($file)
    {
        if (Auth::guard('web')->check()) {
            $gate=['adm_server'];
        }else{
            $gate=[''];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        dataHonorarium::uploadDetail($file)->update([
            'sts' => '1'
        ]);
        return redirect('/data-payment/upload/honorarium')->with('berhasil', 'Data Berhasil Dikembalikan');
    }

    public function detail($file)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[''];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        return view('data-payment.honorarium-upload.detail',[
            'data'=>dataHonorarium::uploadDetail($file)->paginate(15),
            'pageTitle'=>'Detail Honorarium Uploaded'
        ]);
    }

    public function dropDetail(dataHonorarium $dataHonorarium)
    {
        if (Auth::guard('web')->check()) {
            $gate=['adm_server'];
        }else{
            $gate=[''];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if($dataHonorarium->sts !='2'){
            abort(403);
        }
        $dataHonorarium->update([
            'sts' => '1'
        ]);
        return redirect('/data-payment/upload/honorarium/'.$dataHonorarium->file.'/detail')->with('berhasil', 'Data Berhasil Dikembalikan');
    }
}
