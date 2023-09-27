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
                        <a href="{{ config('app.url') }}/monitoring/penghasilan/{{ $satker->kdsatker }}/{{ $nip }}/gaji/{{ $item->tahun }}/{{ $jns }}" class="btn btn-sm btn-outline-success @if (Request('thn') === null && $item->tahun === date('Y') || $item->tahun === request('thn'))active @endif ml-1 mt-1 mb-1">{{ $item->tahun }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <a href="{{ config('app.url') }}/monitoring/penghasilan/{{ $satker->kdsatker }}/{{ $nip }}/gaji/{{ $thn }}/rutin" class="btn btn-sm btn-outline-success @if ($jns === "rutin" || $jns === null ) active @endif ml-1 mt-1 mb-1">Rutin</a>
                        <a href="{{ config('app.url') }}/monitoring/penghasilan/{{ $satker->kdsatker }}/{{ $nip }}/gaji/{{ $thn }}/kekurangan" class="btn btn-sm btn-outline-success @if ($jns === "kekurangan") active @endif ml-1 mt-1 mb-1">Kekurangan</a>
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
                        <th colspan="10">Bruto</th>
                        <th colspan="7">Potongan</th>
                        <th rowspan="2">Netto</th>
                    </tr>
                    <tr class="align-middle">
                        <th>Gapok</th>
                        <th>Istri</th>
                        <th>Anak</th>
                        <th>Umum</th>
                        <th>Str/Fng</th>
                        <th>Bulat</th>
                        <th>Beras</th>
                        <th>Pajak</th>
                        <th>Lain2</th>
                        <th>Jumlah</th>
                        <th>IWP</th>
                        <th>PPh</th>
                        <th>Rumdin</th>
                        <th>Lain2</th>
                        <th>Taperum</th>
                        <th>BPJS</th>
                        <th>BPJS Kel. Lainnya</th>
                        <th>Jumlah</th>
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
                            <td class="text-right">{{ number_format($item->gapok, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->tistri, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->tanak, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->tumum + $item->ttambumum, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->tstruktur + $item->tfungsi, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->bulat, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->tberas, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->tpajak, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->tpapua + $item->tpencil + $item->tlain, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->gapok + $item->tistri +$item->tanak+$item->tumum + $item->ttambumum+$item->tstruktur + $item->tfungsi+$item->bulat+$item->tberas+$item->tpajak+$item->tpapua + $item->tpencil + $item->tlain, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->iwp, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->pph, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->sewarmh, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->pberas + $item->tunggakan + $item->utanglebih + $item->potlain, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->taperum, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->bpjs, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->bpjs2, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->iwp + $item->pph + $item->sewarmh + $item->pberas + $item->tunggakan + $item->utanglebih + $item->potlain + $item->taperum + $item->bpjs + $item->bpjs2, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->gapok + $item->tistri +$item->tanak+$item->tumum + $item->ttambumum+$item->tstruktur + $item->tfungsi+$item->bulat+$item->tberas+$item->tpajak+$item->tpapua + $item->tpencil + $item->tlain -($item->iwp + $item->pph + $item->sewarmh + $item->pberas + $item->tunggakan + $item->utanglebih + $item->potlain + $item->taperum + $item->bpjs + $item->bpjs2), 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr class="align-middle">
                        <th colspan="2" class="text-center">Jumlah</th>
                        <td class="text-right">{{ number_format($data->sum('gapok'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('tistri'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('tanak'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('tumum') + $data->sum('ttambumum'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('tstruktur') + $data->sum('tfungsi'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('bulat'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('tberas'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('tpajak'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('tpapua') + $data->sum('tpencil') + $data->sum('tlain'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('gapok') + $data->sum('tistri') +$data->sum('tanak')+$data->sum('tumum') + $data->sum('ttambumum')+$data->sum('tstruktur') + $data->sum('tfungsi')+$data->sum('bulat')+$data->sum('tberas')+$data->sum('tpajak')+$data->sum('tpapua') + $data->sum('tpencil') + $data->sum('tlain'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('iwp'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('pph'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('sewarmh'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('pberas') + $data->sum('tunggakan') + $data->sum('utanglebih') + $data->sum('potlain'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('taperum'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('bpjs'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('iwp') + $data->sum('pph') + $data->sum('sewarmh') + $data->sum('pberas') + $data->sum('tunggakan') + $data->sum('utanglebih') + $data->sum('potlain') + $data->sum('taperum') + $data->sum('bpjs') + $data->sum('bpjs2'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('gapok') + $data->sum('tistri') +$data->sum('tanak')+$data->sum('tumum') + $data->sum('ttambumum')+$data->sum('tstruktur') + $data->sum('tfungsi')+$data->sum('bulat')+$data->sum('tberas')+$data->sum('tpajak')+$data->sum('tpapua') + $data->sum('tpencil') + $data->sum('tlain') -($data->sum('iwp') + $data->sum('pph') + $data->sum('sewarmh') + $data->sum('pberas') + $data->sum('tunggakan') + $data->sum('utanglebih') + $data->sum('potlain') + $data->sum('taperum') + $data->sum('bpjs') + $data->sum('bpjs2')), 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div id="paginator">
        {{-- {{$data->links()}} --}}
    </div>


@endsection