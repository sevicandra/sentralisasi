@extends('layout.main')
@section('aside-menu')
    @include('belanja-51-pusat.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 py-2 px-4">
            <div class="w-full flex gap-1 flex-wrap justify-between">
                <div class="flex gap-1 flex-wrap">
                    <a href="/belanja-51-pusat/uang-makan/create" class="btn btn-xs btn-primary">Create</a>
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
                            <x-table.header.column>Nomor</x-table.header.column>
                            <x-table.header.column>Tanggal</x-table.header.column>
                            <x-table.header.column>Uraian</x-table.header.column>
                            <x-table.header.column>Penandatangan</x-table.header.column>
                            <x-table.header.column>NIP Penandatangan</x-table.header.column>
                            <x-table.header.column>Jabatan Penandatangan</x-table.header.column>
                            <x-table.header.column>Status</x-table.header.column>
                            <x-table.header.column>Action</x-table.header.column>
                        </tr>
                    </x-table.header>
                    <x-table.body>
                        @foreach ($data as $item)
                            <tr class="*:border">
                                <x-table.body.column class="text-center">{{ $loop->iteration }}</x-table.body.column>
                                <x-table.body.column class="whitespace-nowrap">{{ $item->nomor }}</x-table.body.column>
                                <x-table.body.column class="whitespace-nowrap">{{ $item->tanggal }}</x-table.body.column>
                                <x-table.body.column class="min-w-60">{{ $item->uraian }}</x-table.body.column>
                                <x-table.body.column class="whitespace-nowrap">{{ $item->nama }}</x-table.body.column>
                                <x-table.body.column>{{ $item->nip }}</x-table.body.column>
                                <x-table.body.column class="whitespace-nowrap">{{ $item->jabatan }}</x-table.body.column>
                                <x-table.body.column>
                                    <div
                                        class="badge badge-sm @switch($item->status)
                                        @case('proses')
                                            badge-warning
                                            @break
                                        @case('kirim')
                                            badge-info
                                            @break
                                        @case('rejected')
                                            badge-error
                                            @break
                                        @case('approved')
                                            badge-success
                                            @break
                                        @default
                                            
                                    @endswitch">
                                        {{ $item->status }}
                                    </div>
                                </x-table.body.column>
                                <x-table.body.column class="text-center">
                                    <div class="w-full h-full flex gap-1 justify-center">
                                        <a href="/belanja-51-pusat/uang-makan/arsip/{{ $item->id }}"
                                            class="btn btn-xs btn-primary">Detail</a>
                                        <a href="/belanja-51-pusat/uang-makan/arsip/{{ $item->id }}/history"
                                            class="btn btn-xs btn-primary">Riwayat</a>
                                        @if ($item->status == 'proses')
                                            <form action="/belanja-51-pusat/uang-makan/arsip/{{ $item->id }}/batal"
                                                method="post"
                                                onsubmit="return confirm('Apakah Anda yakin akan mengirim data ini?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-xs btn-error">Batal</button>
                                            </form>
                                        @endif
                                    </div>
                                </x-table.body.column>
                            </tr>
                        @endforeach
                    </x-table.body>
                </x-table>
            </div>
        </div>
        <div>
            {{ $data->links() }}
        </div>
    </div>
@endsection
