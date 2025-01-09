<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\romanToDecimal;
use App\Models\AbsensiUangLembur;
use App\Models\NotifikasiBelanja51;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class PusatBelanja51AbsensiLemburController extends Controller
{
    public function index($thn = null, $bln = null)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat', 'admin_pusat'];
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
        $tahun = AbsensiUangLembur::tahunPusat(auth()->user()->kdsatker, auth()->user()->kdunit);
        $bulan = AbsensiUangLembur::bulanPusat(auth()->user()->kdsatker, auth()->user()->kdunit, $thn);
        $data = AbsensiUangLembur::rekapPusat(auth()->user()->kdsatker, auth()->user()->kdunit, $thn, $bln)->paginate(15);

        return view('belanja-51-pusat.uang_lembur.absensi.index', [
            'thn' => $thn,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'bln' => $bln,
            'data' => $data,
            'pageTitle' => 'Uang Lembur',
            'notifBelanja51Tolak' => NotifikasiBelanja51::NotifikasiPusat(auth()->user()->kdsatker, auth()->user()->kdunit),
        ]);
    }

    public function create()
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat', 'admin_pusat'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        return view('belanja-51-pusat.uang_lembur.absensi.create', [
            'pageTitle' => 'Uang Lembur',
            'notifBelanja51Tolak' => NotifikasiBelanja51::NotifikasiPusat(auth()->user()->kdsatker, auth()->user()->kdunit),
        ]);
    }

    public function store(Request $request)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat', 'admin_pusat'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        $request->validate([
            'file_excel' => 'required|mimetypes:application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet|file|max:10240'
        ]);
        $file = $request->file('file_excel');
        if ($file->extension() == 'xls') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } elseif ($file->extension() == 'xlsx') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        } else {
            return redirect()->back()->with('gagal', 'File Excel Tidak Valid');
        }
        $spreadsheet = $reader->load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $highestRow = $sheet->getHighestRow();
        $firstRow = null;
        $lastRow = null;
        for ($row = 3; $row <= $highestRow; $row++) {
            $value = $sheet->getCell('B' . $row)->getValue();
            if (!empty($value)) { // Memeriksa apakah ada nilai di sel
                if ($firstRow === null) {
                    $firstRow = $row; // Menyimpan baris pertama dengan data
                }
                $lastRow = $row; // Menyimpan baris terakhir dengan data
            }
        }
        if ($firstRow !== null && $lastRow !== null) {
            $data = $sheet->rangeToArray('B' . $firstRow . ':J' . $lastRow, null, true, true, true);
            foreach ($data as $value) {
                $row = collect([
                    'nama' => $value['C'],
                    'nip' => $value['D'],
                    'golongan' => romanToDecimal::convert(explode('.', $value['E'])[0]),
                    'tanggal' => $value['F'],
                    'absensiMasuk' => $value['G'],
                    'absensiKeluar' => $value['H'],
                    'jenishari' => $value['I'],
                    'jumlahjam' => $value['J'],
                ]);
                $validator = Validator::make($row->toArray(), [
                    'nip' => 'required',
                    'nama' => 'required',
                    'golongan' => 'required',
                    'tanggal' => 'required',
                    'absensiMasuk' => 'required',
                    'absensiKeluar' => 'required',
                    'jenishari' => 'required',
                    'jumlahjam' => 'required',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->with('gagal', 'File Excel Tidak Valid Pada Data Nomor ' . $value['B']);
                }
                AbsensiUangLembur::updateOrCreate([
                    'nip' => $row['nip'],
                    'tanggal' => $row['tanggal'],
                    'kdsatker' => auth()->user()->kdsatker,
                    'kdunit' => auth()->user()->kdunit,
                ], [
                    'kdsatker' => auth()->user()->kdsatker,
                    'kdunit' => auth()->user()->kdunit,
                    'golongan' => $row['golongan'],
                    'nip' => $row['nip'],
                    'nama' => $row['nama'],
                    'tanggal' => $row['tanggal'],
                    'absensimasuk' => $row['absensiMasuk'],
                    'absensikeluar' => $row['absensiKeluar'],
                    'jenishari' => $row['jenishari'],
                    'jumlahjam' => $row['jumlahjam'],
                ]);
            }
            return redirect('/belanja-51-pusat/uang-lembur/absensi')->with('berhasil', 'Data Berhasil');
        } else {
            return redirect()->back()->with('gagal', 'File Excel Tidak Valid');
        }
    }

    public function detail($thn, $bln, $nip)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat', 'admin_pusat'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        $data = AbsensiUangLembur::DetailPusat(auth()->user()->kdsatker, auth()->user()->kdunit, $thn, $bln, $nip);
        return view('belanja-51-pusat.uang_lembur.absensi.detail', [
            'data' => $data,
            'thn' => $thn,
            'bln' => $bln,
            'pageTitle' => 'Uang Lembur',
            'notifBelanja51Tolak' => NotifikasiBelanja51::NotifikasiPusat(auth()->user()->kdsatker, auth()->user()->kdunit),
        ]);
    }

    public function edit($id)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat', 'admin_pusat'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        $data = AbsensiUangLembur::find($id);
        if ($data->kdsatker != auth()->user()->kdsatker || $data->kdunit != auth()->user()->kdunit) {
            abort(403);
        }
        $tanggal = date($data->tanggal);
        $tahun = substr($tanggal, 0, 4);
        $bulan = substr($tanggal, 5, 2);

        return view('belanja-51-pusat.uang_lembur.absensi.edit', [
            'data' => $data,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'pageTitle' => 'Uang Lembur',
            'notifBelanja51Tolak' => NotifikasiBelanja51::NotifikasiPusat(auth()->user()->kdsatker, auth()->user()->kdunit),
        ]);
    }

    public function update(Request $request, AbsensiUangLembur $AbsensiUangLembur)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat', 'admin_pusat'];
        } else {
            $gate = [];
        }
        if (!Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        if ($AbsensiUangLembur->kdsatker != auth()->user()->kdsatker || $AbsensiUangLembur->kdunit != auth()->user()->kdunit) {
            abort(403);
        }

        $request->validate([
            'absensimasuk' => ['required', 'regex:/^(?:[01]\d|2[0-3]):[0-5]\d$/'],
            'absensikeluar' => ['required', 'regex:/^(?:[01]\d|2[0-3]):[0-5]\d$/'],
            'golongan' => ['required', 'numeric', 'digits:1'],
            'jumlahjam' => ['required', 'numeric'],
            'jenishari' => ['required', 'in:kerja,libur'],
        ], [
            'absensimasuk.required' => 'Waktu Absensi Masuk Tidak Boleh Kosong',
            'absensikeluar.required' => 'Waktu Absensi Keluar Tidak Boleh Kosong',
            'golongan.required' => 'Golongan Tidak Boleh Kosong',
            'golongan.numeric' => 'Golongan Harus Berupa Angka',
            'golongan.digits' => 'Golongan Tidak Valid',
            'jenishari.required' => 'Jenis Hari Tidak Boleh Kosong',
            'jenishari.in' => 'Jenis Hari Harus Berupa Kerja/Libur',
            'jumlahjam.required' => 'Jumlah Jam Tidak Boleh Kosong',
            'jumlahjam.numeric' => 'Jumlah Jam Harus Berupa Angka',
            'absensimasuk.regex' => 'Format Waktu Absensi Masuk Tidak Valid (HH:MM)',
            'absensikeluar.regex' => 'Format Waktu Absensi Keluar Tidak Valid (HH:MM)',
        ]);

        $AbsensiUangLembur->update([
            'absensimasuk' => $request->absensimasuk,
            'absensikeluar' => $request->absensikeluar,
            'golongan' => $request->golongan,
            'jenishari' => $request->jenishari,
            'jumlahjam' => $request->jumlahjam,
        ]);
        $tanggal = date($AbsensiUangLembur->tanggal);
        $tahun = substr($tanggal, 0, 4);
        $bulan = substr($tanggal, 5, 2);
        return redirect('/belanja-51-pusat/uang-lembur/absensi/' . $tahun . '/' . $bulan . '/' . $AbsensiUangLembur->nip)->with('berhasil', 'Data Berhasil Di Ubah');
    }

    public function destroy(AbsensiUangLembur $AbsensiUangLembur)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat', 'admin_pusat'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        if ($AbsensiUangLembur->kdsatker != auth()->user()->kdsatker || $AbsensiUangLembur->kdunit != auth()->user()->kdunit) {
            abort(403);
        }

        $tanggal = date($AbsensiUangLembur->tanggal);
        $tahun = substr($tanggal, 0, 4);
        $bulan = substr($tanggal, 5, 2);
        $AbsensiUangLembur->delete();

        return redirect('/belanja-51-pusat/uang-lembur/absensi/' . $tahun . '/' . $bulan . '/' . $AbsensiUangLembur->nip)->with('berhasil', 'Data Berhasil Di Hapus');
    }

    public function template()
    {
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
            ->setCellValue('B1', 'No')
            ->setCellValue('C1', 'NAMA')
            ->setCellValue('D1', 'NIP')
            ->setCellValue('E1', 'Golongan')
            ->setCellValue('F1', 'Tanggal')
            ->setCellValue('G1', 'Absensi Masuk')
            ->setCellValue('H1', 'Absensi Keluar')
            ->setCellValue('I1', 'Jenis Hari')
            ->setCellValue('J1', 'Jumlah Jam')
        ;
        for ($row = 1; $row <= 10002; $row++) {
            for ($col = 'B'; $col <= 'J'; $col++) {
                $cell = $col . $row;
                $spreadsheet->getActiveSheet()->getStyle($cell)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
            }
        }
        $spreadsheet->getActiveSheet()
            ->getStyle('B1:J1')->applyFromArray($textcenter);
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('B2', '1.')
            ->setCellValue('C2', 'XXXX XXXXX')
            ->setCellValue('D2', "'197001012000011001")
            ->setCellValue('E2', 'IA')
            ->setCellValue('F2', '1970-01-01')
            ->setCellValue('G2', '07:30')
            ->setCellValue('H2', '17:00')
            ->setCellValue('I2', 'kerja/libur')
            ->setCellValue('J2', '4')
            ->setCellValue('K2', 'data contoh jangan di hapus');
        $spreadsheet->getActiveSheet()
            ->getStyle('B2:J2')->applyFromArray([
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'FFCCFFCC',
                    ],
                ],
            ]);

        // Validasi untuk kolom E (Golongan)
        for ($row = 3; $row <= 10002; $row++) {
            $cell = 'E' . $row;
            $golongan = $spreadsheet->getActiveSheet()->getCell($cell)->getDataValidation();
            $golongan->setType(DataValidation::TYPE_LIST);
            $golongan->setAllowBlank(true);
            $golongan->setShowInputMessage(true);
            $golongan->setShowErrorMessage(true);
            $golongan->setShowDropDown(true);
            $golongan->setErrorTitle('Input salah');
            $golongan->setError('Nilai yang dimasukkan tidak valid.');
            $golongan->setPromptTitle('Pilih dari daftar');
            $golongan->setPrompt('Silakan pilih salah satu dari daftar.');
            $golongan->setFormula1('"I.A,I.B,I.C,I.D,II.A,II.B,II.C,II.D,III.A,III.B,III.C,III.D,IV.A,IV.B,IV.C,IV.D,IV.E"');
        }

        // Validasi untuk kolom I (Jenis Hari)
        for ($row = 3; $row <= 10002; $row++) {
            $cell = 'I' . $row;
            $jenisHari = $spreadsheet->getActiveSheet()->getCell($cell)->getDataValidation();
            $jenisHari->setType(DataValidation::TYPE_LIST);
            $jenisHari->setAllowBlank(true);
            $jenisHari->setShowInputMessage(true);
            $jenisHari->setShowErrorMessage(true);
            $jenisHari->setShowDropDown(true);
            $jenisHari->setErrorTitle('Input salah');
            $jenisHari->setError('Nilai yang dimasukkan tidak valid.');
            $jenisHari->setPromptTitle('Pilih dari daftar');
            $jenisHari->setPrompt('Silakan pilih salah satu dari daftar.');
            $jenisHari->setFormula1('"kerja,libur"');
        }

        for ($row = 3; $row <= 10002; $row++) {
            $cell = 'F' . $row; // Misalnya kolom F untuk tanggal
            $tanggal = $spreadsheet->getActiveSheet()->getCell($cell)->getDataValidation();
            $tanggal->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_CUSTOM);
            $tanggal->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
            $tanggal->setAllowBlank(false);
            $tanggal->setShowInputMessage(true);
            $tanggal->setShowErrorMessage(true);
            $tanggal->setErrorTitle('Input salah');
            $tanggal->setError('Tanggal harus dalam format YYYY-MM-DD.');
            $tanggal->setPromptTitle('Format Tanggal');
            $tanggal->setPrompt('Masukkan tanggal dengan format YYYY-MM-DD.');

            // Formula untuk validasi
            $tanggal->setFormula1('=AND(LEN(F' . $row . ')=10, ISNUMBER(DATEVALUE(F' . $row . ')))');
        }

        for ($row = 3; $row <= 10002; $row++) {
            $cell = 'G' . $row;
            $absensimasuk = $spreadsheet->getActiveSheet()->getCell($cell)->getDataValidation();
            $absensimasuk->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_CUSTOM);
            $absensimasuk->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
            $absensimasuk->setAllowBlank(false);
            $absensimasuk->setShowInputMessage(true);
            $absensimasuk->setShowErrorMessage(true);
            $absensimasuk->setErrorTitle('Input salah');
            $absensimasuk->setError('Jam harus dalam format HH:MM.');
            $absensimasuk->setPromptTitle('Format Jam');
            $absensimasuk->setPrompt('Masukkan jam dengan format HH:MM.');

            // Formula untuk validasi
            $absensimasuk->setFormula1('=AND(LEN(G' . $row . ')=5, ISNUMBER(TIMEVALUE(G' . $row . ')), MID(G' . $row . ',3,1)=":")');
        }

        for ($row = 3; $row <= 10002; $row++) {
            $cell = 'H' . $row;
            $absensikeluar = $spreadsheet->getActiveSheet()->getCell($cell)->getDataValidation();
            $absensikeluar->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_CUSTOM);
            $absensikeluar->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
            $absensikeluar->setAllowBlank(false);
            $absensikeluar->setShowInputMessage(true);
            $absensikeluar->setShowErrorMessage(true);
            $absensikeluar->setErrorTitle('Input salah');
            $absensikeluar->setError('Jam harus dalam format HH:MM.');
            $absensikeluar->setPromptTitle('Format Jam');
            $absensikeluar->setPrompt('Masukkan jam dengan format HH:MM.');

            // Formula untuk validasi
            $absensikeluar->setFormula1('=AND(LEN(H' . $row . ')=5, ISNUMBER(TIMEVALUE(H' . $row . ')), MID(H' . $row . ',3,1)=":")');
        }
        for ($row = 3; $row <= 10002; $row++) {
            $cell = 'D' . $row; // Misalnya kolom F untuk tanggal
            $nip = $spreadsheet->getActiveSheet()->getCell($cell)->getDataValidation();
            $nip->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_CUSTOM);
            $nip->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
            $nip->setAllowBlank(false);
            $nip->setShowInputMessage(true);
            $nip->setShowErrorMessage(true);
            $nip->setErrorTitle('Input salah');
            $nip->setError('NIP harus 18 digit.');
            $nip->setPromptTitle('Format NIP');
            $nip->setPrompt('Masukkan NIP dengan format 18 digit tanpa spasi.');

            // Formula untuk validasi
            $nip->setFormula1('=AND(LEN(D' . $row . ')=18)');
        }

        foreach ($spreadsheet->getActiveSheet()->getColumnIterator() as $column) {
            $spreadsheet->getActiveSheet()->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $spreadsheet->getActiveSheet()->getStyle('B2:J10002')->applyFromArray($styleBorder);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Template Upload Absensi Lembur.xlsx"');
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
}
