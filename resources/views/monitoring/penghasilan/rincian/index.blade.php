@extends('layout.main')
@section('aside-menu')
    @include('monitoring.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex gap-2 flex-wrap py-2 px-4">
            <div class="w-full max-w-xs">
                <select class="select select-sm select-bordered w-full max-w-xs"
                    onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                    @foreach ($status as $item)
                        <option
                            value="?status={{ $item }} @if (request('search')) &search={{ request('search') }} @endif"
                            @if (request('status') === $item) selected @endif>
                            {{ $item }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="w-full max-w-xs">
                <form action="" method="get">
                    @if (request('status'))
                        <input type="text" name="status" hidden value="{{ request('status') }}">
                    @endif
                    <div class="join w-full">
                        <input type="text" name="search"
                            class="input input-sm join-item w-full focus:outline-none input-bordered"
                            placeholder="Nama/NIP">
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
                            <x-table.header.column class="">NIP</x-table.header.column>
                            <x-table.header.column class="whitespace-nowrap">Nama</x-table.header.column>
                            <x-table.header.column-pin class="text-center">Detail</x-table.header.column-pin>
                        </tr>
                    </x-table.header>
                    <x-table.body>
                        @foreach ($data as $item)
                            <tr class="*:border">
                                <x-table.body.column-pin
                                    class="text-center">{{ $loop->iteration }}</x-table.body.column-pin>
                                <x-table.body.column class="">{{ $item->Nip18 }}</x-table.body.column>
                                <x-table.body.column class="whitespace-nowrap">{{ $item->Nama }}</x-table.body.column>
                                <x-table.body.column
                                    class="whitespace-nowrap bg-base-100 flex justify-center gap-1 flex-wrap min-w-md">
                                    <a href="{{ Request::url() }}/{{ $item->Nip18 }}/penghasilan"
                                        class="btn btn-xs btn-primary" target="_blank">Penghasilan</a>
                                    <a href="{{ Request::url() }}/{{ $item->Nip18 }}/gaji" class="btn btn-xs btn-primary"
                                        target="_blank" target="_blank">Gaji</a>
                                    <a href="{{ Request::url() }}/{{ $item->Nip18 }}/uang-makan"
                                        class="btn btn-xs btn-primary" target="_blank">Uang
                                        Makan</a>
                                    <a href="{{ Request::url() }}/{{ $item->Nip18 }}/uang-lembur"
                                        class="btn btn-xs btn-primary" target="_blank">Uang
                                        Lembur</a>
                                    <a href="{{ Request::url() }}/{{ $item->Nip18 }}/tunjangan-kinerja"
                                        class="btn btn-xs btn-primary" target="_blank">Tunjangan
                                        Kinerja</a>
                                    <a href="{{ Request::url() }}/{{ $item->Nip18 }}/lainnya"
                                        class="btn btn-xs btn-primary" target="_blank">Lainnya</a>
                                </x-table.body.column>
                            </tr>
                        @endforeach
                    </x-table.body>
                </x-table>
            </div>
        </div>
        <div class="py-2 px-4">
            {{ $data->links() }}
        </div>
    </div>
@endsection
