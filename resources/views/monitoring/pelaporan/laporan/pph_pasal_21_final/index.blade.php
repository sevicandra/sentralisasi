@extends('layout.main')
@section('aside-menu')
    @include('monitoring.sidemenu')
@endsection         
@section('main-content')

    <div id="main-content-header">
        <div class="row">
            <div class="row">
                <div class="row mb-3">
                    <div class="col-lg-8">
                        @foreach ($tahun as $item)
                        <a href="{{ config('app.url') }}/monitoring/pelaporan/{{ $satker->kdsatker }}/pph-pasal-21-final/{{ $nip }}/{{ $item->tahun }}" class="btn btn-sm btn-outline-success ml-1 mt-1 mb-1 @if ($thn === $item->tahun) active @endif">{{ $item->tahun }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="main-content">
        <div class="row">
            <div class="col-lg-8">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Jenis Pembayaran</th>
                                <th>Jumlah Bruto</th>
                                <th>PPh Final</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Uang Makan</td>
                                <td class="text-right">{{ number_format($makan->jumlah_bruto, 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($makan->jumlah_pph, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Uang Lembur</td>
                                <td class="text-right">{{ number_format($lembur->jumlah_bruto, 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($lembur->jumlah_pph, 0, ',', '.') }}</td>
                            </tr>
                            @php
                                $no = 3;
                                $j1 = 0;
                                $j2 = 0;    
                            @endphp
                            @foreach ($lain as $item)
                                <tr>
                                    <td>{{ $no++}}</td>
                                    <td>{{ $item->jenis }}</td>
                                    <td class="text-right">{{ number_format($item->jumlah_bruto, 0, ',', '.')}}</td>
                                    <td class="text-right">{{ number_format($item->jumlah_pph, 0, ',', '.')}}</td>
                                </tr>
                                @php
                                    $j1 += $item->jumlah_bruto;
                                    $j2 += $item->jumlah_pph;                            
                                @endphp
                            @endforeach
                            <tr>
                                <td colspan="2">
                                    <a href="{{ config('app.url') }}/monitoring/pelaporan/{{ $satker->kdsatker }}/pph-pasal-21-final/{{ $nip }}/{{ $thn }}/cetak" class="btn btn-sm btn-outline-success">Download Form 1721-VII</a>
                                </td>
                                <td class="text-right">{{ number_format($makan->jumlah_bruto + $lembur->jumlah_bruto+$j1, 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($makan->jumlah_pph +  $lembur->jumlah_pph+$j2, 0, ',', '.')}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="paginator">
        {{-- {{$data->links()}} --}}
    </div>


@endsection