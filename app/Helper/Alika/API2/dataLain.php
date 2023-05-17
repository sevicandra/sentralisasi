<?php

namespace App\Helper\Alika\API2;

use Illuminate\Support\Facades\Http;

class dataLain
{
    public static function get($id = null, $limit = null,$offset = 0)
    {
        
        if (request('nip')) {
            $data=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri2').'data-lain',[
                'keyword1'=>request('nip'),
                'keyword2'=>request('tahun'),
                'limit' => $limit,
                'offset' => $offset,
                'X-API-KEY' => config('alika.key')
            ]);
    
        }else{
            $data=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri2').'data-lain',[
                $id === null ?: 'id' => $id,
                'limit' => 15,
                'offset' => $offset,
                'X-API-KEY' => config('alika.key')
            ]);
        }
        return json_decode($data);
    }

    public static function count()
    {
        $data=Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->get(config('alika.uri2').'count-data-lain',[
            'X-API-KEY' => config('alika.key')
        ]);
        return json_decode($data);
    }

    public static function post($data)
    {
        $response = Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->asForm()->post(config('alika.uri2').'data-lain',[
            'bulan' => $data['bulan'],
            'tahun' => $data['tahun'],
            'kdsatker' => $data['kdsatker'],
            'nip' => $data['nip'],
            'bruto' => $data['bruto'],
            'pph' => $data['pph'],
            'netto' => $data['netto'],
            'jenis' => $data['jenis'],
            'uraian' => $data['uraian'],
            'tanggal' => $data['tanggal'],
            'nospm' => $data['nospm'],
            'X-API-KEY' => config('alika.key')
        ]);
        return $response;
    }

    public static function postMasal($path, $name)
    {
        $response = Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->attach(
            'json', file_get_contents($path), $name
        )->post(config('alika.uri2').'data-lain',[
            'X-API-KEY' => config('alika.key')
        ]);
        return $response;
    }

    public static function patch($data)
    {
        $response = Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->asForm()->put(config('alika.uri2').'data-lain',[
            'bulan' => $data['bulan'] ,
            'tahun' => $data['tahun'] ,
            'kdsatker' => $data['kdsatker'] ,
            'nip' => $data['nip'] ,
            'bruto' => $data['bruto'] ,
            'pph' => $data['pph'] ,
            'netto' => $data['netto'] ,
            'jenis' => $data['jenis'] ,
            'uraian' => $data['uraian'] ,
            'tanggal' => $data['tanggal'] ,
            'nospm' => $data['nospm'] ,
            'id' => $data['id'],
            'X-API-KEY' => config('alika.key')
        ]);
        return $response;
    }

    public static function delete($id)
    {
        $response = Http::withBasicAuth(config('alika.auth'), config('alika.secret'))->asForm()->delete(config('alika.uri2').'data-lain',[
            'id' => $id,
            'X-API-KEY' => config('alika.key')
        ]);
        return $response;
    }
};