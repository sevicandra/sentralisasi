<?php

namespace App\Http\Controllers;

use App\Models\satker;
use Illuminate\Http\Request;
use App\Models\dokumenUangMakan;
use App\Models\dokumenUangLembur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PembayaranDokumenUangMakanController extends Controller
{
    public function index($thn=null, $bln=null)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $tahun = dokumenUangMakan::MonitoringPusatTahun();
        if (!$thn) {
            $thn=$tahun->first()->tahun;
        }

        $bulan = dokumenUangMakan::MonitoringPusatBulan($thn);
        if (!$bln) {
            $bln=$bulan->last()->bulan;
        }
        
        return view('pembayaran.dokumen_uang_makan.index',[
            'data'=>satker::order()->get(),
            'thn'=>$thn,
            'bln'=>$bln,
            'tahun'=>$tahun,
            'bulan'=>$bulan,
            "pageTitle"=>"Dokumen Uang Makan",
            'uangLemburKirim'=>dokumenUangLembur::send(),
            'uangMakanKirim'=>dokumenUangMakan::send(),
            'uangLemburDraft'=>dokumenUangLembur::draft(),
            'uangMakanDraft'=>dokumenUangMakan::draft(),
        ]);
    }

    public function rekap(Request $request)
    {
        $data=satker::order()->get();
        $spreadsheet = new Spreadsheet();
        $spreadsheet    ->setActiveSheetIndex(0)
                        ->setCellValue('A1', 'No')
                        ->setCellValue('B1', 'Kode Satker')
                        ->setCellValue('C1', 'Nama Satker')
                        ->setCellValue('D1', 'Berkas')
                        ->setCellValue('E1', 'Status');
        $i=2;
        foreach ($data as $item) {
            if ($item->dokumenUangMakan($request->thn, $request->bln)->count() != 0) {
                if ($item->dokumenUangMakan($request->thn, $request->bln)->min('terkirim') === 1){
                    $status = 'terkirim';
                }elseif($item->dokumenUangMakan($request->thn, $request->bln)->min('terkirim') === 0){
                    $status = 'draft';
                }else{
                    $status = 'Approve';
                }
            }else{
                $status = '';
            }

            $spreadsheet    ->setActiveSheetIndex(0)
                            ->setCellValue('A'.$i, '')
                            ->setCellValue('B'.$i, $item->kdsatker)
                            ->setCellValue('C'.$i, $item->nmsatker)
                            ->setCellValue('D'.$i, $item->dokumenUangMakan($request->thn, $request->bln)->count())
                            ->setCellValue('E'.$i, $status);
            $i++;
        }
        
            // Redirect output to a client’s web browser (Xlsx)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Rekap Dokumen Uang Makan Bulan '.$request->bln.' Tahun '.$request->thn.'-'.date('D, d M Y H:i:s').'.xlsx"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit;
    }

    public function detail($kdsatker, $thn, $bln)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $data = dokumenUangMakan::uangMakan($kdsatker, $thn, $bln)->get();
        return view('pembayaran.dokumen_uang_makan.detail',[
            'data'=>$data,
            'thn'=>$thn,
            'bln'=>$bln,
            'uangLemburKirim'=>dokumenUangLembur::send(),
            'uangMakanKirim'=>dokumenUangMakan::send(),
            'uangLemburDraft'=>dokumenUangLembur::draft(),
            'uangMakanDraft'=>dokumenUangMakan::draft(),
        ]);
    }

    public function reject(dokumenUangMakan $dokumenUangMakan)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if (!$dokumenUangMakan->terkirim) {
            return abort(403);
        }
        $dokumenUangMakan->update(['terkirim'=>0]);
        return Redirect()->back()->with('berhasil', 'Data berhasil dikembalikan.');
    }

    public function dokumen(dokumenUangMakan $dokumenUangMakan)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        
        return response()->file(Storage::path($dokumenUangMakan->file),[
            'Content-Type' => 'application/pdf',
        ]);

    }

    public function dokumen_excel(dokumenUangMakan $dokumenUangMakan)
    {

        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        
        $name = $dokumenUangMakan->kdsatker. "-" .$dokumenUangMakan->nmbulan .".". explode('.', $dokumenUangMakan->file_excel)[1];
        return Storage::download($dokumenUangMakan->file_excel, $name);
    }

    public function approve(dokumenUangMakan $dokumenUangMakan)
    {
        if (Auth::guard('web')->check()) {
            $gate=['sys_admin'];
        }else{
            $gate=[];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if (!$dokumenUangMakan->terkirim) {
            return abort(403);
        }

        $dokumenUangMakan->update(['terkirim'=>2]);
        return Redirect()->back()->with('berhasil', 'Data berhasil di simpan.');
    }
}
