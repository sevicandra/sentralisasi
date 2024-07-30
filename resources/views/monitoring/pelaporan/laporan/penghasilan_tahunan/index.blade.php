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
                        <a href="{{ config('app.url') }}/monitoring/pelaporan/{{ $satker->kdsatker }}/penghasilan-tahunan/{{ $nip }}/{{ $item->tahun }}" class="btn btn-sm btn-outline-success ml-1 mt-1 mb-1 @if ($thn === $item->tahun) active @endif">{{ $item->tahun }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="main-content">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="text-center">
                            <tr class="align-middle">
                                <th rowspan="2">No</th>
                                <th rowspan="2">Bulan</th>
                                <th colspan="3">Gaji</th>
                                <th colspan="3">Uang Makan</th>
                                <th colspan="3">Uang Lembur</th>
                                <th colspan="3">Tunjangan Kinerja</th>
                                <th colspan="3">Total</th>
                                {{-- <th rowspan="2">Cetak</th> --}}
                            </tr>
                            <tr class="align-middle">
                                <th>Bruto</th>
                                <th>Pot</th>
                                <th>Netto</th>
                                <th>Bruto</th>
                                <th>Pot</th>
                                <th>Netto</th>
                                <th>Bruto</th>
                                <th>Pot</th>
                                <th>Netto</th>
                                <th>Bruto</th>
                                <th>Pot</th>
                                <th>Netto</th>
                                <th>Bruto</th>
                                <th>Pot</th>
                                <th>Netto</th>
                            </tr>
                        </thead>
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
                            $j9 = 0;
                            $j10 = 0;
                            $j11 = 0;
                            $j12 = 0;
                            $j13 = 0;
                            $j14 = 0;
                            $j15 = 0;
                            $j16 = 0;
                            $j17 = 0;
                            $j18 = 0;
                            $j19 = 0;
                            $j20 = 0;
                            $j21 = 0;
                        @endphp
                        <tbody>
                            @foreach ($data as $item)
                                @php
                                    $total_bruto = $item->gaji->bruto + $item->kekuranganGaji->bruto + $item->tukin->bruto + $item->kekuranganTukin->bruto + $item->makan->bruto + $item->lembur->bruto;
                                    $total_potongan = $item->gaji->potongan + $item->kekuranganGaji->potongan + $item->tukin->potongan + $item->kekuranganTukin->potongan + $item->makan->potongan + $item->lembur->potongan;
                                    $total_netto = $item->gaji->netto + $item->kekuranganGaji->netto + $item->tukin->netto + $item->kekuranganTukin->netto + $item->makan->netto + $item->lembur->netto;
                                @endphp
                                <tr class="align-middle">
                                    <td class="text-center">{{ $no++ }}</td>
                                    <td>{{ $item->bulan }}</td>
                                    <td class="text-right">{{ number_format(($item->gaji->bruto + $item->kekuranganGaji->bruto), 0, ',', '.')}}</td>
                                    <td class="text-right">{{ number_format(($item->gaji->potongan + $item->kekuranganGaji->potongan), 0, ',', '.')}}</td>
                                    <td class="text-right">{{ number_format(($item->gaji->netto + $item->kekuranganGaji->netto), 0, ',', '.')}}</td>
                                    <td class="text-right">{{ number_format($item->makan->bruto, 0, ',', '.')}}</td>
                                    <td class="text-right">{{ number_format($item->makan->potongan, 0, ',', '.')}}</td>
                                    <td class="text-right">{{ number_format($item->makan->netto, 0, ',', '.')}}</td>
                                    <td class="text-right">{{ number_format($item->lembur->bruto, 0, ',', '.')}}</td>
                                    <td class="text-right">{{ number_format($item->lembur->potongan, 0, ',', '.')}}</td>
                                    <td class="text-right">{{ number_format($item->lembur->netto, 0, ',', '.')}}</td>
                                    <td class="text-right">{{ number_format(($item->tukin->bruto + $item->kekuranganTukin->bruto), 0, ',', '.')}}</td>
                                    <td class="text-right">{{ number_format(($item->tukin->potongan + $item->kekuranganTukin->potongan), 0, ',', '.')}}</td>
                                    <td class="text-right">{{ number_format(($item->tukin->netto + $item->kekuranganTukin->netto), 0, ',', '.')}}</td>
                                    <td class="text-right">{{ number_format($total_bruto, 0, ',', '.')}}</td>
                                    <td class="text-right">{{ number_format($total_potongan, 0, ',', '.')}}</td>
                                    <td class="text-right">{{ number_format($total_netto, 0, ',', '.')}}</td>
                                    {{-- <td class="pb-0 pt-0"> --}}
                                        {{-- <div class="btn-group btn-group-sm" role="group"> --}}
                                            {{-- <a href="{{ Request::url() }}/surat" class="btn btn-sm btn-outline-success pt-0 pb-0">Surat</a>
                                            <a href="{{ Request::url() }}/daftar" class="btn btn-sm btn-outline-success pt-0 pb-0">Daftar</a> --}}
                                        {{-- </div> --}}
                                    {{-- </td> --}}
                                </tr>
                                @php
                                    $j1 += $item->gaji->bruto;
                                    $j2 += $item->gaji->potongan;
                                    $j3 += $item->gaji->netto;
                                    $j4 += $item->kekuranganGaji->bruto;
                                    $j5 += $item->kekuranganGaji->potongan;
                                    $j6 += $item->kekuranganGaji->netto;
                                    $j7 += $item->tukin->bruto;
                                    $j8 += $item->tukin->potongan;
                                    $j9 += $item->tukin->netto;
                                    $j10 += $item->kekuranganTukin->bruto;
                                    $j11 += $item->kekuranganTukin->potongan;
                                    $j12 += $item->kekuranganTukin->netto;
                                    $j13 += $item->makan->bruto;
                                    $j14 += $item->makan->potongan;
                                    $j15 += $item->makan->netto;
                                    $j16 += $item->lembur->bruto;
                                    $j17 += $item->lembur->potongan;
                                    $j18 += $item->lembur->netto;
                                    $j19 += $total_bruto;
                                    $j20 += $total_potongan;
                                    $j21 += $total_netto;
                                @endphp
                            @endforeach
                            <tr>
                                <th colspan="2" class="text-center">Jumlah</th>
                                <th class="text-right">{{ number_format($j1 + $j4, 0, ',', '.')}}</th>
                                <th class="text-right">{{ number_format($j2 + $j5, 0, ',', '.')}}</th>
                                <th class="text-right">{{ number_format($j3 + $j6, 0, ',', '.')}}</th>
                                <!-- <th class="text-right">{{ number_format($j4, 0, ',', '.')}}</th>
                                <th class="text-right">{{ number_format($j5, 0, ',', '.')}}</th>
                                <th class="text-right">{{ number_format($j6, 0, ',', '.')}}</th> -->
                                <th class="text-right">{{ number_format($j7, 0, ',', '.')}}</th>
                                <th class="text-right">{{ number_format($j8, 0, ',', '.')}}</th>
                                <th class="text-right">{{ number_format($j9, 0, ',', '.')}}</th>
                                <th class="text-right">{{ number_format($j10, 0, ',', '.')}}</th>
                                <th class="text-right">{{ number_format($j11, 0, ',', '.')}}</th>
                                <th class="text-right">{{ number_format($j12, 0, ',', '.')}}</th>
                                <th class="text-right">{{ number_format(($j13 + $j16), 0, ',', '.')}}</th>
                                <th class="text-right">{{ number_format(($j14 + $j17), 0, ',', '.')}}</th>
                                <th class="text-right">{{ number_format(($j15 + $j18), 0, ',', '.')}}</th>
                                <th class="text-right">{{ number_format($j19, 0, ',', '.')}}</th>
                                <th class="text-right">{{ number_format($j20, 0, ',', '.')}}</th>
                                <th class="text-right">{{ number_format($j21, 0, ',', '.')}}</th>
                                {{-- <th></th> --}}
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