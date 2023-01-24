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
                        <a href="{{ config('app.url') }}/monitoring/penghasilan/{{ $satker->kdsatker }}/{{ $nip }}/penghasilan/{{ $item->tahun }}" class="btn btn-sm btn-outline-success @if (Request('thn') === null && $item->tahun === date('Y') || $item->tahun === request('thn'))active @endif ml-1 mt-1 mb-1">{{ $item->tahun }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="main-content">
        <div class="table-warper">
            <table class="table table-bordered table-hover">
                <thead class="text-center">
                    <tr class="align-middle">
                        <th>No</th>
                        <th>Bulan</th>
                        <th>Gaji</th>
                        <th>Uang Makan</th>
                        <th>Uang Lembur</th>
                        <th>Tunjangan Kinerja</th>
                        <th>Total</th>
                        {{-- <th>Cetak</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i=1
                    @endphp
                    @foreach ($data as $item)
                        <tr class="align-middle">
                            <td class="text-center">{{ $i++ }}</td>
                            <td>{{ $item->bulan }}</td>
                            <td class="text-right">{{ number_format($item->netto1 + $item->netto2, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->netto3, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->netto4, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->netto5 +$item->netto6, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->netto1 + $item->netto2 + $item->netto3 + $item->netto4 +$item->netto5 +$item->netto6, 0, ',', '.')}}</td>
                            {{-- <td class="pb-0 pt-0">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ Request::url() }}/{{ $nip }}/{{ $item->bulan }}/{{ request('thn') }}/surat" class="btn btn-sm btn-outline-success pt-0 pb-0">Surat</a>
                                    <a href="{{ Request::url() }}/{{ $nip }}/{{ $item->bulan }}/{{ request('thn') }}/daftar" class="btn btn-sm btn-outline-success pt-0 pb-0">Daftar</a>
                                </div>
                            </td> --}}
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan="2" class="text-center">Jumlah</th>
                        <th class="text-right">{{ number_format($data->sum('netto1') + $data->sum('netto2'), 0, ',', '.') }}</th>
                        <th class="text-right">{{ number_format($data->sum('netto3'), 0, ',', '.') }}</th>
                        <th class="text-right">{{ number_format($data->sum('netto4'), 0, ',', '.') }}</th>
                        <th class="text-right">{{ number_format($data->sum('netto5') + $data->sum('netto6'), 0, ',', '.') }}</th>
                        <th class="text-right">{{ number_format($data->sum('netto1') + $data->sum('netto2') + $data->sum('netto3') + $data->sum('netto4') +$data->sum('netto5') +$data->sum('netto6'), 0, ',', '.') }}</th>
                        {{-- <th></th> --}}
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div id="paginator">
        {{-- {{$data->links()}} --}}
    </div>


@endsection