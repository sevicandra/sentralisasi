<?php

namespace App\Http\Controllers;

use App\Models\satker;
use Illuminate\Http\Request;
use App\Models\NotifikasiBelanja51;
use App\Models\PermohonanBelanja51;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class MonitoringBelanja51VertikalController extends Controller
{
    public function uangMakan()
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $data = PermohonanBelanja51::permohonanMakan()->with(['satker'])->orderBy('updated_at', 'asc')->paginate(15)->withQueryString();
        return view('belanja-51-monitoring.vertikal.uang_makan.index', [
            'pageTitle' => 'Monitoring Belanja 51 Vertikal - Uang Makan',
            'data' => $data,
            'permohonanMakanPusat' =>PermohonanBelanja51::permohonanMakanPusat()->count(),
            'permohonanMakanVertikal' =>PermohonanBelanja51::permohonanMakan()->count(),
            'permohonanLemburPusat' =>PermohonanBelanja51::permohonanLemburPusat()->count(),
            'permohonanLemburVertikal' =>PermohonanBelanja51::permohonanLembur()->count()
        ]);
    }
    public function uangMakanDetail(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        return view('belanja-51-monitoring.vertikal.uang_makan.detail', [
            'pageTitle' => 'Monitoring Belanja 51 Vertikal - Uang Makan',
            'permohonan' => PermohonanBelanja51::with(['lampiran'])->find($id->id),
            'permohonanMakanPusat' =>PermohonanBelanja51::permohonanMakanPusat()->count(),
            'permohonanMakanVertikal' =>PermohonanBelanja51::permohonanMakan()->count(),
            'permohonanLemburPusat' =>PermohonanBelanja51::permohonanLemburPusat()->count(),
            'permohonanLemburVertikal' =>PermohonanBelanja51::permohonanLembur()->count()
        ]);
    }
    public function uangMakanApprove(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->status != 'kirim') {
            return abort(403);
        }
        $id->update([
            'status' => 'approved',
        ]);
        $id->history()->create([
            'action' => 'approve',
            'nama' => auth()->user()->nama,
            'nip' => auth()->user()->nip,
        ]);
        return redirect('/belanja-51-monitoring/vertikal/uang-makan')->with('berhasil', 'Permohonan Berhasil Disetujui');
    }
    public function uangMakanTolak(Request $request, PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->status != 'kirim') {
            return abort(403);
        }
        $validator = Validator::make($request->all(), [
            'catatan' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('gagal', 'Catatan wajib diisi');
        }
        $id->update([
            'status' => 'rejected',
        ]);
        $id->history()->create([
            'catatan' => $request->catatan,
            'action' => 'reject',
            'nama' => auth()->user()->nama,
            'nip' => auth()->user()->nip,
        ]);
        NotifikasiBelanja51::create([
            'kdsatker' => $id->kdsatker,
            'kdunit' => $id->kdunit,
            'nomor' => $id->nomor,
            'catatan' => $request->catatan,
            'status' => 'unread',
        ]);
        return redirect('/belanja-51-monitoring/vertikal/uang-makan')->with('berhasil', 'Permohonan Berhasil Ditolak');
    }
    public function uangMakanRekap(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        $satker = $id->satker;
        $data = $id->dataMakan()
            ->orderBy('golongan', 'desc')
            ->orderBy('nip', 'asc')
            ->orderBy('tanggal', 'asc')
            ->get();

        $spreadsheet = new Spreadsheet();
        $styleBorder = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'inside' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $textcenter = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'NAMA')
            ->setCellValue('C1', 'NIP')
            ->setCellValue('D1', 'Golongan')
            ->setCellValue('E1', 'Tanggal')
            ->setCellValue('F1', 'Absensi Masuk')
            ->setCellValue('G1', 'Absensi Keluar')
        ;

        $spreadsheet->getActiveSheet()
            ->getStyle('A1:G1')->applyFromArray($textcenter);
        $i = 1;
        foreach ($data as $item) {
            $spreadsheet->getActiveSheet()->getStyle("C" . ($i + 1))->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . ($i + 1), $i)
                ->setCellValue('B' . ($i + 1), $item->nama)
                ->setCellValue('D' . ($i + 1), $item->golongan)
                ->setCellValue('E' . ($i + 1), $item->tanggal)
                ->setCellValue('F' . ($i + 1), $item->absensimasuk)
                ->setCellValue('G' . ($i + 1), $item->absensikeluar)
            ;
            $spreadsheet
                ->getActiveSheet(0)
                ->getCell('C' . ($i + 1))
                ->setValueExplicit($item->nip, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $spreadsheet->getActiveSheet()
                ->getStyle('A' . ($i + 1) . ':A' . ($i + 1))->applyFromArray($textcenter);
            $spreadsheet->getActiveSheet()
                ->getStyle('D' . ($i + 1) . ':G' . ($i + 1))->applyFromArray($textcenter);
            $i++;
        };
        foreach ($spreadsheet->getActiveSheet()->getColumnIterator() as $column) {
            $spreadsheet->getActiveSheet()->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }
        $spreadsheet->getActiveSheet()->getStyle('A1:G' . $i)->applyFromArray($styleBorder);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Rekap Uang Makan ' . $satker->nmsatker . '.xlsx"');
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
    public function uangMakanMonitoring($thn = null, $bln = null)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if (!$thn) {
            $thn = date('Y');
        }
        if (!$bln) {
            $bln = date('m');
        }
        $tahun = PermohonanBelanja51::tahunMakanVertikal();
        $bulan = PermohonanBelanja51::bulanMakanVertikal($thn);
        $satker = satker::with(['permohonanUangMakanVertikal' => function ($q) use ($thn, $bln) {
            $q->where('tahun', $thn)->where('bulan', $bln);
        }])->orderBy('order')->where('kdsatker', '!=', '411792')->selectRaw('kdsatker, nmsatker')->get();
        return view('belanja-51-monitoring.vertikal.uang_makan.monitoring.index', [
            'tahun' => $tahun,
            'bulan' => $bulan,
            'data' => $satker,
            'thn' => $thn,
            'bln' => $bln,
            'pageTitle' => 'Monitoring Belanja 51 Vertikal - Uang Makan',
            'permohonanMakanPusat' =>PermohonanBelanja51::permohonanMakanPusat()->count(),
            'permohonanMakanVertikal' =>PermohonanBelanja51::permohonanMakan()->count(),
            'permohonanLemburPusat' =>PermohonanBelanja51::permohonanLemburPusat()->count(),
            'permohonanLemburVertikal' =>PermohonanBelanja51::permohonanLembur()->count()
        ]);
    }
    public function uangMakanMonitoringRekap($thn, $bln, $kdsatker)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $data = PermohonanBelanja51::where('jenis', 'makan')->where('tahun', $thn)->where('bulan', $bln)->where('kdsatker', $kdsatker)->get();
        return view('belanja-51-monitoring.vertikal.uang_makan.monitoring.rekap', [
            'data' => $data,
            'thn' => $thn,
            'bln' => $bln,
            'pageTitle' => 'Monitoring Belanja 51 Vertikal - Uang Makan',
            'permohonanMakanPusat' =>PermohonanBelanja51::permohonanMakanPusat()->count(),
            'permohonanMakanVertikal' =>PermohonanBelanja51::permohonanMakan()->count(),
            'permohonanLemburPusat' =>PermohonanBelanja51::permohonanLemburPusat()->count(),
            'permohonanLemburVertikal' =>PermohonanBelanja51::permohonanLembur()->count()
        ]);
    }
    public function uangMakanMonitoringDetail(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        return view('belanja-51-monitoring.vertikal.uang_makan.monitoring.detail', [
            'pageTitle' => 'Monitoring Belanja 51 Vertikal - Uang Makan',
            'permohonan' => PermohonanBelanja51::with(['lampiran'])->find($id->id),
            'permohonanMakanPusat' =>PermohonanBelanja51::permohonanMakanPusat()->count(),
            'permohonanMakanVertikal' =>PermohonanBelanja51::permohonanMakan()->count(),
            'permohonanLemburPusat' =>PermohonanBelanja51::permohonanLemburPusat()->count(),
            'permohonanLemburVertikal' =>PermohonanBelanja51::permohonanLembur()->count()
        ]);
    }

    public function uangLembur()
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $data = PermohonanBelanja51::permohonanLembur()->with(['satker'])->orderBy('updated_at', 'asc')->paginate(15)->withQueryString();
        return view('belanja-51-monitoring.vertikal.uang_lembur.index', [
            'pageTitle' => 'Monitoring Belanja 51 Vertikal - Uang Lembur',
            'data' => $data,
            'permohonanMakanPusat' =>PermohonanBelanja51::permohonanMakanPusat()->count(),
            'permohonanMakanVertikal' =>PermohonanBelanja51::permohonanMakan()->count(),
            'permohonanLemburPusat' =>PermohonanBelanja51::permohonanLemburPusat()->count(),
            'permohonanLemburVertikal' =>PermohonanBelanja51::permohonanLembur()->count()
        ]);
    }
    public function uangLemburDetail(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        return view('belanja-51-monitoring.vertikal.uang_lembur.detail', [
            'pageTitle' => 'Monitoring Belanja 51 Vertikal - Uang Lembur',
            'permohonan' => PermohonanBelanja51::with(['lampiran'])->find($id->id),
            'permohonanMakanPusat' =>PermohonanBelanja51::permohonanMakanPusat()->count(),
            'permohonanMakanVertikal' =>PermohonanBelanja51::permohonanMakan()->count(),
            'permohonanLemburPusat' =>PermohonanBelanja51::permohonanLemburPusat()->count(),
            'permohonanLemburVertikal' =>PermohonanBelanja51::permohonanLembur()->count()
        ]);
    }
    public function uangLemburApprove(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->status != 'kirim') {
            return abort(403);
        }
        $id->update([
            'status' => 'approved',
        ]);
        $id->history()->create([
            'action' => 'approve',
            'nama' => auth()->user()->nama,
            'nip' => auth()->user()->nip,
        ]);
        return redirect('/belanja-51-monitoring/vertikal/uang-lembur')->with('berhasil', 'Permohonan Berhasil Disetujui');
    }
    public function uangLemburTolak(Request $request, PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if ($id->status != 'kirim') {
            return abort(403);
        }
        $validator = Validator::make($request->all(), [
            'catatan' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('gagal', 'Catatan wajib diisi');
        }
        $id->update([
            'status' => 'rejected',
        ]);
        $id->history()->create([
            'catatan' => $request->catatan,
            'action' => 'reject',
            'nama' => auth()->user()->nama,
            'nip' => auth()->user()->nip,
        ]);
        NotifikasiBelanja51::create([
            'kdsatker' => $id->kdsatker,
            'kdunit' => $id->kdunit,
            'nomor' => $id->nomor,
            'catatan' => $request->catatan,
            'status' => 'unread',
        ]);
        return redirect('/belanja-51-monitoring/vertikal/uang-lembur')->with('berhasil', 'Permohonan Berhasil Ditolak');
    }
    public function uangLemburRekap(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        $satker = $id->satker;
        $data = $id->dataLembur()
            ->orderBy('golongan', 'desc')
            ->orderBy('nip', 'asc')
            ->orderBy('tanggal', 'asc')
            ->get();

        $spreadsheet = new Spreadsheet();
        $styleBorder = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'inside' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $textcenter = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'NAMA')
            ->setCellValue('C1', 'NIP')
            ->setCellValue('D1', 'Golongan')
            ->setCellValue('E1', 'Tanggal')
            ->setCellValue('F1', 'Jenis Hari')
            ->setCellValue('G1', 'Absensi Masuk')
            ->setCellValue('H1', 'Absensi Keluar')
            ->setCellValue('I1', 'Jumlah Jam')
        ;

        $spreadsheet->getActiveSheet()
            ->getStyle('A1:I1')->applyFromArray($textcenter);
        $i = 1;
        foreach ($data as $item) {
            $spreadsheet->getActiveSheet()->getStyle("C" . ($i + 1))->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . ($i + 1), $i)
                ->setCellValue('B' . ($i + 1), $item->nama)
                ->setCellValue('D' . ($i + 1), $item->golongan)
                ->setCellValue('E' . ($i + 1), $item->tanggal)
                ->setCellValue('F' . ($i + 1), $item->jenishari)
                ->setCellValue('G' . ($i + 1), $item->absensimasuk)
                ->setCellValue('H' . ($i + 1), $item->absensikeluar)
                ->setCellValue('I' . ($i + 1), $item->jumlahjam)
            ;
            $spreadsheet
                ->getActiveSheet(0)
                ->getCell('C' . ($i + 1))
                ->setValueExplicit($item->nip, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $spreadsheet->getActiveSheet()
                ->getStyle('A' . ($i + 1) . ':A' . ($i + 1))->applyFromArray($textcenter);
            $spreadsheet->getActiveSheet()
                ->getStyle('D' . ($i + 1) . ':I' . ($i + 1))->applyFromArray($textcenter);
            $i++;
        };
        foreach ($spreadsheet->getActiveSheet()->getColumnIterator() as $column) {
            $spreadsheet->getActiveSheet()->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }
        $spreadsheet->getActiveSheet()->getStyle('A1:I' . $i)->applyFromArray($styleBorder);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Rekap Uang Makan ' . $satker->nmsatker . '.xlsx"');
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
    public function uangLemburMonitoring($thn = null, $bln = null)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        if (!$thn) {
            $thn = date('Y');
        }
        if (!$bln) {
            $bln = date('m');
        }
        $tahun = PermohonanBelanja51::tahunLemburVertikal();
        $bulan = PermohonanBelanja51::bulanLemburVertikal($thn);
        $satker = satker::with(['permohonanUangLemburVertikal' => function ($q) use ($thn, $bln) {
            $q->where('tahun', $thn)->where('bulan', $bln);
        }])->orderBy('order')->where('kdsatker', '!=', '411792')->selectRaw('kdsatker, nmsatker')->get();
        return view('belanja-51-monitoring.vertikal.uang_lembur.monitoring.index', [
            'tahun' => $tahun,
            'bulan' => $bulan,
            'data' => $satker,
            'thn' => $thn,
            'bln' => $bln,
            'pageTitle' => 'Monitoring Belanja 51 Vertikal - Uang Lembur',
            'permohonanMakanPusat' =>PermohonanBelanja51::permohonanMakanPusat()->count(),
            'permohonanMakanVertikal' =>PermohonanBelanja51::permohonanMakan()->count(),
            'permohonanLemburPusat' =>PermohonanBelanja51::permohonanLemburPusat()->count(),
            'permohonanLemburVertikal' =>PermohonanBelanja51::permohonanLembur()->count()
        ]);
    }
    public function uangLemburMonitoringRekap($thn, $bln, $kdsatker)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $data = PermohonanBelanja51::where('jenis', 'lembur')->where('tahun', $thn)->where('bulan', $bln)->where('kdsatker', $kdsatker)->get();
        return view('belanja-51-monitoring.vertikal.uang_lembur.monitoring.rekap', [
            'data' => $data,
            'thn' => $thn,
            'bln' => $bln,
            'pageTitle' => 'Monitoring Belanja 51 Vertikal - Uang Lembur',
            'permohonanMakanPusat' =>PermohonanBelanja51::permohonanMakanPusat()->count(),
            'permohonanMakanVertikal' =>PermohonanBelanja51::permohonanMakan()->count(),
            'permohonanLemburPusat' =>PermohonanBelanja51::permohonanLemburPusat()->count(),
            'permohonanLemburVertikal' =>PermohonanBelanja51::permohonanLembur()->count()
        ]);
    }
    public function uangLemburMonitoringDetail(PermohonanBelanja51 $id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['sys_admin'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        return view('belanja-51-monitoring.vertikal.uang_lembur.monitoring.detail', [
            'permohonan' => PermohonanBelanja51::with(['lampiran'])->find($id->id),
            'pageTitle' => 'Monitoring Belanja 51 Vertikal - Uang Lembur',
            'permohonanMakanPusat' =>PermohonanBelanja51::permohonanMakanPusat()->count(),
            'permohonanMakanVertikal' =>PermohonanBelanja51::permohonanMakan()->count(),
            'permohonanLemburPusat' =>PermohonanBelanja51::permohonanLemburPusat()->count(),
            'permohonanLemburVertikal' =>PermohonanBelanja51::permohonanLembur()->count()
        ]);
    }
}
