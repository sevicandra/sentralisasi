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
        @php
            $i=1;
        @endphp
        @foreach ($data as $item)
        <tr>
            <td class="text-center"> {{$i}} </td>
            <td> {{$item->nmbulan}} </td>
            <td class="text-right">{{number_format($item->peg, 0, ',', '.')}}</td>
            <td class="text-right">{{number_format($item->bruto, 0, ',', '.')}}</td>
            <td class="text-right">{{number_format($item->potongan, 0, ',', '.')}}</td>
            <td class="text-right">{{number_format($item->netto, 0, ',', '.')}}</td>
            <td class="pb-0 pt-0">
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ Request::url() }}/detail?jns={{ request('jns') }}&thn={{request('thn')}}&bln={{$item->bulan}}" class="btn btn-sm btn-outline-success pt-0 pb-0" target="_blank">Detail</a>
                </div>
            </td>
        </tr>
        @php
            $i++
        @endphp
        @endforeach
    </tbody>
</table>
@endsection
