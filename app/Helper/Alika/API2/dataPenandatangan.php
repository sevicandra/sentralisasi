<?php

namespace App\Helper\Alika\API2;

use Illuminate\Support\Facades\Http;

class dataPenandatangan
{
    public static function getPenandatangan($id = null)
    {
        $data=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri2').'data-profil',[
            'id'=>$id,
            'X-API-KEY' => config('alika.key')
        ]);
        return json_decode($data);
    }

    public static function getDataPenandatangan($kdsatker = null, $limit = null, $offset=0){
        $data=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri2').'data-profil-satker',[
            'X-API-KEY' => config('alika.key'),
            'kdsatker' => $kdsatker,
            'limit' => $limit,
            'offset' => $offset
        ]);
        return json_decode($data);
    }

    public static function CreateDataPenandatangan($data){
        $response = Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->asForm()->post(config('alika.uri2').'data-profil',[
            'tahun' => $data['tahun'],
            'kdsatker' => $data['kdsatker'],
            'nama_ttd_skp' => $data['nama_ttd_skp'],
            'nip_ttd_skp' => $data['nip_ttd_skp'],
            'jab_ttd_skp' => $data['jab_ttd_skp'],
            'nama_ttd_kp4' => $data['nama_ttd_kp4'],
            'nip_ttd_kp4' => $data['nip_ttd_kp4'],
            'jab_ttd_kp4' => $data['jab_ttd_kp4'],
            'npwp_bendahara' => $data['npwp_bendahara'],
            'nama_bendahara' => $data['nama_bendahara'],
            'nip_bendahara' => $data['nip_bendahara'],
            'tgl_spt' => strtotime($data['tgl_spt']),
            'X-API-KEY' => config('alika.key')
        ]);
        return $response;
    }

    public static function UpdateDataPenandatangan($data, $id){
        $response = Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->asForm()->put(config('alika.uri2').'data-profil',[
            'tahun' => $data['tahun'],
            'kdsatker' => $data['kdsatker'],
            'nama_ttd_skp' => $data['nama_ttd_skp'],
            'nip_ttd_skp' => $data['nip_ttd_skp'],
            'jab_ttd_skp' => $data['jab_ttd_skp'],
            'nama_ttd_kp4' => $data['nama_ttd_kp4'],
            'nip_ttd_kp4' => $data['nip_ttd_kp4'],
            'jab_ttd_kp4' => $data['jab_ttd_kp4'],
            'npwp_bendahara' => $data['npwp_bendahara'],
            'nama_bendahara' => $data['nama_bendahara'],
            'nip_bendahara' => $data['nip_bendahara'],
            'tgl_spt' => strtotime($data['tgl_spt']),
            'id' => $id,
            'X-API-KEY' => config('alika.key')
        ]);
        return $response;
    }
}