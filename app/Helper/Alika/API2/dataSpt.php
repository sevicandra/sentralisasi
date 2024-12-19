<?php
namespace App\Helper\Alika\API2;

use Illuminate\Support\Facades\Http;

class dataSpt
{
    public static function getSpt($id = null)
    {
        $data=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri2').'data-spt-pegawai',[
            'id'=>$id,
            'X-API-KEY' => config('alika.key')
        ]);
        return json_decode($data);
    }

    public static function getTahun($kdsatker = null){
        $data=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri2').'data-spt-satker-tahun',[
            'X-API-KEY' => config('alika.key'),
            'kdsatker' => $kdsatker
        ]);
        return json_decode($data);
    }

    public static function getDataSpt($kdsatker = null, $tahun = null, $limit = null, $offset=0){
        $data=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri2').'data-spt-satker',[
            'X-API-KEY' => config('alika.key'),
            'kdsatker' => $kdsatker,
            'tahun' => $tahun,
            'limit' => $limit,
            'offset' => $offset
        ]);
        return json_decode($data);
    }

    public static function create($data){
        $data=Http::asForm()->withBasicAuth(config('alika.auth'), config('alika.secret'))->post(config('alika.uri2').'data-spt-pegawai',[
            'X-API-KEY' => config('alika.key'),
            'tahun'=>$data['tahun'],
            'nip'=>$data['nip'],
            'npwp'=>$data['npwp'],
            'kdgol'=>$data['kdgol'],
            'alamat'=>$data['alamat'],
            'kdkawin'=>$data['kdkawin'],
            'kdjab'=>$data['kdjab'],
            'kdsatker'=>$data['kdsatker'],
        ]);
        return $data;
    }

    public static function update($data){
        $data=Http::asForm()->withBasicAuth(config('alika.auth'), config('alika.secret'))->put(config('alika.uri2').'data-spt-pegawai',[
            'X-API-KEY' => config('alika.key'),
            'tahun'=>$data['tahun'],
            'nip'=>$data['nip'],
            'npwp'=>$data['npwp'],
            'kdgol'=>$data['kdgol'],
            'alamat'=>$data['alamat'],
            'kdkawin'=>$data['kdkawin'],
            'kdjab'=>$data['kdjab'],
            'kdsatker'=>$data['kdsatker'],
            'id'=>$data['id'],
        ]);
        return $data;
    }

    public static function delete($id){
        $data=Http::asForm()->withBasicAuth(config('alika.auth'), config('alika.secret'))->delete(config('alika.uri2').'data-spt-pegawai',[
            'X-API-KEY' => config('alika.key'),
            'id'=>$id,
        ]);
        return $data;
    }
}