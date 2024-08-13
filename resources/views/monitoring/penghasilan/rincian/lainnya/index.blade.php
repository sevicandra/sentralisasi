@extends('layout.main')
@section('aside-menu')
    @include('monitoring.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
            <div class="flex flex-col gap-2 flex-wrap py-2 px-4">
                <div class="w-full flex gap-1 flex-wrap">
                    @foreach ($tahun as $item)
                        <a href="{{ config('app.url') }}/monitoring/penghasilan/{{ $satker->kdsatker }}/{{ $nip }}/lainnya/{{ $item->tahun }}/{{ $jns }}"
                            class="btn btn-xs btn-primary btn-outline @if ((Request('thn') === null && $item->tahun === date('Y')) || $item->tahun === request('thn')) btn-active @endif">{{ $item->tahun }}</a>
                    @endforeach
                </div>
                <div class="w-full flex gap-1 flex-wrap">
                    @foreach ($jenis as $item)
                        <a href="{{ config('app.url') }}/monitoring/penghasilan/{{ $satker->kdsatker }}/{{ $nip }}/lainnya/{{ $thn }}/{{ $item->jenis }}"
                            class="btn btn-xs btn-primary btn-outline @if ($jns === $item->jenis) btn-active @endif">{{ $item->jenis }}</a>
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
                            <x-table.header.column-pin class="text-center">No</x-table.header.column-pin>
                            <x-table.header.column-pin class="text-center">Bulan</x-table.header.column-pin>
                            <x-table.header.column class="text-center">Bruto</x-table.header.column>
                            <x-table.header.column class="text-center">PPh</x-table.header.column>
                            <x-table.header.column class="text-center">Netto</x-table.header.column>
                            <x-table.header.column class="text-center">Keterangan</x-table.header.column>

                        </tr>
                    </x-table.header>
                    <x-table.body>
                        @foreach ($data as $item)
                            <tr class="*:border">
                                <x-table.body.column-pin
                                    class="text-center">{{ $loop->iteration }}</x-table.body.column-pin>
                                <x-table.body.column-pin>{{ $item->nama_bulan }}</x-table.body.column-pin>
                                <x-table.body.column
                                    class="text-right"><?= number_format($item->bruto, 0, ',', '.') ?></x-table.body.column>
                                <x-table.body.column
                                    class="text-right"><?= number_format($item->pph, 0, ',', '.') ?></x-table.body.column>
                                <x-table.body.column
                                    class="text-right"><?= number_format($item->netto, 0, ',', '.') ?></x-table.body.column>
                                <x-table.body.column class="max-w-xs"><?= $item->uraian ?></x-table.body.column>
                            </tr>
                        @endforeach
                        <tr class="*:border">
                            <x-table.body.column-pin :colspan="2" class="text-center">Jumlah</x-table.body.column-pin>
                            <x-table.body.column
                                class="text-right"><?= number_format($data->sum('bruto'), 0, ',', '.') ?></x-table.body.column>
                            <x-table.body.column
                                class="text-right"><?= number_format($data->sum('pph'), 0, ',', '.') ?></x-table.body.column>
                            <x-table.body.column
                                class="text-right"><?= number_format($data->sum('netto'), 0, ',', '.') ?></x-table.body.column>
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
