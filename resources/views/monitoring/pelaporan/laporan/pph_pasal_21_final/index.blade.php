@extends('layout.main')
@section('aside-menu')
    @include('monitoring.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 flex-wrap py-2 px-4">
            <div class="w-full flex gap-1 flex-wrap">
                @foreach ($tahun as $item)
                    <a href="{{ config('app.url') }}/monitoring/pelaporan/pph-pasal-21-final/{{ $nip }}/{{ $item->tahun }}"
                        class="btn btn-xs btn-primary btn-outline @if ($thn === $item->tahun) btn-active @endif">{{ $item->tahun }}</a>
                @endforeach
            </div>
        </div>
        <div class="grid grid-rows-[auto_1fr] grid-cols-1 overflow-hidden px-4 pb-2">
            <div></div>
            <div class="overflow-x-auto overflow-y-auto h-full w-full max-w-2xl">
                <x-table class="collapse">
                    <x-table.header class="text-center">
                        <tr class="*:border-x">
                            <x-table.header.column class="text-center">No</x-table.header.column>
                            <x-table.header.column class="text-center">Jenis Pembayaran</x-table.header.column>
                            <x-table.header.column class="text-center">Jumlah Bruto</x-table.header.column>
                            <x-table.header.column class="text-center">PPh Final</x-table.header.column>
                        </tr>
                    </x-table.header>
                    <x-table.body>
                        <tr class="*:border">
                            <x-table.body.column>1</x-table.body.column>
                            <x-table.body.column>Uang Makan</x-table.body.column>
                            <x-table.body.column class="text-right">
                                {{ number_format($makan?->bruto ? $makan->bruto : 0, 0, ',', '.') }}
                            </x-table.body.column>
                            <x-table.body.column
                                class="text-right">{{ number_format($makan?->pph ? $makan->pph : 0, 0, ',', '.') }}
                            </x-table.body.column>
                        </tr>
                        <tr class="*:border">
                            <x-table.body.column>2</x-table.body.column>
                            <x-table.body.column>Uang Lembur</x-table.body.column>
                            <x-table.body.column class="text-right">
                                {{ number_format($lembur?->bruto ? $lembur->bruto : 0, 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column class="text-right">
                                {{ number_format($lembur?->pph ? $lembur->pph : 0, 0, ',', '.') }}
                            </x-table.body.column>
                        </tr>
                        @php
                            $no = 3;
                            $j1 = 0;
                            $j2 = 0;
                        @endphp
                        @foreach ($lain as $item)
                            <tr class="*:border">
                                <x-table.body.column>{{ $no++ }}</x-table.body.column>
                                <x-table.body.column>{{ $item->jenis }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->bruto, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->pph, 0, ',', '.') }}</x-table.body.column>
                            </tr>
                            @php
                                $j1 += $item->bruto;
                                $j2 += $item->pph;
                            @endphp
                        @endforeach
                        <tr class="*:border">
                            <x-table.body.column colspan="2">
                                <a href="{{ config('app.url') }}/monitoring/pelaporan/{{ $satker->kdsatker }}/pph-pasal-21-final/{{ $nip }}/{{ $thn }}/cetak"
                                    class="btn btn-xs btn-primary">Download Form 1721-VII</a>
                            </x-table.body.column>
                            <x-table.body.column class="text-right">
                                {{ number_format(($makan?->bruto ? $makan->bruto : 0) + ($lembur?->bruto ? $lembur->bruto : 0) + $j1, 0, ',', '.') }}
                            </x-table.body.column>
                            <x-table.body.column class="text-right">
                                {{ number_format(($makan?->pph ? $makan->pph : 0) + ($lembur?->pph ? $lembur->pph : 0) + $j2, 0, ',', '.') }}
                            </x-table.body.column>
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
