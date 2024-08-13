@extends('layout.main')
@section('aside-menu')
    @include('monitoring.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 flex-wrap py-2 px-4">
            <div class="w-full flex gap-1 flex-wrap">
                @foreach ($tahun as $item)
                    <a href="{{ config('app.url') }}/monitoring/penghasilan/{{ $satker->kdsatker }}/{{ $nip }}/tunjangan-kinerja/{{ $item->tahun }}/{{ $jns }}"
                        class="btn btn-xs btn-outline btn-primary @if ((Request('thn') === null && $item->tahun === date('Y')) || $item->tahun === request('thn')) btn-active @endif">{{ $item->tahun }}</a>
                @endforeach
            </div>
            <div class="w-full flex gap-1 flex-wrap">
                <a href="{{ config('app.url') }}/monitoring/penghasilan/{{ $satker->kdsatker }}/{{ $nip }}/tunjangan-kinerja/{{ $thn }}/rutin"
                    class="btn btn-xs btn-outline btn-primary @if ($jns === 'rutin' || $jns === null) btn-active @endif">Rutin</a>
                <a href="{{ config('app.url') }}/monitoring/penghasilan/{{ $satker->kdsatker }}/{{ $nip }}/tunjangan-kinerja/{{ $thn }}/kekurangan"
                    class="btn btn-xs btn-outline btn-primary @if ($jns === 'kekurangan') btn-active @endif">Kekurangan</a>
            </div>
        </div>
        <div class="grid grid-rows-[auto_1fr] grid-cols-1 overflow-hidden px-4 pb-2">
            <div></div>
            <div class="overflow-x-auto overflow-y-auto h-full w-full">
                <x-table class="collapse">
                    <x-table.header>
                        <tr class="*:border-x">
                            <x-table.header.column-pin :rowspan="2" class="text-center">No</x-table.header.column-pin>
                            <x-table.header.column-pin :rowspan="2"
                                class="text-center">Bulan</x-table.header.column-pin>
                            <x-table.header.column :colspan="7" class="text-center">Bruto</x-table.header.column>
                            <x-table.header.column class="text-center">Potongan</x-table.header.column>
                            <x-table.header.column :rowspan="2" class="text-center">Netto</x-table.header.column>
                            <x-table.header.column :rowspan="2" class="text-center">Keterangan</x-table.header.column>
                        </tr>
                        <tr class="*:border-x">
                            <x-table.header.column class="text-center">Grade</x-table.header.column>
                            <x-table.header.column class="text-center">Pokok</x-table.header.column>
                            <x-table.header.column class="text-center">Tambahan</x-table.header.column>
                            <x-table.header.column class="text-center">%</x-table.header.column>
                            <x-table.header.column class="text-center">Absen</x-table.header.column>
                            <x-table.header.column class="text-center">Pajak</x-table.header.column>
                            <x-table.header.column class="text-center">Jumlah</x-table.header.column>
                            <x-table.header.column class="text-center">PPh Psl 21</x-table.header.column>
                        </tr>
                    </x-table.header>
                    <x-table.body>
                        @foreach ($data as $item)
                            <tr class="*:border">
                                <x-table.body.column-pin
                                    class="text-center">{{ $loop->iteration }}</x-table.body.column-pin>
                                <x-table.body.column-pin class="">{{ $item->nama_bulan }}</x-table.body.column-pin>
                                <x-table.body.column
                                    class="text-center">{{ number_format($item->grade, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->tjpokok, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->tjtamb, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->abspotp, 2, ',', '.') }}%</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->abspotr, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->tkpph, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->tjpokok, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->tkpph, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->tjpokok, 0, ',', '.') }}</x-table.body.column>
                                @php
                                    $p1 = 'Terlambat (1%) : ' . number_format($item->p1, 0, ',', '.') . ' kali';
                                    $p2 = 'Terlambat (1,25%) : ' . number_format($item->p2, 0, ',', '.') . ' kali ';
                                    $p3 = 'Terlambat (2,50%) : ' . number_format($item->p3, 0, ',', '.') . ' kali ';
                                    $p4 =
                                        'Pulang Sebelum Waktunya (0,50%) : ' .
                                        number_format($item->p4, 0, ',', '.') .
                                        ' kali';
                                    $p5 =
                                        'Pulang Sebelum Waktunya (1%) : ' .
                                        number_format($item->p5, 0, ',', '.') .
                                        ' kali';
                                    $p6 =
                                        'Pulang Sebelum Waktunya (1,25%) : ' .
                                        number_format($item->p6, 0, ',', '.') .
                                        ' kali';
                                    $p7 =
                                        'Pulang Sebelum Waktunya (2,50%) : ' .
                                        number_format($item->p7, 0, ',', '.') .
                                        ' kali';
                                    $p8 =
                                        'Cuti Penting Saudara Dekat Sakit/Meninggal, Perkawinan, Musibah (0%) : ' .
                                        number_format($item->p8, 0, ',', '.') .
                                        ' kali';
                                    $p9 =
                                        'Cuti Penting Saudara Dekat Sakit/Meninggal, Perkawinan, Musibah (5%) : ' .
                                        number_format($item->p9, 0, ',', '.') .
                                        'kali';
                                    $p10 =
                                        'Cuti Penting Mendampingi Istri Melahirkan : (0%) : ' .
                                        number_format($item->p10, 0, ',', '.') .
                                        ' kali';
                                    $p11 =
                                        'Cuti Penting Mendampingi Istri Melahirkan : (5%) : ' .
                                        number_format($item->p11, 0, ',', '.') .
                                        'kali';
                                    $p12 =
                                        'Cuti Penting Alasan Lainnya (5%) : ' .
                                        number_format($item->p12, 0, ',', '.') .
                                        ' kali';
                                    $p13 =
                                        'Cuti Sakit Dengan Keterangan Dokter/Kecelakaan (0%) : ' .
                                        number_format($item->p13, 0, ',', '.') .
                                        ' kali';
                                    $p14 =
                                        'Cuti Sakit Dengan Keterangan Dokter/Kecelakaan (2,50%) : ' .
                                        number_format($item->p14, 0, ',', '.') .
                                        'kali';
                                    $p15 =
                                        'Cuti Sakit Tanpa Keterangan Dokter (5%) : ' .
                                        number_format($item->p15, 0, ',', '.') .
                                        ' kali';
                                    $p16 =
                                        'Cuti bersalin sampai persalinan ketiga (0%) : ' .
                                        number_format($item->p16, 0, ',', '.') .
                                        'kali';
                                    $p17 =
                                        'Cuti bersalin sampai persalinan ketiga (2,50%) : ' .
                                        number_format($item->p17, 0, ',', '.') .
                                        ' kali';
                                    $p18 = 'Alpha/Ijin (5%) : ' . number_format($item->p18, 0, ',', '.') . ' kali';
                                    $p19 = 'Cuti Besar (0%) : ' . number_format($item->p19, 0, ',', '.') . ' kali';
                                    $p20 = 'Cuti Besar (2,50%) : ' . number_format($item->p20, 0, ',', '.') . ' kali';
                                    $p21 = 'Cuti Besar (5%) : ' . number_format($item->p21, 0, ',', '.') . ' kali';
                                @endphp
                                <x-table.body.column class="text-left">
                                    @if ($item->p1 > 0)
                                        <p> {{ $p1 }} </p>
                                    @endif
                                    @if ($item->p2 > 0)
                                        <p> {{ $p2 }} </p>
                                    @endif
                                    @if ($item->p3 > 0)
                                        <p> {{ $p3 }} </p>
                                    @endif
                                    @if ($item->p4 > 0)
                                        <p> {{ $p4 }} </p>
                                    @endif
                                    @if ($item->p5 > 0)
                                        <p> {{ $p5 }} </p>
                                    @endif
                                    @if ($item->p6 > 0)
                                        <p> {{ $p6 }} </p>
                                    @endif
                                    @if ($item->p7 > 0)
                                        <p> {{ $p7 }} </p>
                                    @endif
                                    @if ($item->p8 > 0)
                                        <p> {{ $p8 }} </p>
                                    @endif
                                    @if ($item->p9 > 0)
                                        <p> {{ $p9 }} </p>
                                    @endif
                                    @if ($item->p10 > 0)
                                        <p> {{ $p10 }} </p>
                                    @endif
                                    @if ($item->p11 > 0)
                                        <p> {{ $p11 }} </p>
                                    @endif
                                    @if ($item->p12 > 0)
                                        <p> {{ $p12 }} </p>
                                    @endif
                                    @if ($item->p13 > 0)
                                        <p> {{ $p13 }} </p>
                                    @endif
                                    @if ($item->p14 > 0)
                                        <p> {{ $p14 }} </p>
                                    @endif
                                    @if ($item->p15 > 0)
                                        <p> {{ $p15 }} </p>
                                    @endif
                                    @if ($item->p16 > 0)
                                        <p> {{ $p16 }} </p>
                                    @endif
                                    @if ($item->p17 > 0)
                                        <p> {{ $p17 }} </p>
                                    @endif
                                    @if ($item->p18 > 0)
                                        <p> {{ $p18 }} </p>
                                    @endif
                                    @if ($item->p19 > 0)
                                        <p> {{ $p19 }} </p>
                                    @endif
                                    @if ($item->p20 > 0)
                                        <p> {{ $p20 }} </p>
                                    @endif
                                    @if ($item->p21 > 0)
                                        <p> {{ $p21 }} </p>
                                    @endif
                                </x-table.body.column>
                            </tr>
                        @endforeach
                        <tr class="*:border">
                            <x-table.body.column-pin :colspan="3" class="text-center">Jumlah</x-table.body.column-pin>
                            <x-table.body.column
                                class="text-right">{{ number_format($data->sum('tjpokok'), 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column
                                class="text-right">{{ number_format($data->sum('tjtamb'), 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column
                                class="text-right">{{ number_format($data->sum('abspotp'), 2, ',', '.') }}%</x-table.body.column>
                            <x-table.body.column
                                class="text-right">{{ number_format($data->sum('abspotr'), 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column
                                class="text-right">{{ number_format($data->sum('tkpph'), 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column
                                class="text-right">{{ number_format($data->sum('tjpokok'), 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column
                                class="text-right">{{ number_format($data->sum('tkpph'), 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column
                                class="text-right">{{ number_format($data->sum('tjpokok'), 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column class=""></x-table.body.column>
                        </tr>
                    </x-table.body>
                </x-table>
            </div>
        </div>
        <div>
            {{-- {{$data->links()}} --}}
        </div>
    </div>
@endsection
