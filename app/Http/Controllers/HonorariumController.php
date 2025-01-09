<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\bulan;
use Illuminate\Http\Request;
use App\Models\dataHonorarium;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class HonorariumController extends Controller
{
    public function index($thn = null)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_honor', 'admin_pusat'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        $kdsatker= auth()->user()->kdsatker;
        $tahun =dataHonorarium::tahun($kdsatker);
        if (!isset($thn)) {
            if (isset($tahun->first()->tahun)) {
                $thn = $tahun->first()->tahun;
            }else{
                $thn = date('Y');
            }
        }

        return view('honorarium.index',[
            'data'=>dataHonorarium::honor($kdsatker, $thn)->get(),
            'tahun'=>$tahun,
            'thn'=>$thn,
            "pageTitle"=>"Honorarium",
            'honorariumDraft'=>dataHonorarium::draft(),
        ]);
    }

    public function create()
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_honor', 'admin_pusat'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }
        return view('honorarium.create',[
            "pageTitle"=>"Import Honorarium",
            'honorariumDraft'=>dataHonorarium::draft(),
        ]);
    }

    public function import(Request $request)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_honor', 'admin_pusat'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id)) {
            abort(403);
        }

        $request->validate([
            'file_excel'=>'required|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'file_pendukung'=>'required|mimes:pdf',
            'bulan'=>'required|min_digits:2|max_digits:2',
            'tahun'=>'required|min_digits:4|max_digits:4',
        ],[
            'file_excel.mimetypes'=>'The file must be a xlsx file',
            'file_pendukung.mimetypes'=>'The file must be a pdf file',
        ]);
        $request->validate([
            'bulan'=>'numeric',
            'tahun'=>'numeric',
        ]);

        $path = $request->file('file_pendukung')->store('honorarium');
        $file_name_extension = explode("/",$path);
        $file_name= explode('.', $file_name_extension[1]);
        $file = $request->file('file_excel');
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($file);
        $sheetData = $spreadsheet->getSheetByName('honorarium')->toArray();
        $slicedSheet = array_slice($sheetData, 2);
        foreach ($slicedSheet as $item) {
            if ($item[0] === null) {
                break;
            }
            $date = Carbon::createFromFormat('d-m-Y', $item[6])->timestamp;
            if ($item[4] === null) {
                $pph    =   0;
            }else{
                $pph    =   $item[4];
            }
            dataHonorarium::create([
                'bulan'=>$request->bulan,
                'nmbulan'=>bulan::nmbulan($request->bulan),
                'tahun'=>$request->tahun,
                'kdsatker'=>auth()->user()->kdsatker,
                'nama'=>$item[1],
                'nip'=>$item[2],
                'bruto'=>$item[3],
                'pph'=>$pph,
                'uraian'=>$item[5],
                'tanggal'=>$date,
                'file'=>$file_name[0]
            ]);
        }
        return Redirect('/honorarium')->with('berhasil', 'data berhasil di upload'); 
    }

    public function dokumen($file)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_honor', 'admin_pusat'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id) || dataHonorarium::where('file', $file)->first()->kdsatker != auth()->user()->kdsatker) {
            abort(403);
        }
        
        return response()->file(Storage::path('honorarium/'.$file.'.pdf'),[
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function delete($file)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_honor', 'admin_pusat'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id) || dataHonorarium::where('file', $file)->first()->kdsatker != auth()->user()->kdsatker || dataHonorarium::where('file', $file)->max('sts') != 0) {
            abort(403);
        }

        dataHonorarium::where('file', $file)->delete();
        Storage::delete('honorarium/'.$file.'.pdf');
        return Redirect('/honorarium')->with('berhasil', 'data berhasil di hapus');
    }

    public function kirim($file)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_honor', 'admin_pusat'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id) || dataHonorarium::where('file', $file)->first()->kdsatker != auth()->user()->kdsatker || dataHonorarium::where('file', $file)->min('sts') != 0) {
            abort(403);    
        }

        dataHonorarium::where('file', $file)->where('sts', '=', '0')->update(['sts' => '1']);
        return Redirect('/honorarium')->with('berhasil', 'data berhasil di hapus');
    }

    public function edit(dataHonorarium $dataHonorarium)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_honor', 'admin_pusat'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id) || $dataHonorarium->kdsatker != auth()->user()->kdsatker || dataHonorarium::where('file', $dataHonorarium->file)->max('sts') != 0) {
            abort(403);    
        }
        if($dataHonorarium->sts != '0'){
            abort(403);
        }
        return view('honorarium.edit',[
            'data'=>$dataHonorarium,
            'pageTitle'=>'Edit Honorarium',
            'honorariumDraft'=>dataHonorarium::draft(),
        ]);
    }

    public function update(Request $request, $file)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_honor', 'admin_pusat'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id) || dataHonorarium::where('file', $file)->first()->kdsatker != auth()->user()->kdsatker || dataHonorarium::where('file', $file)->max('sts') != 0) {
            abort(403);
        }

        if ($request->file_pendukung) {
            $request->validate([
                'file_pendukung'=>'required|mimes:pdf',
                'bulan'=>'required|min:2|max:2',
                'tahun'=>'required|min:4|max:4',
            ],[
                'file_pendukung.mimetypes'=>'The file must be a pdf file',
            ]);

            
            $path = $request->file('file_pendukung')->store('honorarium');
            $new_file_name_extension = explode("/",$path);
            $new_file_name= explode('.', $new_file_name_extension[1]);
            dataHonorarium::where('file', $file)->update([
                'file' => $new_file_name[0],
                'bulan' => $request->bulan,
                'nmbulan'=>bulan::nmbulan($request->bulan),
                'tahun' => $request->tahun
            ]);
            Storage::delete('honorarium/'.$file.'.pdf');
            return redirect('/honorarium')->with('berhasil', 'data berhasil di ubah');
            
        }else{
            $request->validate([
                'bulan'=>'required|min:2|max:2',
                'tahun'=>'required|min:4|max:4',
            ]);
    
            $request->validate([
                'bulan'=>'numeric',
                'tahun'=>'numeric',
            ]);
            dataHonorarium::where('file', $file)->update([
                'bulan' => $request->bulan,
                'tahun' => $request->tahun,
                'nmbulan'=>bulan::nmbulan($request->bulan),
            ]);
            return redirect('/honorarium')->with('berhasil', 'data berhasil di ubah');
        }

    }

    public function detail($file)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_honor', 'admin_pusat'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id) || dataHonorarium::where('file', $file)->first()->kdsatker != auth()->user()->kdsatker) {
            abort(403);
        }

        $kdsatker= auth()->user()->kdsatker;

        return view('honorarium.detail.index',[
            'data'=>dataHonorarium::honorDetail($kdsatker, $file)->paginate(15),
            "pageTitle"=>"Detail Honorarium",
            'honorariumDraft'=>dataHonorarium::draft(),
        ]);
    }

    public function editDetail(dataHonorarium $dataHonorarium)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_honor', 'admin_pusat'];
        }else{
            $gate=['admin_satker'];
        }
        
        if (!Gate::any($gate, auth()->user()->id) || $dataHonorarium->kdsatker != auth()->user()->kdsatker || $dataHonorarium->sts != 0) {
            abort(403);    
        }
        
        if($dataHonorarium->sts != '0'){
            abort(403);
        }
        return view('honorarium.detail.edit',[
            'data'=>$dataHonorarium,
            'pageTitle'=>'Edit Honorarium',
            'honorariumDraft'=>dataHonorarium::draft(),
        ]);
    }

    public function updateDetail(Request $request, dataHonorarium $dataHonorarium)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_honor', 'admin_pusat'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id) || $dataHonorarium->kdsatker != auth()->user()->kdsatker || $dataHonorarium->sts != 0) {
            abort(403);    
        }
        if($dataHonorarium->sts != '0'){
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

        $dataHonorarium->update([
            'nama'=>$request->nama,
            'nip'=>$request->nip,
            'bruto'=>$request->bruto,
            'pph'=>$request->pph,
            'tanggal'=>Carbon::createFromFormat('Y-m-d', $request->tanggal)->timestamp,
            'uraian'=>$request->uraian,
        ]);
        return redirect('/honorarium/'.$dataHonorarium->file.'/detail')->with('berhasil', 'data berhasil di ubah');
    }

    public function deleteDetail(dataHonorarium $dataHonorarium)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_honor', 'admin_pusat'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id) || $dataHonorarium->kdsatker != auth()->user()->kdsatker || $dataHonorarium->sts != 0) {
            abort(403);    
        }
        if($dataHonorarium->sts != '0'){
            abort(403);
        }
        if (dataHonorarium::where('file', $dataHonorarium->file)->count() === 1 ) {
            Storage::delete('honorarium/'.$dataHonorarium->file.'.pdf');
        }
        
        $dataHonorarium->delete();
        
        return redirect('/honorarium/'.$dataHonorarium->file.'/detail')->with('berhasil', 'data berhasil di hapus');
    }

    public function kirimDetail(dataHonorarium $dataHonorarium)
    {
        if (Auth::guard('web')->check()) {
            $gate=['plt_admin_satker', 'opr_honor', 'admin_pusat'];
        }else{
            $gate=['admin_satker'];
        }

        if (! Gate::any($gate, auth()->user()->id) || $dataHonorarium->kdsatker != auth()->user()->kdsatker || $dataHonorarium->sts != 0) {
            abort(403);    
        }
        if($dataHonorarium->sts != '0'){
            abort(403);
        }
        $dataHonorarium->update([
            'sts'=>'1',
        ]);
        return redirect('/honorarium/'.$dataHonorarium->file.'/detail')->with('berhasil', 'data berhasil di kirim');
    }
}
