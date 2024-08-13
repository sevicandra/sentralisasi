@extends('layout.main')
@section('aside-menu')
    @include('monitoring.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 flex-wrap py-2 px-4">
            <div class="w-full flex gap-1 flex-wrap">
                @foreach ($tahun as $item)
                    <a href="{{ config('app.url') }}/monitoring/penghasilan/{{ $satker->kdsatker }}/{{ $nip }}/penghasilan/{{ $item->tahun }}"
                        class="btn btn-xs btn-primary btn-outline @if ((Request('thn') === null && $item->tahun === date('Y')) || $item->tahun === request('thn')) btn-active @endif">{{ $item->tahun }}</a>
                @endforeach
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
                            <x-table.header.column class="text-center">Gaji</x-table.header.column>
                            <x-table.header.column class="text-center">Uang Makan</x-table.header.column>
                            <x-table.header.column class="text-center">Uang Lembur</x-table.header.column>
                            <x-table.header.column class="text-center">Tunjangan Kinerja</x-table.header.column>
                            <x-table.header.column class="text-center">Total</x-table.header.column>
                        </tr>
                    </x-table.header>
                    <x-table.body>
                        @foreach ($data as $item)
                            <tr class="*:border">
                                <x-table.body.column-pin
                                    class="text-center">{{ $loop->iteration }}</x-table.body.column-pin>
                                <x-table.body.column-pin>{{ $item->bulan }}</x-table.body.column-pin>
                                <x-table.body.column class="text-right">
                                    {{ number_format($item->gaji->netto + $item->kekuranganGaji->netto, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->makan->netto, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->lembur->netto, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column class="text-right">
                                    {{ number_format($item->tukin->netto + $item->kekuranganTukin->netto, 0, ',', '.') }}
                                </x-table.body.column>
                                <x-table.body.column class="text-right">
                                    {{ number_format($item->gaji->netto + $item->kekuranganGaji->netto + $item->makan->netto + $item->lembur->netto + $item->tukin->netto + $item->kekuranganTukin->netto, 0, ',', '.') }}
                                </x-table.body.column>
                            </tr>
                        @endforeach
                        <tr class="*:border">
                            <x-table.body.column-pin colspan="2" class="text-center">Jumlah</x-table.body.column-pin>
                            <x-table.body.column class="text-right">
                                {{ number_format($data->sum('gaji.netto') + $data->sum('kekuranganGaji.netto'), 0, ',', '.') }}
                            </x-table.body.column>
                            <x-table.body.column
                                class="text-right">{{ number_format($data->sum('makan.netto'), 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column
                                class="text-right">{{ number_format($data->sum('lembur.netto'), 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column class="text-right">
                                {{ number_format($data->sum('tukin.netto') + $data->sum('kekuranganTukin.netto'), 0, ',', '.') }}
                            </x-table.body.column>
                            <x-table.body.column class="text-right">
                                {{ number_format($data->sum('gaji.netto') + $data->sum('kekuranganGaji.netto') + $data->sum('makan.netto') + $data->sum('lembur.netto') + $data->sum('tukin.netto') + $data->sum('kekuranganTukin.netto'), 0, ',', '.') }}
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
