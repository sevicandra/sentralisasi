@extends('monitoring.beranda.detail.layout')
@section('beranda_content')
<table class="table table-bordered table-hover">
    <thead class="text-center">
        <tr class="align-middle">
            <th rowspan="2">No</th>
            <th colspan="3">Data Pegawai</th>
            <th colspan="3">Jumlah Jam Lembur</th>
            <th colspan="3">Bruto</th>
            <th>Potongan</th>
            <th rowspan="2">Netto</th>
            <th rowspan="2">Keterangan Jam Lembur (Tgl/Jam)</th>
        </tr>
        <tr class="align-middle">
            <th>Nama</th>
            <th>NIP</th>
            <th>Gol</th>
            <th>Hari Kerja</th>
            <th>Hari Libur</th>
            <th>Uang Makan</th>
            <th>Uang Lembur</th>
            <th>Uang Makan</th>
            <th>Jumlah</th>
            <th>PPh Psl 21 Final</th>
        </tr>
    </thead>
    <tbody>
            <tr class="align-middle">
                <td class="text-center"></td>
                <td></td>
                <td></td>
                <td></td>
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
