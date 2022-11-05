@extends('monitoring.beranda.detail.layout')
@section('beranda_content')
<table class="table table-bordered table-hover">
    <thead class="text-center">
        <tr class="align-middle">
            <th rowspan="2">No</th>
            <th colspan="3">Data Pegawai</th>
            <th colspan="6">Bruto</th>
            <th>Potongan</th>
            <th rowspan="2">Netto</th>
            <th rowspan="2">Keterangan Potongan</th>
        </tr>
        <tr class="align-middle">
            <th>Nama</th>
            <th>NIP</th>
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
        @endphp
        @foreach ($data as $item)
            <tr class="align-middle">
                <td class="text-center">{{ $no }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->nip }}</td>
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
            <th colspan="4" class="text-center">Jumlah</th>
            <th class="text-right">{{ number_format($j2, 0, ',', '.')}}</th>
            <th class="text-right">{{ number_format($j3, 0, ',', '.')}}</th>
            <th class="text-right"></th>
            <th class="text-right">{{ number_format($j5, 0, ',', '.')}}</th>
            <th class="text-right">{{ number_format($j6, 0, ',', '.')}}</th>
            <th class="text-right">{{ number_format($j7, 0, ',', '.')}}</th>
            <th class="text-right">{{ number_format($j8, 0, ',', '.')}}</th>
            <th class="text-right">{{ number_format($j9, 0, ',', '.')}}</th>
            <th></th>
        </tr>
    </tbody>
</table>
@endsection
