@extends('layout.main')
@section('aside-menu')
    @include('belanja-51-monitoring.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 py-2 px-4">
            <div class="w-full flex gap-1 flex-wrap justify-between">
                <div class="flex flex-col gap-1">
                    <div class="flex gap-1 flex-wrap">
                        @foreach ($tahun as $item)
                            <a href="{{ config('app.url') }}/belanja-51-monitoring/vertikal/uang-lembur/monitoring/{{ $item }}"
                                class="btn btn-xs btn-outline btn-primary @if ((!$thn && $item == date('Y')) || $item == $thn) btn-active @endif">{{ $item }}</a>
                        @endforeach
                    </div>
                    <div class="flex gap-1 flex-wrap">
                        @foreach ($bulan as $item)
                            <a href="{{ config('app.url') }}/belanja-51-monitoring/vertikal/uang-lembur/monitoring/{{ $thn }}/{{ $item }}"
                                class="btn btn-xs btn-outline btn-primary @if ((!$bln && $item == date('m')) || $item == $bln) btn-active @endif">{{ $item }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-rows-[auto_1fr] grid-cols-1 overflow-hidden px-4 pb-2">
            <div>
                <div>
                    @include('layout.flashmessage')
                </div>
            </div>
            <div class="overflow-x-auto overflow-y-auto h-full w-full">
                <x-table class="collapse">
                    <x-table.header>
                        <tr class="*:border-x *:text-center">
                            <x-table.header.column>No</x-table.header.column>
                            <x-table.header.column>Kode Satker</x-table.header.column>
                            <x-table.header.column>Nama Satker</x-table.header.column>
                            <x-table.header.column>Jumlah Permohonan</x-table.header.column>
                            <x-table.header.column>#</x-table.header.column>
                        </tr>
                    </x-table.header>
                    <x-table.body>
                        @foreach ($data as $item)
                            <tr class="*:border">
                                <x-table.body.column class="text-center">{{ $loop->iteration }}</x-table.body.column>
                                <x-table.body.column class="text-center">{{ $item->kdsatker }}</x-table.body.column>
                                <x-table.body.column class="text-center">{{ $item->nmsatker }}</x-table.body.column>
                                <x-table.body.column class="text-center">
                                    {{ number_format($item->permohonanUangLemburVertikal->count(), 0, ',', '.') }}
                                </x-table.body.column>
                                <x-table.body.column class="text-center">
                                    <a href="/belanja-51-monitoring/vertikal/uang-lembur/monitoring/{{ $thn }}/{{ $bln }}/{{ $item->kdsatker }}" class="btn btn-xs btn-primary">detail</a>
                                </x-table.body.column>
                            </tr>
                        @endforeach
                    </x-table.body>
                </x-table>
            </div>
        </div>
        <div class="px-4 py-2">

        </div>
    </div>
@endsection
