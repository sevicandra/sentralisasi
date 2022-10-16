@extends('monitoring.beranda.detail.layout')
@section('beranda_content')
<table class="table table-bordered table-hover">
    <thead class="text-center">
        <tr class="align-middle">
            <th rowspan="2">No</th>
            <th colspan="3">Data Pegawai</th>
            <th colspan="6">Bruto</th>
            <th>Potongan</th>
            <th rowspan="2">Netto</th>
            <th rowspan="2">Keterangan Potongan</th>
        </tr>
        <tr class="align-middle">
            <th>Nama</th>
            <th>NIP</th>
            <th>Grade</th>
            <th>Pokok</th>
            <th>Tambahan</th>
            <th>%</th>
            <th>Absen</th>
            <th>Pajak</th>
            <th>Jumlah</th>
            <th>PPh Psl 21</th>
        </tr>
    </thead>
    <tbody>
            <tr class="align-middle">
                <td class="text-center"></td>
                <td></td>
                <td></td>
                <td class="text-center"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-muted text-sm">
                </td>
            </tr>
        <tr class="align-middle">
            <th colspan="4" class="text-center">Jumlah</th>
            <th class="text-right"></th>
            <th class="text-right"></th>
            <th class="text-right"></th>
            <th class="text-right"></th>
            <th class="text-right"></th>
            <th class="text-right"></th>
            <th class="text-right"></th>
            <th class="text-right"></th>
            <th></th>
        </tr>
    </tbody>
</table>
@endsection
