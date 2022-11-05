@extends('monitoring.beranda.detail.layout')
@section('beranda_content')
<table class="table table-bordered table-hover">
    <thead class="text-center">
        <tr class="align-middle">
            <th rowspan="2">No</th>
            <th colspan="3">Data Pegawai</th>
            <th colspan="3">Bruto</th>
            <th>Potongan</th>
            <th rowspan="2">Netto</th>
        </tr>
        <tr class="align-middle">
            <th>Nama</th>
            <th>NIP</th>
            <th>Gol</th>
            <th>Jml Hari</th>
            <th>Tarif</th>
            <th>Jumlah</th>
            <th>PPh Final</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no = 1;
            $j1 = 0;
            $j2 = 0;
            $j3 = 0;
            $j4 = 0;
            $j5 = 0;
        @endphp
        @foreach ($data as $item)
            <tr class="align-middle">
                <td class="text-center">{{ $no++ }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->nip }}</td>
                <td>{{ $item->kdgol }}</td>
                <td class="text-right">{{ number_format($item->jmlhari, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($item->tarif, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($item->bruto, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($item->pph, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($item->netto, 0, ',', '.') }}</td>
            </tr>
            @php
                $j1 += $item->jmlhari;
                $j2 += $item->tarif;
                $j3 += $item->bruto;
                $j4 += $item->pph;
                $j5 += $item->netto;
            @endphp
        @endforeach
        <tr class="align-middle">
            <th colspan="4" class="text-center">Jumlah</th>
            <th class="text-right">{{ number_format($j1, 0, ',', '.')}}</th>
            <th class="text-right">{{ number_format($j2, 0, ',', '.')}}</th>
            <th class="text-right">{{ number_format($j3, 0, ',', '.')}}</th>
            <th class="text-right">{{ number_format($j4, 0, ',', '.')}}</th>
            <th class="text-right">{{ number_format($j5, 0, ',', '.')}}</th>
        </tr>
    </tbody>
</table>
@endsection
