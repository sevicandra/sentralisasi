@extends('layout.main')
@section('aside-menu')
    @include('monitoring.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 flex-wrap py-2 px-4">
            <div class="w-full flex gap-1 flex-wrap">
                @foreach ($tahun as $item)
                    <a href="{{ config('app.url') }}/monitoring/pelaporan/{{ $satker->kdsatker }}/penghasilan-tahunan/{{ $nip }}/{{ $item->tahun }}"
                        class="btn btn-xs btn-primary btn-outline @if ($thn === $item->tahun) btn-active @endif">{{ $item->tahun }}</a>
                @endforeach
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
                            <x-table.header.column :colspan="3" class="text-center">Gaji</x-table.header.column>
                            <x-table.header.column :colspan="3" class="text-center">Uang Makan</x-table.header.column>
                            <x-table.header.column :colspan="3" class="text-center">Uang Lembur</x-table.header.column>
                            <x-table.header.column :colspan="3" class="text-center">Tunjangan
                                Kinerja</x-table.header.column>
                            <x-table.header.column :colspan="3" class="text-center">Total</x-table.header.column>
                        </tr>
                        <tr class="*:border-x">
                            <x-table.header.column class="text-center">Bruto</x-table.header.column>
                            <x-table.header.column class="text-center">Pot</x-table.header.column>
                            <x-table.header.column class="text-center">Netto</x-table.header.column>
                            <x-table.header.column class="text-center">Bruto</x-table.header.column>
                            <x-table.header.column class="text-center">Pot</x-table.header.column>
                            <x-table.header.column class="text-center">Netto</x-table.header.column>
                            <x-table.header.column class="text-center">Bruto</x-table.header.column>
                            <x-table.header.column class="text-center">Pot</x-table.header.column>
                            <x-table.header.column class="text-center">Netto</x-table.header.column>
                            <x-table.header.column class="text-center">Bruto</x-table.header.column>
                            <x-table.header.column class="text-center">Pot</x-table.header.column>
                            <x-table.header.column class="text-center">Netto</x-table.header.column>
                            <x-table.header.column class="text-center">Bruto</x-table.header.column>
                            <x-table.header.column class="text-center">Pot</x-table.header.column>
                            <x-table.header.column class="text-center">Netto</x-table.header.column>
                        </tr>
                    </x-table.header>
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
                    <x-table.body>
                        @foreach ($data as $item)
                            @php
                                $total_bruto =
                                    $item->gaji->bruto +
                                    $item->kekuranganGaji->bruto +
                                    $item->tukin->bruto +
                                    $item->kekuranganTukin->bruto +
                                    $item->makan->bruto +
                                    $item->lembur->bruto;
                                $total_potongan =
                                    $item->gaji->potongan +
                                    $item->kekuranganGaji->potongan +
                                    $item->tukin->potongan +
                                    $item->kekuranganTukin->potongan +
                                    $item->makan->potongan +
                                    $item->lembur->potongan;
                                $total_netto =
                                    $item->gaji->netto +
                                    $item->kekuranganGaji->netto +
                                    $item->tukin->netto +
                                    $item->kekuranganTukin->netto +
                                    $item->makan->netto +
                                    $item->lembur->netto;
                            @endphp
                            <tr class="*:border">
                                <x-table.body.column-pin class="text-center">{{ $no++ }}</x-table.body.column-pin>
                                <x-table.body.column-pin>{{ $item->bulan }}</x-table.body.column-pin>
                                <x-table.body.column class="text-right">
                                    {{ number_format($item->gaji->bruto + $item->kekuranganGaji->bruto, 0, ',', '.') }}
                                </x-table.body.column>
                                <x-table.body.column class="text-right">
                                    {{ number_format($item->gaji->potongan + $item->kekuranganGaji->potongan, 0, ',', '.') }}
                                </x-table.body.column>
                                <x-table.body.column class="text-right">
                                    {{ number_format($item->gaji->netto + $item->kekuranganGaji->netto, 0, ',', '.') }}
                                </x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->makan->bruto, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->makan->potongan, 0, ',', '.') }}
                                </x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->makan->netto, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->lembur->bruto, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->lembur->potongan, 0, ',', '.') }}
                                </x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->lembur->netto, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column class="text-right">
                                    {{ number_format($item->tukin->bruto + $item->kekuranganTukin->bruto, 0, ',', '.') }}
                                </x-table.body.column>
                                <x-table.body.column class="text-right">
                                    {{ number_format($item->tukin->potongan + $item->kekuranganTukin->potongan, 0, ',', '.') }}
                                </x-table.body.column>
                                <x-table.body.column class="text-right">
                                    {{ number_format($item->tukin->netto + $item->kekuranganTukin->netto, 0, ',', '.') }}
                                </x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($total_bruto, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($total_potongan, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($total_netto, 0, ',', '.') }}</x-table.body.column>
                            </tr>
                            @php
                                $j1 += $item->gaji->bruto;
                                $j2 += $item->gaji->potongan;
                                $j3 += $item->gaji->netto;
                                $j4 += $item->kekuranganGaji->bruto;
                                $j5 += $item->kekuranganGaji->potongan;
                                $j6 += $item->kekuranganGaji->netto;
                                $j7 += $item->makan->bruto;
                                $j8 += $item->makan->potongan;
                                $j9 += $item->makan->netto;
                                $j10 += $item->lembur->bruto;
                                $j11 += $item->lembur->potongan;
                                $j12 += $item->lembur->netto;
                                $j13 += $item->tukin->bruto;
                                $j14 += $item->tukin->potongan;
                                $j15 += $item->tukin->netto;
                                $j16 += $item->kekuranganTukin->bruto;
                                $j17 += $item->kekuranganTukin->potongan;
                                $j18 += $item->kekuranganTukin->netto;
                                $j19 += $total_bruto;
                                $j20 += $total_potongan;
                                $j21 += $total_netto;
                            @endphp
                        @endforeach
                        <tr class="*:border">
                            <x-table.body.column-pin colspan="2" class="text-center">Jumlah</x-table.body.column-pin>
                            <x-table.body.column
                                class="text-right">{{ number_format($j1 + $j4, 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column
                                class="text-right">{{ number_format($j2 + $j5, 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column
                                class="text-right">{{ number_format($j3 + $j6, 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column
                                class="text-right">{{ number_format($j7, 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column
                                class="text-right">{{ number_format($j8, 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column
                                class="text-right">{{ number_format($j9, 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column
                                class="text-right">{{ number_format($j10, 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column
                                class="text-right">{{ number_format($j11, 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column
                                class="text-right">{{ number_format($j12, 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column
                                class="text-right">{{ number_format($j13 + $j16, 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column
                                class="text-right">{{ number_format($j14 + $j17, 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column
                                class="text-right">{{ number_format($j15 + $j18, 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column
                                class="text-right">{{ number_format($j19, 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column
                                class="text-right">{{ number_format($j20, 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column
                                class="text-right">{{ number_format($j21, 0, ',', '.') }}</x-table.body.column>
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
