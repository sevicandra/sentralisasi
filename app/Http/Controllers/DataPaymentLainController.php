<?php

namespace App\Http\Controllers;

use App\Models\bulan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\dataHonorarium;
use Illuminate\Support\Carbon;
use App\Helper\Alika\API2\dataLain;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\dataPembayaranLainnya;
use Illuminate\Support\Facades\Storage;

class DataPaymentLainController extends Controller
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
        $tahun =dataPembayaranLainnya::tahunPending();
        if (!request('thn')) {
            if (isset($tahun->first()->tahun)) {
                $thn = $tahun->first()->tahun;
            }else{
                $thn = date('Y');
            }
        }else{
            $thn = request('thn');
        }

        $bulan =dataPembayaranLainnya::bulanPending($thn);
        if (!request('bln')) {
            if (isset($bulan->first()->bulan)) {
                $bln = $bulan->first()->bulan;
            }else{
                $bln = date('m');
            }
        }else{
            $bln = request('bln');
        }

        return view('data-payment.pembayaran-lain.index',[
            'data'=>dataPembayaranLainnya::satker()->satkerPending($thn, $bln)->get(),
            'tahun'=>$tahun,
            'bulan'=>$bulan,
            'thn'=>$thn,
            'bln'=>$bln,
            'pageTitle'=>'Data Pembayaran Lainnya',
            'honorariumKirim'=>dataHonorarium::send(),
            'dataPembayaranLainnyaDraft'=>dataPembayaranLainnya::draft(),
        ]);
    }

    public function create()
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[''];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        return view('data-payment.pembayaran-lain.create',[
            'pageTitle'=>'Impor Pembayaran Lainnya',
            'honorariumKirim'=>dataHonorarium::send(),
            'dataPembayaranLainnyaDraft'=>dataPembayaranLainnya::draft(),
        ]);
    }

    public function impor(Request $request)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[''];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        $request->validate([
            'file_excel'=>'required|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ],[
            'file_excel.mimetypes'=>'The file must be a xlsx file',
        ]);
        
        $file = $request->file('file_excel');
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($file);
        $sheetData = $spreadsheet->getSheetByName('honorarium')->toArray();
        $slicedSheet = array_slice($sheetData, 2);
        foreach ($slicedSheet as $item) {
            if ($item[0] === null) {
                break;
            }
            $date = Carbon::createFromFormat('d-m-Y', $item[10])->timestamp;
            dataPembayaranLainnya::create([
                'bulan'=>$item[1],
                'nmbulan'=>bulan::nmbulan($item[1]),
                'tahun'=>$item[2],
                'kdsatker'=>$item[3],
                'jenis'=>$item[4],
                'nama'=>$item[5],
                'nip'=>$item[6],
                'bruto'=>$item[7],
                'pph'=>$item[8],
                'uraian'=>$item[9],
                'tanggal'=>$date,
            ]);
        }
        return redirect('/data-payment/lain')->with('berhasil', 'Data Berhasil Ditambahkan');
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
        return view('data-payment.pembayaran-lain.detail.index',[
            'data'=> dataPembayaranLainnya::detailPaymentPending($kdsatker, $jenis, $thn, $bln)->paginate('15'),
            'pageTitle'=>'Detail Pembayaran Lainnya',
            'honorariumKirim'=>dataHonorarium::send(),
            'dataPembayaranLainnyaDraft'=>dataPembayaranLainnya::draft(),
        ]);
    }

    public function edit(dataPembayaranLainnya $dataPembayaranLainnya)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[''];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if($dataPembayaranLainnya->sts != '0'){
            abort(403);
        }
        return view('data-payment.pembayaran-lain.detail.edit',[
            'data'=>$dataPembayaranLainnya,
            'pageTitle'=>'Edit Pembayaran Lainnya',
            'honorariumKirim'=>dataHonorarium::send(),
            'dataPembayaranLainnyaDraft'=>dataPembayaranLainnya::draft(),
        ]);
    }

    public function update(Request $request, dataPembayaranLainnya $dataPembayaranLainnya)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[''];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if($dataPembayaranLainnya->sts != '0'){
            abort(403);
        }
        $request->validate([
            'nama'=>'required',
            'nip'=>'required|min:18|max:18',
            'bruto'=>'required|numeric',
            'pph'=>'required|numeric',
            'tanggal'=>'required',
            'uraian'=>'required',
        ]);

        $request->validate([
            'nip'=>'numeric',
        ]);

        $dataPembayaranLainnya->update([
            'nama'=>$request->nama,
            'nip'=>$request->nip,
            'bruto'=>$request->bruto,
            'pph'=>$request->pph,
            'tanggal'=>Carbon::createFromFormat('d-m-Y', $request->tanggal)->timestamp,
            'uraian'=>$request->uraian,
        ]);

        return redirect('/data-payment/lain/'.$dataPembayaranLainnya->kdsatker.'/'.$dataPembayaranLainnya->jenis.'/'.$dataPembayaranLainnya->tahun.'/'.$dataPembayaranLainnya->bulan.'/detail')
                ->with('berhasil', 'Data Berhasil di Ubah');
    }

    public function delete($kdsatker, $jenis, $thn, $bln)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[''];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        dataPembayaranLainnya::detailPaymentPending($kdsatker, $jenis, $thn, $bln)->delete();
        return redirect('/data-payment/lain?thn='.$thn.'&bln='.$bln)->with('berhasil', 'Data Berhasil Di Hapus');
    }

    public function deletedetail(dataPembayaranLainnya $dataPembayaranLainnya)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[''];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if($dataPembayaranLainnya->sts != '0'){
            abort(403);
        }
        $dataPembayaranLainnya->delete();
        return redirect('/data-payment/lain/'.$dataPembayaranLainnya->kdsatker.'/'.$dataPembayaranLainnya->jenis.'/'.$dataPembayaranLainnya->tahun.'/'.$dataPembayaranLainnya->bulan.'/detail')
        ->with('berhasil', 'Data Berhasil di Hapus');
    }

    public function upload($kdsatker, $jenis, $thn, $bln)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[''];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $filename='data-payment-lain/'.Str::uuid().'.json';
        $data= collect();
        foreach (dataPembayaranLainnya::paymentPending($kdsatker, $jenis, $thn, $bln)->get() as $item) {
            $data->push((object)[
                'bulan' => $item->bulan,
                'tahun' => $item->tahun,
                'kdsatker' => $item->kdsatker,
                'nip' => $item->nip,
                'bruto' => $item->bruto,
                'pph' => $item->pph,
                'jenis' => $item->jenis,
                'uraian' => $item->uraian,
                'tanggal' => $item->tanggal,
                'nospm' => '',
            ]);
        }
        Storage::put($filename, $data);
        $response=dataLain::postMasal(Storage::path($filename), 'data.json');

        if (json_decode($response)->status != true) {
            dataPembayaranLainnya::paymentPending($kdsatker, $jenis, $thn, $bln)->limit(json_decode($response)->count)
            ->update([
                'sts'=>'1'                
            ]);
            return redirect('/data-payment/lain?thn='.$thn.'&bln='.$bln)->with('pesan', json_decode($response)->count. json_decode($response)->message);
        }
        dataPembayaranLainnya::paymentPending($kdsatker, $jenis, $thn, $bln)->update([
            'sts'=>'1'
        ]);
        Storage::delete($filename);
        return redirect('/data-payment/lain?thn='.$thn.'&bln='.$bln)->with('berhasil', json_decode($response)->count. json_decode($response)->message);
    }

    public function uploaddetail(dataPembayaranLainnya $dataPembayaranLainnya)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[''];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if($dataPembayaranLainnya->sts != '0'){
            abort(403);
        }
        try {
            $response=dataLain::post([
                'bulan' => $dataPembayaranLainnya->bulan,
                'tahun' => $dataPembayaranLainnya->tahun,
                'kdsatker' => $dataPembayaranLainnya->kdsatker,
                'nip' => $dataPembayaranLainnya->nip,
                'bruto' => $dataPembayaranLainnya->bruto,
                'pph' => $dataPembayaranLainnya->pph,
                'netto' => $dataPembayaranLainnya->bruto-$dataPembayaranLainnya->pph,
                'jenis' => $dataPembayaranLainnya->jenis,
                'uraian' => $dataPembayaranLainnya->uraian,
                'tanggal' => $dataPembayaranLainnya->tanggal,
                'nospm' => '',
            ]);
            
            if ($response->getStatusCode() != 200) {
                throw new \Exception($response);
            }
            dataPembayaranLainnya::where('id', $dataPembayaranLainnya->id)->update([
                'sts'=>'1'
            ]);
        } catch (\Exception $e) {
            return redirect('/data-payment/lain/'.$dataPembayaranLainnya->kdsatker.'/'.$dataPembayaranLainnya->jenis.'/'.$dataPembayaranLainnya->tahun.'/'.$dataPembayaranLainnya->bulan.'/detail')
            ->with('gagal', $e->getMessage());
        }
        return redirect('/data-payment/lain/'.$dataPembayaranLainnya->kdsatker.'/'.$dataPembayaranLainnya->jenis.'/'.$dataPembayaranLainnya->tahun.'/'.$dataPembayaranLainnya->bulan.'/detail')
        ->with('berhasil', 'Data Berhasil di Upload');
    }
}
