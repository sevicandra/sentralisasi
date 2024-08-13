@extends('layout.main')
@section('aside-menu')
    @include('monitoring.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 flex-wrap py-2 px-4">
            <div class="w-full flex gap-1 flex-wrap">
                @foreach ($tahun as $item)
                    <a href="{{ config('app.url') }}/monitoring/penghasilan/{{ $satker->kdsatker }}/{{ $nip }}/gaji/{{ $item->tahun }}/{{ $jns }}"
                        class="btn btn-xs btn-primary btn-outline @if ((Request('thn') === null && $item->tahun === date('Y')) || $item->tahun === request('thn')) btn-active @endif">{{ $item->tahun }}</a>
                @endforeach
            </div>
            <div class="w-full flex gap-1 flex-wrap">
                <a href="{{ config('app.url') }}/monitoring/penghasilan/{{ $satker->kdsatker }}/{{ $nip }}/gaji/{{ $thn }}/rutin"
                    class="btn btn-xs btn-outline btn-primary @if ($jns === 'rutin' || $jns === null) btn-active @endif">Rutin</a>
                <a href="{{ config('app.url') }}/monitoring/penghasilan/{{ $satker->kdsatker }}/{{ $nip }}/gaji/{{ $thn }}/kekurangan"
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
                            <x-table.header.column :colspan="10" class="text-center">Bruto</x-table.header.column>
                            <x-table.header.column :colspan="8" class="text-center">Potongan</x-table.header.column>
                            <x-table.header.column :rowspan="2" class="text-center">Netto</x-table.header.column>
                        </tr>
                        <tr class="*:border-x">
                            <x-table.header.column class="text-center">Gapok</x-table.header.column>
                            <x-table.header.column class="text-center">Istri</x-table.header.column>
                            <x-table.header.column class="text-center">Anak</x-table.header.column>
                            <x-table.header.column class="text-center">Umum</x-table.header.column>
                            <x-table.header.column class="text-center">Str/Fng</x-table.header.column>
                            <x-table.header.column class="text-center">Bulat</x-table.header.column>
                            <x-table.header.column class="text-center">Beras</x-table.header.column>
                            <x-table.header.column class="text-center">Pajak</x-table.header.column>
                            <x-table.header.column class="text-center">Lain2</x-table.header.column>
                            <x-table.header.column class="text-center">Jumlah</x-table.header.column>
                            <x-table.header.column class="text-center">IWP</x-table.header.column>
                            <x-table.header.column class="text-center">PPh</x-table.header.column>
                            <x-table.header.column class="text-center">Rumdin</x-table.header.column>
                            <x-table.header.column class="text-center">Lain2</x-table.header.column>
                            <x-table.header.column class="text-center">Taperum</x-table.header.column>
                            <x-table.header.column class="text-center">BPJS</x-table.header.column>
                            <x-table.header.column class="text-center">BPJS Kel. Lainnya</x-table.header.column>
                            <x-table.header.column class="text-center">Jumlah</x-table.header.column>
                        </tr>
                    </x-table.header>
                    <x-table.body>
                        @foreach ($data as $item)
                            <tr class="*:border">
                                <x-table.body.column-pin
                                    class="text-center">{{ $loop->iteration }}</x-table.body.column-pin>
                                <x-table.body.column-pin class="">{{ $item->nama_bulan }}</x-table.body.column-pin>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->gapok, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->tistri, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->tanak, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->tumum + $item->ttambumum, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->tstruktur + $item->tfungsi, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->bulat, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->tberas, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->tpajak, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column class="text-right">
                                    {{ number_format($item->tpapua + $item->tpencil + $item->tlain, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column class="text-right">
                                    {{ number_format($item->gapok + $item->tistri + $item->tanak + $item->tumum + $item->ttambumum + $item->tstruktur + $item->tfungsi + $item->bulat + $item->tberas + $item->tpajak + $item->tpapua + $item->tpencil + $item->tlain, 0, ',', '.') }}
                                </x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->iwp, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->pph, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->sewarmh, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column class="text-right">
                                    {{ number_format($item->pberas + $item->tunggakan + $item->utanglebih + $item->potlain, 0, ',', '.') }}
                                </x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->taperum, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->bpjs, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->bpjs2, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column class="text-right">
                                    {{ number_format($item->iwp + $item->pph + $item->sewarmh + $item->pberas + $item->tunggakan + $item->utanglebih + $item->potlain + $item->taperum + $item->bpjs + $item->bpjs2, 0, ',', '.') }}
                                </x-table.body.column>
                                <x-table.body.column class="text-right">
                                    {{ number_format($item->gapok + $item->tistri + $item->tanak + $item->tumum + $item->ttambumum + $item->tstruktur + $item->tfungsi + $item->bulat + $item->tberas + $item->tpajak + $item->tpapua + $item->tpencil + $item->tlain - ($item->iwp + $item->pph + $item->sewarmh + $item->pberas + $item->tunggakan + $item->utanglebih + $item->potlain + $item->taperum + $item->bpjs + $item->bpjs2), 0, ',', '.') }}
                                </x-table.body.column>
                            </tr>
                        @endforeach
                        <tr class="*:border">
                            <x-table.header.column-pin :colspan="2"
                                class="text-center">Jumlah</x-table.header.column-pin>
                            <x-table.header.column
                                class="text-right">{{ number_format($data->sum('gapok'), 0, ',', '.') }}</x-table.header.column>
                            <x-table.header.column
                                class="text-right">{{ number_format($data->sum('tistri'), 0, ',', '.') }}</x-table.header.column>
                            <x-table.header.column
                                class="text-right">{{ number_format($data->sum('tanak'), 0, ',', '.') }}</x-table.header.column>
                            <x-table.header.column class="text-right">
                                {{ number_format($data->sum('tumum') + $data->sum('ttambumum'), 0, ',', '.') }}</x-table.header.column>
                            <x-table.header.column class="text-right">
                                {{ number_format($data->sum('tstruktur') + $data->sum('tfungsi'), 0, ',', '.') }}</x-table.header.column>
                            <x-table.header.column
                                class="text-right">{{ number_format($data->sum('bulat'), 0, ',', '.') }}</x-table.header.column>
                            <x-table.header.column
                                class="text-right">{{ number_format($data->sum('tberas'), 0, ',', '.') }}</x-table.header.column>
                            <x-table.header.column
                                class="text-right">{{ number_format($data->sum('tpajak'), 0, ',', '.') }}</x-table.header.column>
                            <x-table.header.column class="text-right">
                                {{ number_format($data->sum('tpapua') + $data->sum('tpencil') + $data->sum('tlain'), 0, ',', '.') }}
                            </x-table.header.column>
                            <x-table.header.column class="text-right">
                                {{ number_format($data->sum('gapok') + $data->sum('tistri') + $data->sum('tanak') + $data->sum('tumum') + $data->sum('ttambumum') + $data->sum('tstruktur') + $data->sum('tfungsi') + $data->sum('bulat') + $data->sum('tberas') + $data->sum('tpajak') + $data->sum('tpapua') + $data->sum('tpencil') + $data->sum('tlain'), 0, ',', '.') }}
                            </x-table.header.column>
                            <x-table.header.column
                                class="text-right">{{ number_format($data->sum('iwp'), 0, ',', '.') }}</x-table.header.column>
                            <x-table.header.column
                                class="text-right">{{ number_format($data->sum('pph'), 0, ',', '.') }}</x-table.header.column>
                            <x-table.header.column
                                class="text-right">{{ number_format($data->sum('sewarmh'), 0, ',', '.') }}</x-table.header.column>
                            <x-table.header.column class="text-right">
                                {{ number_format($data->sum('pberas') + $data->sum('tunggakan') + $data->sum('utanglebih') + $data->sum('potlain'), 0, ',', '.') }}
                            </x-table.header.column>
                            <x-table.header.column
                                class="text-right">{{ number_format($data->sum('taperum'), 0, ',', '.') }}</x-table.header.column>
                            <x-table.header.column
                                class="text-right">{{ number_format($data->sum('bpjs'), 0, ',', '.') }}</x-table.header.column>
                            <x-table.header.column
                                class="text-right">{{ number_format($data->sum('bpjs2'), 0, ',', '.') }}</x-table.header.column>
                            <x-table.header.column class="text-right">
                                {{ number_format($data->sum('iwp') + $data->sum('pph') + $data->sum('sewarmh') + $data->sum('pberas') + $data->sum('tunggakan') + $data->sum('utanglebih') + $data->sum('potlain') + $data->sum('taperum') + $data->sum('bpjs') + $data->sum('bpjs2'), 0, ',', '.') }}
                            </x-table.header.column>
                            <x-table.header.column class="text-right">
                                {{ number_format($data->sum('gapok') + $data->sum('tistri') + $data->sum('tanak') + $data->sum('tumum') + $data->sum('ttambumum') + $data->sum('tstruktur') + $data->sum('tfungsi') + $data->sum('bulat') + $data->sum('tberas') + $data->sum('tpajak') + $data->sum('tpapua') + $data->sum('tpencil') + $data->sum('tlain') - ($data->sum('iwp') + $data->sum('pph') + $data->sum('sewarmh') + $data->sum('pberas') + $data->sum('tunggakan') + $data->sum('utanglebih') + $data->sum('potlain') + $data->sum('taperum') + $data->sum('bpjs') + $data->sum('bpjs2')), 0, ',', '.') }}
                            </x-table.header.column>
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
