@extends('layout.main')
@section('aside-menu')
    @include('admin.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 flex-wrap py-2 px-4">
            <div class="flex justify-end w-full">
                <form action="" method="get">
                    <div class="join">
                        <input type="text" name="search" class="input input-sm join-item input-bordered focus:outline-none"
                            placeholder="" value="{{ request('search') }}">
                        <button class="btn btn-sm join-item btn-neutral" type="submit">Cari</button>
                    </div>
                </form>
            </div>
            <div class="w-full flex gap-1 flex-wrap">
                <a href="/admin/ref-kop/create" class="btn btn-xs btn-primary">Tambah</a>
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
                            <x-table.header.column>Satker</x-table.header.column>
                            <x-table.header.column class="min-w-64">Unit</x-table.header.column>
                            <x-table.header.column class="min-w-64">Eselon 1</x-table.header.column>
                            <x-table.header.column class="min-w-64">Eselon 2</x-table.header.column>
                            <x-table.header.column class="min-w-64">Eselon 3</x-table.header.column>
                            <x-table.header.column class="min-w-80">alamat</x-table.header.column>
                            <x-table.header.column>#</x-table.header.column>
                        </tr>
                    </x-table.header>
                    <x-table.body>
                        @foreach ($data as $item)
                            <tr class="*:border">
                                <x-table.body.column class="text-center">{{ $loop->iteration }}</x-table.body.column>
                                <x-table.body.column class="whitespace-nowrap"> {{ $item->nmsatker }} </x-table.body.column>
                                <x-table.body.column> {{ $item->nmunit }} </x-table.body.column>
                                <x-table.body.column> {{ $item->eselon1 }} </x-table.body.column>
                                <x-table.body.column> {{ $item->eselon2 }} </x-table.body.column>
                                <x-table.body.column> {{ $item->eselon3 }} </x-table.body.column>
                                <x-table.body.column> {{ $item->alamat }} </x-table.body.column>
                                <x-table.body.column class="text-center">
                                    <div class="w-full h-full flex gap-1 justify-center">
                                        <a href="/admin/ref-kop/{{ $item->id }}/edit"
                                            class="btn btn-xs btn-primary">Ubah</a>
                                        <form action="/admin/ref-kop/{{ $item->id }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Apakah Anda yakin akan Menghapus data ini?');"
                                                type="submit" class="btn btn-xs btn-error">Hapus</button>
                                        </form>
                                    </div>
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
