@extends('layout.main')
@section('aside-menu')
    @include('admin.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 flex-wrap py-2 px-4">
            <div class="w-full flex gap-1 flex-wrap">
                <a href="/admin/admin-satker/create" class="btn btn-xs btn-primary">Tambah</a>
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
                            <x-table.header.column>Kode Unit</x-table.header.column>
                            <x-table.header.column>Nama Jabatan</x-table.header.column>
                            <x-table.header.column>Aksi</x-table.header.column>
                        </tr>
                    </x-table.header>
                    <x-table.body>
                        @foreach ($data as $item)
                            <tr>
                                <x-table.body.column class="text-center">{{ $loop->iteration }}</x-table.body.column>
                                <x-table.body.column> {{ $item->nmsatker }} </x-table.body.column>
                                <x-table.body.column> {{ $item->kdunit }} </x-table.body.column>
                                <x-table.body.column> {{ $item->nmjabatan }} </x-table.body.column>
                                <x-table.body.column class="text-center">
                                    <div class="w-full h-full flex gap-1 flex-wrap justify-center">
                                        <a href="/admin/admin-satker/{{ $item->id }}/edit"
                                            class="btn btn-xs btn-primary">Ubah</a>
                                        <form action="/admin/admin-satker/{{ $item->id }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Apakah Anda yakin akan Menghapus data ini?');"
                                                class="btn btn-xs btn-error">Hapus</button>
                                        </form>
                                    </div>
                                </x-table.body.column>
                            </tr>
                        @endforeach
                    </x-table.body>
                </x-table>
            </div>
        </div>
        <div id="paginator">
            {{-- {{$data->links()}} --}}
        </div>
    </div>
@endsection
