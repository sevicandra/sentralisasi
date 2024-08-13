@extends('layout.main')
@section('aside-menu')
    @include('monitoring.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex gap-2 flex-wrap py-2 px-4">
            <div class="w-full max-w-xs">
                <form action="" method="get">
                    <div class="join w-full">
                        <input type="text" name="search"
                            class="input input-sm join-item w-full focus:outline-none input-bordered"
                            placeholder="Kode atau Nama Satker">
                        <button class="btn btn-sm border border-neutral-content btn-neutral-content join-item"
                            type="submit">Cari</button>
                    </div>
                </form>
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
                            <x-table.header.column-pin class="text-center">No</x-table.header.column-pin>
                            <x-table.header.column class="text-center">Kode Satker</x-table.header.column>
                            <x-table.header.column class="text-center">Nama</x-table.header.column>
                            <x-table.header.column-pin class="text-center">Detail</x-table.header.column-pin>
                        </tr>
                    </x-table.header>
                    <x-table.body>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($data as $item)
                            <tr class="*:border">
                                <x-table.body.column-pin class="text-center">{{ $no++ }}</x-table.body.column-pin>
                                <x-table.body.column class="text-center">{{ $item->kdsatker }}</x-table.body.column>
                                <x-table.body.column>{{ $item->nmsatker }}</x-table.body.column>
                                <x-table.body.column-pin class="flex items-center justify-center">
                                    <a href="/monitoring/pelaporan/{{ $item->kdsatker }}"
                                        class="btn btn-xs btn-primary pt-0 pb-0" target="_blank">Pegawai</a>
                                </x-table.body.column-pin>
                            </tr>
                        @endforeach
                    </x-table.body>
                </x-table>
            </div>
        </div>
        <div class="px-4 py-2">
            {{ $data->links() }}
        </div>
    </div>
@endsection
