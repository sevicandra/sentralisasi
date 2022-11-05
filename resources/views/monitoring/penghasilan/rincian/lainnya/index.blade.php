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
                        <a href="{{ config('app.url') }}/monitoring/penghasilan/{{ $satker->kdsatker }}/{{ $nip }}/lainnya/{{ $item->tahun }}/{{ $jns }}" class="btn btn-sm btn-outline-success @if (Request('thn') === null && $item->tahun === date('Y') || $item->tahun === request('thn'))active @endif ml-1 mt-1 mb-1">{{ $item->tahun }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        @foreach ($jenis as $item)
                        <a href="{{ config('app.url') }}/monitoring/penghasilan/{{ $satker->kdsatker }}/{{ $nip }}/lainnya/{{ $thn }}/{{ $item->jenis }}" class="btn btn-sm btn-outline-success @if ($jns === $item->jenis ) active @endif ml-1 mt-1 mb-1">{{ $item->jenis }}</a>
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
                    <tr>
                        <th>No</th>
                        <th>Bulan</th>
                        <th>Bruto</th>
                        <th>PPh</th>
                        <th>Netto</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no=1;
                    @endphp
                    @foreach ($data as $item)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td><a href="{{ config('app.url') }}/monitoring/penghasilan/{{ $satker->kdsatker }}/{{ $nip }}/lainnya/{{ $thn }}/{{ $jns }}/{{ $item->bulan }}/detail">{{ $item->nama_bulan }}</a></td>
                            <td class="text-right"><?= number_format($item->bruto, 0, ',', '.'); ?></td>
                            <td class="text-right"><?= number_format($item->pph, 0, ',', '.'); ?></td>
                            <td class="text-right"><?= number_format($item->netto, 0, ',', '.'); ?></td>
                        </tr> 
                    @endforeach
                    <tr>
                        <th colspan="2" class="text-center">Jumlah</th>
                        <td class="text-right"><?= number_format($data->sum('bruto'), 0, ',', '.'); ?></td>
                        <td class="text-right"><?= number_format($data->sum('pph'), 0, ',', '.'); ?></td>
                        <td class="text-right"><?= number_format($data->sum('netto'), 0, ',', '.'); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div id="paginator">
        {{-- {{$data->links()}} --}}
    </div>


@endsection