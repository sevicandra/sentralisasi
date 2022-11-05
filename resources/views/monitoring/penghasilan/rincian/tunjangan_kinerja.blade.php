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
                        <a href="{{ config('app.url') }}/monitoring/penghasilan/{{ $satker->kdsatker }}/{{ $nip }}/tunjangan-kinerja/{{ $item->tahun }}/{{ $jns }}" class="btn btn-sm btn-outline-success @if (Request('thn') === null && $item->tahun === date('Y') || $item->tahun === request('thn'))active @endif ml-1 mt-1 mb-1">{{ $item->tahun }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <a href="{{ config('app.url') }}/monitoring/penghasilan/{{ $satker->kdsatker }}/{{ $nip }}/tunjangan-kinerja/{{ $thn }}/rutin" class="btn btn-sm btn-outline-success @if ($jns === "rutin" || $jns === null ) active @endif ml-1 mt-1 mb-1">Rutin</a>
                        <a href="{{ config('app.url') }}/monitoring/penghasilan/{{ $satker->kdsatker }}/{{ $nip }}/tunjangan-kinerja/{{ $thn }}/kekurangan" class="btn btn-sm btn-outline-success @if ($jns === "kekurangan") active @endif ml-1 mt-1 mb-1">Kekurangan</a>
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
                        <th colspan="7">Bruto</th>
                        <th>Potongan</th>
                        <th rowspan="2">Netto</th>
                        <th rowspan="2">Keterangan Potongan</th>
                    </tr>
                    <tr class="align-middle">
                        <th>Grade</th>
                        <th>Pokok</th>
                        <th>Tambahan</th>
                        <th>%</th>
                        <th>Absen</th>
                        <th>Pajak</th>
                        <th>Jumlah</th>
                        <th>PPh Psl 21</th>
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
                            <td class="text-center">{{ $item->grade }}</td>
                            <td class="text-right">{{ number_format($item->tjpokok, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->tjtamb, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->abspotp, 0, ',', '.') }}%</td>
                            <td class="text-right">{{ number_format($item->abspotr, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->tkpph, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->tjpokok, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->tkpph, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->tjpokok, 0, ',', '.') }}</td>
                                @php
                                    $p1 = 'Terlambat (1%) : ' . number_format($item->p1, 0, ',', '.') . ' kali<br>';
                                    $p2 = 'Terlambat (1,25%) : ' . number_format($item->p2, 0, ',', '.') . ' kali <br>';
                                    $p3 = 'Terlambat (2,50%) : ' . number_format($item->p3, 0, ',', '.') . ' kali <br>';
                                    $p4 = 'Pulang Sebelum Waktunya (0,50%) : ' . number_format($item->p4, 0, ',', '.') . ' kali <br>';
                                    $p5 = 'Pulang Sebelum Waktunya (1%) : ' . number_format($item->p5, 0, ',', '.') . ' kali <br>';
                                    $p6 = 'Pulang Sebelum Waktunya (1,25%) : ' . number_format($item->p6, 0, ',', '.') . ' kali <br>';
                                    $p7 = 'Pulang Sebelum Waktunya (2,50%) : ' . number_format($item->p7, 0, ',', '.') . ' kali <br>';
                                    $p8 = 'Cuti Penting Saudara Dekat Sakit/Meninggal, Perkawinan, Musibah (0%) : ' . number_format($item->p8, 0, ',', '.') . ' kali <br>';
                                    $p9 = 'Cuti Penting Saudara Dekat Sakit/Meninggal, Perkawinan, Musibah (5%) : ' . number_format($item->p9, 0, ',', '.') . 'kali <br>';
                                    $p10 = 'Cuti Penting Mendampingi Istri Melahirkan : (0%) : ' . number_format($item->p10, 0, ',', '.') . ' kali <br>';
                                    $p11 = 'Cuti Penting Mendampingi Istri Melahirkan : (5%) : ' . number_format($item->p11, 0, ',', '.') . 'kali <br>';
                                    $p12 = 'Cuti Penting Alasan Lainnya (5%) : ' . number_format($item->p12, 0, ',', '.') . ' kali <br>';
                                    $p13 = 'Cuti Sakit Dengan Keterangan Dokter/Kecelakaan (0%) : ' . number_format($item->p13, 0, ',', '.') . ' kali <br>';
                                    $p14 = 'Cuti Sakit Dengan Keterangan Dokter/Kecelakaan (2,50%) : ' . number_format($item->p14, 0, ',', '.') . 'kali <br>';
                                    $p15 = 'Cuti Sakit Tanpa Keterangan Dokter (5%) : ' . number_format($item->p15, 0, ',', '.') . ' kali <br>';
                                    $p16 = 'Cuti bersalin sampai persalinan ketiga (0%) : ' . number_format($item->p16, 0, ',', '.') . 'kali <br>';
                                    $p17 = 'Cuti bersalin sampai persalinan ketiga (2,50%) : ' . number_format($item->p17, 0, ',', '.') . ' kali <br>';
                                    $p18 = 'Alpha/Ijin (5%) : ' . number_format($item->p18, 0, ',', '.') . ' kali <br>';
                                    $p19 = 'Cuti Besar (0%) : ' . number_format($item->p19, 0, ',', '.') . ' kali <br>';
                                    $p20 = 'Cuti Besar (2,50%) : ' . number_format($item->p20, 0, ',', '.') . ' kali <br>';
                                    $p21 = 'Cuti Besar (5%) : ' . number_format($item->p21, 0, ',', '.') . ' kali <br>';
                                @endphp
                            <td class="text-muted text-sm">
                            </td>
                            @if ($item->p1 > 0) {{ $p1 }}  @endif
                            @if ($item->p2 > 0) {{ $p2 }}  @endif
                            @if ($item->p3 > 0) {{ $p3 }}  @endif
                            @if ($item->p4 > 0) {{ $p4 }}  @endif
                            @if ($item->p5 > 0) {{ $p5 }}  @endif
                            @if ($item->p6 > 0) {{ $p6 }}  @endif
                            @if ($item->p7 > 0) {{ $p7 }}  @endif
                            @if ($item->p8 > 0) {{ $p8 }}  @endif
                            @if ($item->p9 > 0) {{ $p9 }}  @endif
                            @if ($item->p1 > 0) {{ $p1 }}  @endif
                            @if ($item->p10 > 0) {{ $p10 }}  @endif
                            @if ($item->p11 > 0) {{ $p11 }}  @endif
                            @if ($item->p12 > 0) {{ $p12 }}  @endif
                            @if ($item->p13 > 0) {{ $p13 }}  @endif
                            @if ($item->p14 > 0) {{ $p14 }}  @endif
                            @if ($item->p15 > 0) {{ $p15 }}  @endif
                            @if ($item->p16 > 0) {{ $p16 }}  @endif
                            @if ($item->p17 > 0) {{ $p17 }}  @endif
                            @if ($item->p18 > 0) {{ $p18 }}  @endif
                            @if ($item->p19 > 0) {{ $p19 }}  @endif
                            @if ($item->p20 > 0) {{ $p20 }}  @endif
                            @if ($item->p21 > 0) {{ $p21 }}  @endif
                        </tr>
                    @endforeach
                    <tr class="align-middle">
                        <th colspan="3" class="text-center">Jumlah</th>
                        <td class="text-right">{{ number_format($data->sum('tjpokok'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('tjtamb'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('abspotp'), 0, ',', '.') }}%</td>
                        <td class="text-right">{{ number_format($data->sum('abspotr'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('tkpph'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('tjpokok'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('tkpph'), 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data->sum('tjpokok'), 0, ',', '.') }}</td>
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