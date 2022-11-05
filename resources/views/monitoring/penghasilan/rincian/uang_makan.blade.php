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
                        <a href="{{ config('app.url') }}/monitoring/penghasilan/{{ $satker->kdsatker }}/{{ $nip }}/uang-makan/{{ $item->tahun }}" class="btn btn-sm btn-outline-success @if (Request('thn') === null && $item->tahun === date('Y') || $item->tahun === request('thn'))active @endif ml-1 mt-1 mb-1">{{ $item->tahun }}</a>
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
                        <th colspan="3">Bruto</th>
                        <th>Potongan</th>
                        <th rowspan="2">Netto</th>
                    </tr>
                    <tr class="align-middle">
                        <th>Jml Hari</th>
                        <th>Tarif</th>
                        <th>Jumlah</th>
                        <th>PPh Final</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i=1;
                    @endphp
                    @foreach ($data as $item)
                        <tr class="align-middle">
                            <td class="text-center">{{ $i++ }}</td>
                            <td>{{ $item->nama_bulan }}</td>
                            <td class="text-right">{{ number_format($item->jmlhari, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->tarif, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->bruto, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->pph, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->netto, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach

                    <tr class="align-middle">
                        <th colspan="2" class="text-center">Jumlah</th>
                        <td class="text-right">{{ number_format($data->sum('jmlhari'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('tarif'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('bruto'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('pph'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('netto'), 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div id="paginator">
        {{-- {{$data->links()}} --}}
    </div>


@endsection