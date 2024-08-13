@extends('layout.main')
@section('aside-menu')
    @include('monitoring.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 flex-wrap py-2 px-4">
            <div class="flex flex-col gap-2 flex-wrap py-2 px-4">
                <div class="w-full flex gap-1 flex-wrap">
                    @foreach ($tahun as $item)
                        <a href="{{ config('app.url') }}/monitoring/rincian/{{ $satker->kdsatker }}/{{ $nip }}/uang-lembur/{{ $item->tahun }}"
                            class="btn btn-xs btn-outline btn-primary @if ((Request('thn') === null && $item->tahun === date('Y')) || $item->tahun === request('thn')) btn-active @endif">{{ $item->tahun }}</a>
                    @endforeach
                </div>
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
                            <x-table.header.column :colspan="3" class="text-center">Jumlah Jam
                                Lembur</x-table.header.column>
                            <x-table.header.column :colspan="3" class="text-center">Bruto</x-table.header.column>
                            <x-table.header.column class="text-center">Potongan</x-table.header.column>
                            <x-table.header.column :rowspan="2" class="text-center">Netto</x-table.header.column>
                            <x-table.header.column :rowspan="2" class="text-center">Keterangan Jam Lembur
                                (Tgl/Jam)</x-table.header.column>
                        </tr>
                        <tr class="*:border-x">
                            <x-table.header.column class="">Hari Kerja</x-table.header.column>
                            <x-table.header.column class="">Hari Libur</x-table.header.column>
                            <x-table.header.column class="">Hari Uang Makan</x-table.header.column>
                            <x-table.header.column class="">Uang Lembur</x-table.header.column>
                            <x-table.header.column class="">Uang Makan</x-table.header.column>
                            <x-table.header.column class="">Jumlah</x-table.header.column>
                            <x-table.header.column class="">PPh Psl 21 Final</x-table.header.column>
                        </tr>
                    </x-table.header>
                    <x-table.body>
                        @foreach ($data as $item)
                            <tr class="*:border">
                                <x-table.body.column-pin
                                    class="text-center">{{ $loop->iteration }}</x-table.body.column-pin>
                                <x-table.body.column-pin class="">{{ $item->nama_bulan }}</x-table.body.column-pin>
                                <x-table.body.column
                                    class="text-center">{{ number_format($item->jkerja, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-center">{{ number_format($item->jlibur, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-center">{{ number_format($item->jmakan, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->lembur, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->makan, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->bruto, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->pph, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->netto, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column class="text-muted text-sm">
                                    @for ($i = 1; $i < 32; $i++)
                                        @if ($item->{'jhari' . $i} > 1)
                                            {{ '(' . $i . '/' . $item->{'jhari' . $i} . '), ' }}
                                        @endif
                                    @endfor
                                </x-table.body.column>
                            </tr>
                        @endforeach
                        <tr class="*:border">
                            <x-table.body.column-pin :colspan="2" class="text-center">Jumlah</x-table.body.column-pin>
                            <x-table.body.column
                                class="text-center">{{ number_format($data->sum('jkerja'), 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column
                                class="text-center">{{ number_format($data->sum('jlibur'), 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column
                                class="text-center">{{ number_format($data->sum('jmakan'), 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column
                                class="text-right">{{ number_format($data->sum('lembur'), 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column
                                class="text-right">{{ number_format($data->sum('makan'), 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column
                                class="text-right">{{ number_format($data->sum('bruto'), 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column
                                class="text-right">{{ number_format($data->sum('pph'), 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column
                                class="text-right">{{ number_format($data->sum('netto'), 0, ',', '.') }}</x-table.body.column>
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
