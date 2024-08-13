@extends('layout.main')
@section('aside-menu')
    @include('pembayaran.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 py-2 px-4">
            <div class="w-full flex gap-1 flex-wrap justify-between">
                <a href="/belanja-51/wilayah/uang-lembur/{{ $thn }}/{{ $bln }}"
                    class="btn btn-xs btn-outline btn-primary">Kembali ke halaman sebelumnya</a>
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
                            <x-table.header.column class="text-center">Jml Pegawai</x-table.header.column>
                            <x-table.header.column class="text-center">Ket</x-table.header.column>
                            <x-table.header.column class="text-center">File</x-table.header.column>
                            <x-table.header.column class="text-center">#</x-table.header.column>
                            <x-table.header.column class="text-center">Tgl Upload</x-table.header.column>
                            <x-table.header.column class="text-center">Tgl Kirim</x-table.header.column>
                        </tr>
                    </x-table.header>
                    <x-table.body>
                        @foreach ($data as $item)
                            <tr class="*:border-x">
                                <x-table.body.column class="text-center">{{ $loop->iteration }}</x-table.body.column>
                                <x-table.body.column class="text-center">{{ $item->jmlpegawai }}</x-table.body.column>
                                <x-table.body.column>{{ $item->keterangan }}</x-table.body.column>
                                <x-table.body.column class="text-center">
                                    <div class="flex gap-1">
                                        <form action="/belanja-51/wilayah/uang-lembur/{{ $item->id }}/dokumen"
                                            method="post" target="_blank">
                                            @csrf
                                            @method('patch')
                                            <button class="btn btn-xs btn-primary">pdf</i></button>
                                        </form>
                                        <form action="/belanja-51/wilayah/uang-lembur/{{ $item->id }}/dokumen-excel"
                                            method="post" target="_blank">
                                            @csrf
                                            @method('patch')
                                            <button class="btn btn-xs btn-primary">excel</i></button>
                                        </form>
                                    </div>
                                </x-table.body.column>
                                <x-table.body.column class="text-center">
                                    @switch($item->terkirim)
                                        @case(0)
                                            <span class="badge badge-warning">draft</span>
                                        @break

                                        @case(1)
                                            <span class="badge badge-success">terkirim</span>
                                        @break

                                        @case(2)
                                            <span class="badge badge-primary">approve</span>
                                        @break

                                        @default
                                    @endswitch
                                </x-table.body.column>
                                <x-table.body.column class="text-center">{{ $item->created_at }}</x-table.body.column>
                                <x-table.body.column class="text-center">
                                    @if ($item->terkirim)
                                        {{ $item->updated_at }}
                                    @endif
                                </x-table.body.column>
                            </tr>
                        @endforeach
                    </x-table.body>
                </x-table>
            </div>
        </div>
        <div>
        </div>
    </div>
@endsection
