<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helper\romanToDecimal;
use App\Models\AbsensiUangMakan;
use App\Models\NotifikasiBelanja51;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class PusatBelanja51AbsensiMakanController extends Controller
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
        $tahun = AbsensiUangMakan::tahunPusat(auth()->user()->kdsatker, auth()->user()->kdunit);
        $bulan = AbsensiUangMakan::bulanPusat(auth()->user()->kdsatker, auth()->user()->kdunit, $thn);
        $data = AbsensiUangMakan::rekapPusat(auth()->user()->kdsatker, auth()->user()->kdunit, $thn, $bln)->paginate(15);
        return view('belanja-51-pusat.uang_makan.absensi.index', [
            'thn' => $thn,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'bln' => $bln,
            'data' => $data,
            'pageTitle' => 'Uang Makan',
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

        return view('belanja-51-pusat.uang_makan.absensi.create', [
            'pageTitle' => 'Uang Makan',
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
        for ($row = 9; $row <= $highestRow; $row++) {
            $value = $sheet->getCell('A' . $row)->getValue();
            if (!empty($value)) { // Memeriksa apakah ada nilai di sel
                if ($firstRow === null) {
                    $firstRow = $row; // Menyimpan baris pertama dengan data
                }
                $lastRow = $row; // Menyimpan baris terakhir dengan data
            }
        }
        if ($firstRow !== null && $lastRow !== null) {
            $data = $sheet->rangeToArray('A' . $firstRow . ':F' . $lastRow, null, true, true, true);
            foreach ($data as $value) {
                $row = collect([
                    'nip' => substr($value['B'], -18),
                    'nama' => substr($value['B'], 0, -19),
                    'golongan' => romanToDecimal::convert(explode('.', $value['C'])[0]),
                    'tanggal' => Carbon::createFromFormat('d-M-y', $value['D'])->format('Y-m-d'),
                    'absensiMasuk' => $value['E'],
                    'absensiKeluar' => $value['F'],
                ]);
                $validator = Validator::make($row->toArray(), [
                    'nip' => 'required',
                    'nama' => 'required',
                    'golongan' => 'required',
                    'tanggal' => 'required',
                    'absensiMasuk' => 'required',
                    'absensiKeluar' => 'required',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->with('gagal', 'File Excel Tidak Valid Pada Data Nomor ' . $value['A']);
                }
                AbsensiUangMakan::updateOrCreate([
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
                ]);
            }
            return redirect('/belanja-51-pusat/uang-makan/absensi')->with('berhasil', 'Data Berhasil');
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
        $data = AbsensiUangMakan::DetailPusat(auth()->user()->kdsatker, auth()->user()->kdunit, $thn, $bln, $nip);
        return view('belanja-51-pusat.uang_makan.absensi.detail', [
            'data' => $data,
            'thn' => $thn,
            'bln' => $bln,
            'pageTitle' => 'Uang Makan',
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
        $data = AbsensiUangMakan::find($id);
        if ($data->kdsatker != auth()->user()->kdsatker || $data->kdunit != auth()->user()->kdunit) {
            abort(403);
        }
        $tanggal = date($data->tanggal);
        $tahun = substr($tanggal, 0, 4);
        $bulan = substr($tanggal, 5, 2);

        return view('belanja-51-pusat.uang_makan.absensi.edit', [
            'data' => $data,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'pageTitle' => 'Uang Makan',
            'notifBelanja51Tolak' => NotifikasiBelanja51::NotifikasiPusat(auth()->user()->kdsatker, auth()->user()->kdunit),
        ]);
    }

    public function update(Request $request, AbsensiUangMakan $AbsensiUangMakan)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat', 'admin_pusat'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        if ($AbsensiUangMakan->kdsatker != auth()->user()->kdsatker || $AbsensiUangMakan->kdunit != auth()->user()->kdunit) {
            abort(403);
        }

        $request->validate([
            'absensimasuk' => 'required',
            'absensikeluar' => 'required',
            'golongan' => 'required',
        ]);

        $AbsensiUangMakan->update([
            'absensimasuk' => $request->absensimasuk,
            'absensikeluar' => $request->absensikeluar,
            'golongan' => $request->golongan,
        ]);
        $tanggal = date($AbsensiUangMakan->tanggal);
        $tahun = substr($tanggal, 0, 4);
        $bulan = substr($tanggal, 5, 2);
        return redirect('/belanja-51-pusat/uang-makan/absensi/' . $tahun . '/' . $bulan . '/' . $AbsensiUangMakan->nip)->with('berhasil', 'Data Berhasil Di Ubah');
    }

    public function destroy(AbsensiUangMakan $AbsensiUangMakan)
    {
        if (Auth::guard('web')->check()) {
            $gate = ['opr_belanja_51_pusat', 'admin_pusat'];
        } else {
            $gate = [];
        }
        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        if ($AbsensiUangMakan->kdsatker != auth()->user()->kdsatker || $AbsensiUangMakan->kdunit != auth()->user()->kdunit) {
            abort(403);
        }

        $tanggal = date($AbsensiUangMakan->tanggal);
        $tahun = substr($tanggal, 0, 4);
        $bulan = substr($tanggal, 5, 2);
        $AbsensiUangMakan->delete();

        return redirect('/belanja-51-pusat/uang-makan/absensi/' . $tahun . '/' . $bulan . '/' . $AbsensiUangMakan->nip)->with('berhasil', 'Data Berhasil Di Hapus');
    }
}
