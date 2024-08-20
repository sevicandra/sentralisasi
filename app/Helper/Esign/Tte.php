<?php

namespace App\Helper\Esign;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class Tte
{
    private $_client;

    public function __construct()
    {
        $this->_client = new Client([
            'base_uri' => config('esign.ESIGN_URI'),
            'verify' => false,
            'auth' => [config('esign.ESIGN_AUTH_ID'), config('esign.ESIGN_AUTH_PASSWORD')]
        ]);
    }

    public function esign($data, $nik, $passpharse)
    {
        $response = $this->_client->request('POST', 'pdf', [
            'query' => [
                "nik" => $nik,
                "passphrase" => $passpharse,
                "jenis_dokumen" => $data['jenis_dokumen'],
                "nomor" => $data['nomor'],
                "tujuan" => $data['tujuan'],
                "perihal" => $data['perihal'],
                "tampilan" => "visible",
                "height" => "75",
                "width" => "75",
                "linkQR" => $data['linkQR'],
                "image" => false,
                "tag_koordinat" => "$",
            ],
            'multipart' => [
                [
                    'name'     => 'file',
                    'contents' => fopen(storage_path('app/' . $data['file']), 'r'),
                    'filename' => basename($data['file']),
                ]
            ]
        ]);
        return $response;
    }

    public function esignXY($data, $nik, $passpharse)
    {
        $response = $this->_client->request('POST', 'pdf', [
            'query' => [
                "nik" => $nik,
                "passphrase" => $passpharse,
                "jenis_dokumen" => $data['jenis_dokumen'],
                "nomor" => $data['nomor'],
                "tujuan" => $data['tujuan'],
                "perihal" => $data['perihal'],
                "tampilan" => "visible",
                "height" => "75",
                "width" => "75",
                "linkQR" => $data['linkQR'],
                "image" => false,
                "xAxis" => "10",
                "yAxis" => "10",
                "page" => "1",
            ],
            'multipart' => [
                [
                    'name'     => 'file',
                    'contents' => fopen(storage_path('app/' . $data['file']), 'r'),
                    'filename' => basename($data['file']),
                ]
            ]
        ]);
        return $response;
    }
}
