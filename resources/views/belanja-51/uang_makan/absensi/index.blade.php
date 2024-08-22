@extends('layout.main')
@section('aside-menu')
    @include('belanja-51.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 py-2 px-4">
            <div class="w-full flex gap-1 flex-wrap justify-between">
                <div class="flex flex-col gap-1">
                    <div class="flex gap-1 flex-wrap">
                        @foreach ($tahun as $item)
                            <a href="{{ config('app.url') }}/belanja-51-vertikal/uang-makan/absensi/{{ $item }}"
                                class="btn btn-xs btn-outline btn-primary @if ((!$thn && $item == date('Y')) || $item == $thn) btn-active @endif">{{ $item }}</a>
                        @endforeach
                    </div>
                    <div class="flex gap-1 flex-wrap">
                        @foreach ($bulan as $item)
                            <a href="{{ config('app.url') }}/belanja-51-vertikal/uang-makan/absensi/{{ $thn }}/{{ $item }}"
                                class="btn btn-xs btn-outline btn-primary @if ((!$bln && $item == date('m')) || $item == $bln) btn-active @endif">{{ $item }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="/belanja-51-vertikal/uang-makan/absensi/create" class="btn btn-xs btn-primary">Import</a>
                </div>
            </div>
            <div class="w-full flex gap-1 flex-wrap justify-end">
                <form action="">
                    <div class="join">
                        <input type="text" name="search"
                            class="input input-sm join-item input-bordered focus:outline-none" placeholder="NIP/Name">
                        <button class="btn btn-sm join-item btn-neutral" type="submit">Cari</button>
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
                            <x-table.header.column class="text-center">No</x-table.header.column>
                            <x-table.header.column class="text-center">NIP</x-table.header.column>
                            <x-table.header.column class="text-center">Nama</x-table.header.column>
                            <x-table.header.column class="text-center">Jumlah Hari</x-table.header.column>
                            <x-table.header.column class="text-center">#</x-table.header.column>
                        </tr>
                    </x-table.header>
                    <x-table.body>
                        @foreach ($data as $item)
                            <tr class="*:border">
                                <x-table.body.column class="text-center">{{ $loop->iteration }}</x-table.body.column>
                                <x-table.body.column class="">{{ $item->nip }}</x-table.body.column>
                                <x-table.body.column class="">{{ $item->nama }}</x-table.body.column>
                                <x-table.body.column class="text-center">{{ $item->jml }}</x-table.body.column>
                                <x-table.body.column class="text-center">
                                    <a href="/belanja-51-vertikal/uang-makan/absensi/{{ $thn }}/{{ $bln }}/{{ $item->nip }}"
                                        class="btn btn-xs btn-primary">detail</a>
                                </x-table.body.column>
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
