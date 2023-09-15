@extends('layout.main')
@section('aside-menu')
    @include('monitoring.sidemenu')
@endsection         
@section('main-content')
    <div id="main-content-header">
        <div class="row">
            <div class="row">
                <div class="row">
                    <div class="col-lg-12">
                        @foreach ($tahun as $item)
                        <a href="{{ config('app.url') }}/monitoring/rincian/{{ $satker->kdsatker }}/{{ $nip }}/uang-lembur/{{ $item->tahun }}" class="btn btn-sm btn-outline-success @if (Request('thn') === null && $item->tahun === date('Y') || $item->tahun === request('thn'))active @endif ml-1 mt-1 mb-1">{{ $item->tahun }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="main-content">
        <div class="table-warper" style="overflow-x:auto">
            <table class="table table-bordered table-hover">
                <thead class="text-center">
                    <tr class="align-middle">
                        <th rowspan="2">No</th>
                        <th rowspan="2">Bulan</th>
                        <th colspan="3">Jumlah Jam Lembur</th>
                        <th colspan="3">Bruto</th>
                        <th>Potongan</th>
                        <th rowspan="2">Netto</th>
                        <th rowspan="2">Keterangan Jam Lembur (Tgl/Jam)</th>
                    </tr>
                    <tr class="align-middle">
                        <th>Hari Kerja</th>
                        <th>Hari Libur</th>
                        <th>Hari Uang Makan</th>
                        <th>Uang Lembur</th>
                        <th>Uang Makan</th>
                        <th>Jumlah</th>
                        <th>PPh Psl 21 Final</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no=1;
                    @endphp
                    @foreach ($data as $item)
                        <tr class="align-middle">
                            <td class="text-center">{{ $no++ }}</td>
                            <td>{{ $item->nama_bulan }}</td>
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
                    @endforeach
                    <tr>
                        <th colspan="2" class="text-center">Jumlah</th>
                        <td class="text-right">{{ number_format($data->sum('jkerja'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('jlibur'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('jmakan'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('lembur'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('makan'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('bruto'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('pph'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('netto'), 0, ',', '.') }}</td>
                        <th></th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div id="paginator">
        {{-- {{$data->links()}} --}}
    </div>


@endsection