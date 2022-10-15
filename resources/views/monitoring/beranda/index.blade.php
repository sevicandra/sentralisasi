@extends('monitoring.beranda.layout')
@section('beranda_content')
<table class="table table-bordered table-hover">
    <thead class="text-center">
        <tr class="align-middle">
            <th>No</th>
            <th>Bulan</th>
            <th>Jumlah Pegawai</th>
            <th>Jumlah Bruto</th>
            <th>Jumlah Potongan</th>
            <th>Jumlah Netto</th>
            <th>Detail</th>
        </tr>
    </thead>
    <tbody>
        @for ($i = 0; $i < 100; $i++)
        <tr>
            <td class="text-center"></td>
            <td></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
            <td class="pb-0 pt-0">
                <div class="btn-group btn-group-sm" role="group">
                    <a href="" class="btn btn-sm btn-outline-success pt-0 pb-0" target="_blank">Daftar</a>
                </div>
            </td>
        </tr>
        @endfor
    </tbody>
</table>
@endsection
