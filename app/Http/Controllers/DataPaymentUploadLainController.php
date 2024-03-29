<?php

namespace App\Http\Controllers;

use App\Models\dataHonorarium;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\dataPembayaranLainnya;

class DataPaymentUploadLainController extends Controller
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
        $tahun =dataPembayaranLainnya::tahunUpload();
        if (!request('thn')) {
            if (isset($tahun->first()->tahun)) {
                $thn = $tahun->first()->tahun;
            }else{
                $thn = date('Y');
            }
        }else{
            $thn = request('thn');
        }

        $bulan =dataPembayaranLainnya::bulanUpload($thn);
        if (!request('bln')) {
            if (isset($bulan->first()->bulan)) {
                $bln = $bulan->first()->bulan;
            }else{
                $bln = date('m');
            }
        }else{
            $bln = request('bln');
        }
        
        return view('data-payment.pembayaran-lain-upload.index',[
            'data'=>dataPembayaranLainnya::satker()->satkerUpload($thn, $bln)->paginate(15)->withQueryString(),
            'tahun'=>$tahun,
            'bulan'=>$bulan,
            'thn'=>$thn,
            'bln'=>$bln,
            'pageTitle'=>'Data Pembayaran Lainnya Uploaded',
            'honorariumKirim'=>dataHonorarium::send(),
            'dataPembayaranLainnyaDraft'=>dataPembayaranLainnya::draft(),
        ]);
    }

    public function detail($kdsatker, $jenis, $thn, $bln)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[''];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        return view('data-payment.pembayaran-lain-upload.detail',[
            'data'=> dataPembayaranLainnya::detailPaymentUpload($kdsatker, $jenis, $thn, $bln)->paginate('15'),
            'pageTitle'=>'Detail Pembayaran Lainnya Uploaded',
            'honorariumKirim'=>dataHonorarium::send(),
            'dataPembayaranLainnyaDraft'=>dataPembayaranLainnya::draft(),
        ]);
    }

    public function drop($kdsatker, $jenis, $thn, $bln)
    {
        if (Auth::guard('web')->check()) {
            $gate=['adm_server'];
        }else{
            $gate=[''];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        dataPembayaranLainnya::detailPaymentUpload($kdsatker, $jenis, $thn, $bln)->update([
            'sts'=>'0'
        ]);

        return redirect('/data-payment/upload/lain')->with('berhasil', 'Data Berhasil Dikembalikan');
    }

    public function dropDetail(dataPembayaranLainnya $dataPembayaranLainnya)
    {
        if (Auth::guard('web')->check()) {
            $gate=['adm_server'];
        }else{
            $gate=[''];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if($dataPembayaranLainnya->sts != '1'){
            abort(403);
        }
        $dataPembayaranLainnya->update([
            'sts'=>'0'
        ]);
        return redirect('/data-payment/upload/lain/'.$dataPembayaranLainnya->kdsatker.'/'.$dataPembayaranLainnya->jenis.'/'.$dataPembayaranLainnya->tahun.'/'.$dataPembayaranLainnya->bulan.'/detail')->with('berhasil', 'Data Berhasil Dikembalikan');
    }
}
