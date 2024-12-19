<?php

namespace App\Http\Controllers;

use App\Models\dataHonorarium;
use App\Helper\AlikaNew\PenghasilanLain;

// API Alika Old
use App\Helper\Alika\API2\dataLain;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\dataPembayaranLainnya;
use Illuminate\Support\Facades\Storage;

class DataPaymentHonorariumController extends Controller
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

        return view('data-payment.honorarium.index', [
            'data' => dataHonorarium::satker()->pending(),
            'pageTitle' => 'Data Honorarium Pending',
            'honorariumKirim' => dataHonorarium::send(),
            'dataPembayaranLainnyaDraft' => dataPembayaranLainnya::draft(),
        ]);
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

        return view('data-payment.honorarium.detail', [
            'data' => dataHonorarium::dataPendingDetail($file)->paginate(15),
            'pageTitle' => 'Detail Honorarium Pending',
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

    public function tolak($file)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [''];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        dataHonorarium::dataPendingDetail($file)->update([
            'sts' => '0'
        ]);

        return redirect('/data-payment/honorarium')->with('berhasil', 'data berhasil di tolak');
    }

    public function tolakDetail(dataHonorarium $dataHonorarium)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [''];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($dataHonorarium->sts != '1') {
            abort(403);
        }
        $dataHonorarium->update(['sts' => '0']);
        return redirect('/data-payment/honorarium/' . $dataHonorarium->file . '/detail')->with('berhasil', 'data berhasil di hapus');
    }

    public function upload($file)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [''];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        try {
            $count = 0;
            foreach (dataHonorarium::dataPendingDetail($file)->get() as $item) {
                // $response = PenghasilanLain::post(
                //     [
                //         'bulan' => $item->bulan,
                //         'tahun' => $item->tahun,
                //         'kdsatker' => $item->kdsatker,
                //         'nip' => $item->nip,
                //         'bruto' => $item->bruto,
                //         'pph' => $item->pph,
                //         'netto' => $item->bruto - $item->pph,
                //         'jenis' => 'honorarium',
                //         'uraian' => $item->uraian,
                //         'tanggal' => $item->tanggal,
                //         'nospm' => $item->nospm ?? null,
                //     ]
                // );
                $response = dataLain::post(
                    [
                        'bulan' => $item->bulan,
                        'tahun' => $item->tahun,
                        'kdsatker' => $item->kdsatker,
                        'nip' => $item->nip,
                        'bruto' => $item->bruto,
                        'pph' => $item->pph,
                        'netto' => $item->bruto - $item->pph,
                        'jenis' => 'honorarium',
                        'uraian' => $item->uraian,
                        'tanggal' => $item->tanggal,
                        'nospm' => $item->nospm ?? null,
                    ]
                );
                if ($response->failed()) {
                    throw new \Exception($response);
                }
                $data = json_decode($response, false)->data ?? null;
                dataHonorarium::where('id', $item->id)->update(['sts' => '2', 'server_id' => $data->id ?? null]);
                $count++;
            }
            return redirect('/data-payment/honorarium')->with('berhasil', $count . " data berhasil di upload");
        } catch (\Throwable $th) {
            return redirect('/data-payment/honorarium')->with('gagal', $count . " data berhasil di upload, " . $th->getMessage());
        }
    }

    public function uploadDetail(dataHonorarium $dataHonorarium)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [''];
        }

        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($dataHonorarium->sts != '1') {
            abort(403);
        }
        try {
            // $response = PenghasilanLain::post([
            //     'bulan' => $dataHonorarium->bulan,
            //     'tahun' => $dataHonorarium->tahun,
            //     'kdsatker' => $dataHonorarium->kdsatker,
            //     'nip' => $dataHonorarium->nip,
            //     'bruto' => $dataHonorarium->bruto,
            //     'pph' => $dataHonorarium->pph,
            //     'netto' => $dataHonorarium->bruto - $dataHonorarium->pph,
            //     'jenis' => 'honorarium',
            //     'uraian' => $dataHonorarium->uraian,
            //     'tanggal' => $dataHonorarium->tanggal,
            //     'nospm' => $dataHonorarium->nospm,
            // ]);
            $response = dataLain::post(
                [
                    'bulan' => $dataHonorarium->bulan,
                    'tahun' => $dataHonorarium->tahun,
                    'kdsatker' => $dataHonorarium->kdsatker,
                    'nip' => $dataHonorarium->nip,
                    'bruto' => $dataHonorarium->bruto,
                    'pph' => $dataHonorarium->pph,
                    'netto' => $dataHonorarium->bruto - $dataHonorarium->pph,
                    'jenis' => 'honorarium',
                    'uraian' => $dataHonorarium->uraian,
                    'tanggal' => $dataHonorarium->tanggal,
                    'nospm' => $dataHonorarium->nospm ?? null,
                ]
            );
            if ($response->failed()) {
                throw new \Exception($response);
            }
            $data = json_decode($response, false)->data ?? null;
            $dataHonorarium->update(['sts' => '2', 'server_id' => $data->id ?? null]);
        } catch (\Exception $e) {
            return redirect('/data-payment/honorarium/' . $dataHonorarium->file . '/detail')->with('gagal', $e->getMessage());
        }

        return redirect('/data-payment/honorarium/' . $dataHonorarium->file . '/detail')->with('berhasil', 'data berhasil di Upload');
    }
}
