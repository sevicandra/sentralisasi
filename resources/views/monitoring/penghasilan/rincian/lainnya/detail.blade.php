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
                        <a href="/monitoring/penghasilan/{{ $satker->kdsatker }}/{{ $nip }}/lainnya/{{ $thn }}/{{ $jns }}"
                            class="btn btn-sm btn-outline-success ml-1 mt-1 mb-2">Kembali ke halaman sebelumnya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="main-content">
        <div class="table-warper" style="overflow-x:auto">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="text-center">
                        <tr class="align-middle">
                            <th>No</th>
                            <th>Uraian Kegiatan</th>
                            <th>Tanggal</th>
                            <th>SPM</th>
                            <th>Bruto</th>
                            <th>PPh</th>
                            <th>Netto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($data as $item)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td>{{ $item->uraian }}</td>
                                <td class="text-center">{{ date('d-m-Y', $item->tanggal) }}</td>
                                <td class="text-center">{{ $item->nospm }}</td>
                                <td class="text-right">{{ number_format($item->bruto, 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($item->pph, 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($item->netto, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach

                        <tr class="align-middle">
                            <th colspan="4" class="text-center">Jumlah</th>
                            <td class="text-right">{{ number_format($data->sum('bruto'), 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($data->sum('pph'), 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($data->sum('netto'), 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="paginator">
        {{-- {{$data->links()}} --}}
    </div>
@endsection
