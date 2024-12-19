<?php

namespace App\Http\Controllers;

use App\Models\dataHonorarium;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\dataPembayaranLainnya;

// API Alika Old
use App\Helper\Alika\API2\dataLain;

use Illuminate\Support\Facades\Storage;
use App\Helper\AlikaNew\PenghasilanLain;

class DataPaymentUploadHonorariumController extends Controller
{
    public function index()
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [''];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        $tahun = dataHonorarium::tahunUpload();
        if (!request('thn')) {
            if (isset($tahun->first()->tahun)) {
                $thn = $tahun->first()->tahun;
            } else {
                $thn = date('Y');
            }
        } else {
            $thn = request('thn');
        }

        $bulan = dataHonorarium::bulanUpload($thn);
        if (!request('bln')) {
            if (isset($bulan->first()->bulan)) {
                $bln = $bulan->first()->bulan;
            } else {
                $bln = date('m');
            }
        } else {
            $bln = request('bln');
        }

        return view('data-payment.honorarium-upload.index', [
            'data' => dataHonorarium::satker()->upload($thn, $bln)->paginate(15)->withQueryString(),
            'tahun' => $tahun,
            'bulan' => $bulan,
            'thn' => $thn,
            'bln' => $bln,
            'pageTitle' => 'Data Honorarium Uploaded',
            'honorariumKirim' => dataHonorarium::send(),
            'dataPembayaranLainnyaDraft' => dataPembayaranLainnya::draft(),
        ]);
    }

    public function dokumen($file)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [''];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        return response()->file(Storage::path('honorarium/' . $file . '.pdf'), [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function drop($file)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['adm_server'];
        } else {
            $gate = [''];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        try {
            foreach (dataHonorarium::uploadDetail($file)->get() as $item) {
                if ($item->server_id) {
                    // $response = PenghasilanLain::destroy($item->server_id);
                    $response = dataLain::delete($item->server_id);
                    if ($response->failed()) {
                        throw new \Exception($response);
                    }
                }
                dataHonorarium::where('id', $item->id)->update([
                    'server_id' => null,
                    'sts' => '1'
                ]);
            }
            return redirect('/data-payment/upload/honorarium')->with('berhasil', 'Data Berhasil Dikembalikan');
        } catch (\Throwable $th) {
            return redirect('/data-payment/upload/honorarium')->with('gagal', $th->getMessage());
        }
    }

    public function detail($file)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [''];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        return view('data-payment.honorarium-upload.detail', [
            'data' => dataHonorarium::uploadDetail($file)->paginate(15),
            'pageTitle' => 'Detail Honorarium Uploaded',
            'honorariumKirim' => dataHonorarium::send(),
            'dataPembayaranLainnyaDraft' => dataPembayaranLainnya::draft(),
        ]);
    }

    public function dropDetail(dataHonorarium $dataHonorarium)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['adm_server'];
        } else {
            $gate = [''];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($dataHonorarium->sts != '2') {
            abort(403);
        }

        try {
            if ($dataHonorarium->server_id) {
                // $response = PenghasilanLain::destroy($dataHonorarium->server_id);
                $response = dataLain::delete($dataHonorarium->server_id);
                if ($response->failed()) {
                    throw new \Exception($response);
                }
            }
            $dataHonorarium->update([
                'sts' => '1',
                'server_id' => null
            ]);
            return redirect('/data-payment/upload/honorarium/' . $dataHonorarium->file . '/detail')->with('berhasil', 'Data Berhasil Dikembalikan');
        } catch (\Throwable $th) {
            return redirect('/data-payment/upload/honorarium/' . $dataHonorarium->file . '/detail')->with('gagal', $th->getMessage());
        }
    }
}
