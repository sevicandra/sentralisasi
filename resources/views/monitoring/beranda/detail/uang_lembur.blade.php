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
        @php
            $no = 1;
            $j1 = 0;
            $j2 = 0;
            $j3 = 0;
            $j4 = 0;
            $j5 = 0;
            $j6 = 0;
            $j7 = 0;
            $j8 = 0;
        @endphp
        @foreach ($data as $item)
        <tr class="align-middle">
            <td class="text-center">{{ $no++ }}</td>
            <td>{{ $item->nama }}</td>
            <td>{{ $item->nip }}</td>
            <td>{{ $item->gol }}</td>
            <td class="text-right">{{ number_format($item->jkerja, 0, ',', '.') }}</td>
            <td class="text-right">{{ number_format($item->jlibur, 0, ',', '.') }}</td>
            <td class="text-right">{{ number_format($item->jmakan, 0, ',', '.') }}</td>
            <td class="text-right">{{ number_format($item->lembur, 0, ',', '.') }}</td>
            <td class="text-right">{{ number_format($item->makan, 0, ',', '.') }}</td>
            <td class="text-right">{{ number_format($item->bruto, 0, ',', '.') }}</td>
            <td class="text-right">{{ number_format($item->pph, 0, ',', '.') }}</td>
            <td class="text-right">{{ number_format($item->netto, 0, ',', '.') }}</td>
            <td class="text-muted text-sm">
                @for ($i = 1; $i < 32; $i++)
                    @if ($item->{ 'jhari'.$i } > 1)
                        {{ '(' . $i . '/' . $item->{ 'jhari'.$i } . '), ' }}
                    @endif
                @endfor
            </td>
        </tr>
        @php
            $j1 += $item->jkerja;
            $j2 += $item->jlibur;
            $j3 += $item->jmakan;
            $j4 += $item->lembur;
            $j5 += $item->makan;
            $j6 += $item->bruto;
            $j7 += $item->pph;
            $j8 += $item->netto;
        @endphp
        @endforeach
        <tr>
            <th colspan="4" class="text-center">Jumlah</th>
            <th class="text-right">{{ number_format($j1, 0, ',', '.') }}</th>
            <th class="text-right">{{ number_format($j2, 0, ',', '.') }}</th>
            <th class="text-right">{{ number_format($j3, 0, ',', '.') }}</th>
            <th class="text-right">{{ number_format($j4, 0, ',', '.') }}</th>
            <th class="text-right">{{ number_format($j5, 0, ',', '.') }}</th>
            <th class="text-right">{{ number_format($j6, 0, ',', '.') }}</th>
            <th class="text-right">{{ number_format($j7, 0, ',', '.') }}</th>
            <th class="text-right">{{ number_format($j8, 0, ',', '.') }}</th>
            <th></th>
        </tr>
    </tbody>
</table>
@endsection
