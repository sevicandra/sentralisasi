<?php

namespace App\Http\Controllers;

use App\Models\dataHonorarium;
use App\Helper\Alika\API2\dataLain;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class DataPaymentHonorariumController extends Controller
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

        return view('data-payment.honorarium.index',[
            'data'=>dataHonorarium::pending(),
            'pageTitle'=>'Data Honorarium Pending'
        ]);
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

        return view('data-payment.honorarium.detail',[
            'data'=>dataHonorarium::dataPendingDetail($file)->paginate(15),
            'pageTitle'=>'Detail Honorarium Pending'
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

    public function tolak($file)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[''];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        dataHonorarium::dataPendingDetail($file)->update([
            'sts'=>'0'
        ]);

        return redirect('/data-payment/honorarium')->with('berhasil', 'data berhasil di tolak');
    }

    public function tolakDetail(dataHonorarium $dataHonorarium)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[''];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if($dataHonorarium != '1'){
            abort(403);
        }
        $dataHonorarium->update(['sts'=>'0']);
        return redirect('/data-payment/honorarium/'.$dataHonorarium->file.'/detail')->with('berhasil', 'data berhasil di hapus');
    }

    public function upload($file)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[''];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        foreach (dataHonorarium::dataPendingDetail($file)->get() as $item) {
            try {
                $response=dataLain::post([
                    'bulan' => $item->bulan,
                    'tahun' => $item->tahun,
                    'kdsatker' => $item->kdsatker,
                    'nip' => $item->nip,
                    'bruto' => $item->bruto,
                    'pph' => $item->pph,
                    'netto' => $item->bruto-$item->pph,
                    'jenis' => 'honorarium',
                    'uraian' => $item->uraian,
                    'tanggal' => $item->tanggal,
                    'nospm' => $item->nospm,
                ]);
                
                if ($response->getStatusCode() != 200) {
                    throw new \Exception($response);
                }
                dataHonorarium::where('id', $item->id)->update([
                    'sts'=>'2'
                ]);
            } catch (\Exception $e) {
                return redirect('/data-payment/honorarium')->with('gagal', $e->getMessage());
            }
            
        }
        return redirect('/data-payment/honorarium')->with('berhasil', 'data berhasil di Upload');
    }

    public function uploadDetail(dataHonorarium $dataHonorarium)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[''];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if($dataHonorarium != '1'){
            abort(403);
        }
            try {
                $response=dataLain::post([
                    'bulan' => $dataHonorarium->bulan,
                    'tahun' => $dataHonorarium->tahun,
                    'kdsatker' => $dataHonorarium->kdsatker,
                    'nip' => $dataHonorarium->nip,
                    'bruto' => $dataHonorarium->bruto,
                    'pph' => $dataHonorarium->pph,
                    'netto' => $dataHonorarium->bruto-$dataHonorarium->pph,
                    'jenis' => 'honorarium',
                    'uraian' => $dataHonorarium->uraian,
                    'tanggal' => $dataHonorarium->tanggal,
                    'nospm' => $dataHonorarium->nospm,
                ]);
                
                if ($response->getStatusCode() != 200) {
                    throw new \Exception($response);
                }
                $dataHonorarium->update([
                    'sts'=>'2'
                ]);
            } catch (\Exception $e) {
                return redirect('/data-payment/honorarium/'.$dataHonorarium->file.'/detail')->with('gagal', $e->getMessage());
            }
            
        return redirect('/data-payment/honorarium/'.$dataHonorarium->file.'/detail')->with('berhasil', 'data berhasil di Upload');
    }
}
