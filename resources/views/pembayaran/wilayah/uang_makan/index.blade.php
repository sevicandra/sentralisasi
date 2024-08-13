@extends('layout.main')
@section('aside-menu')
    @include('pembayaran.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 py-2 px-4">
            <div class="w-full flex gap-1 flex-wrap justify-between">
                <div class="flex gap-1 flex-wrap">
                    @foreach ($tahun as $item)
                        <a href="{{ config('app.url') }}/belanja-51/wilayah/uang-makan/{{ $item }}"
                            class="btn btn-xs btn-outline btn-primary @if ($item === $thn) btn-active @endif">{{ $item }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="w-full flex gap-1 flex-wrap justify-between">
                <div class="flex gap-1 flex-wrap">
                    @foreach ($bulan as $item)
                        <a href="{{ config('app.url') }}/belanja-51/wilayah/uang-makan/{{ $thn }}/{{ $item }}"
                            class="btn btn-xs btn-outline btn-primary @if ($item === $bln) btn-active @endif">{{ $item }}
                        </a>
                    @endforeach
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
                        <tr class="*:border-x">
                            <x-table.header.column class="text-center">No</x-table.header.column>
                            <x-table.header.column class="text-center">Kode</x-table.header.column>
                            <x-table.header.column class="text-center">Nama</x-table.header.column>
                            <x-table.header.column class="text-center">Berkas</x-table.header.column>
                            <x-table.header.column class="text-center">Jml Peg</x-table.header.column>
                            <x-table.header.column class="text-center">File</x-table.header.column>
                            <x-table.header.column class="text-center">Status</x-table.header.column>
                        </tr>
                    </x-table.header>
                    <x-table.body>
                        @foreach ($data as $item)
                            <tr class="*:border">
                                <x-table.body.column class="text-center">{{ $loop->iteration }}</x-table.body.column>
                                <x-table.body.column class="text-center">{{ $item->kdsatker }}</x-table.body.column>
                                <x-table.body.column>{{ $item->nmsatker }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-center">{{ $item->dokumenUangMakan($thn, $bln)->count() }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-center">{{ $item->dokumenUangMakan($thn, $bln)->sum('jmlpegawai') }}</x-table.body.column>
                                <x-table.body.column class="text-center">
                                    @if ($item->dokumenUangMakan($thn, $bln)->count() > 0)
                                        <a class="btn btn-xs btn-primary btn-outline"
                                            href="{{ config('app.url') }}/belanja-51/wilayah/uang-makan/{{ $item->kdsatker }}/{{ $thn }}/{{ $bln }}/detail">file</a>
                                    @endif
                                </x-table.body.column>
                                <x-table.body.column class="text-center">
                                    @if ($item->dokumenUangMakan($thn, $bln)->min('terkirim') === 1)
                                        <div class="badge badge-success">terkirim</div>
                                    @elseif($item->dokumenUangMakan($thn, $bln)->min('terkirim') === 0)
                                        <div class="badge badge-warning">draft</div>
                                    @else
                                    @endif
                                </x-table.body.column>
                            </tr>
                        @endforeach
                    </x-table.body>
                </x-table>
            </div>
        </div>
        <div>
            {{-- {{$data->links()}} --}}
        </div>
    </div>
@endsection
