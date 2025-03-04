@extends('layout.main')
@section('aside-menu')
    @include('admin.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 flex-wrap py-2 px-4">
            <div class="w-full flex gap-1 flex-wrap">
                <a href="/admin/user" class="btn btn-xs btn-secondary">kembali</a>
                <a href="/admin/user/{{ $data->nip }}/role/create" class="btn btn-xs btn-primary">Tambah</a>
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
                            <x-table.header.column>Role</x-table.header.column>
                            <x-table.header.column>Aksi</x-table.header.column>
                        </tr>
                    </x-table.header>
                    <x-table.body.column>
                        @foreach ($role as $item)
                            <tr class="*:border">
                                <x-table.body.column class="text-center"> {{ $loop->iteration }} </x-table.body.column>
                                <x-table.body.column> {{ $item->role }} </x-table.body.column>
                                <x-table.body.column class="text-center">
                                    <form action="/admin/user/{{ $data->nip }}/role/{{ $item->id }}" method="post"
                                        onsubmit="return confirm('Apakah Anda yakin akan Menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-error">Hapus</button>
                                    </form>
                                </x-table.body.column>
                            </tr>
                        @endforeach
                    </x-table.body.column>
                </x-table>
            </div>
        </div>
        <div id="paginator">
            {{-- {{$data->links()}} --}}
        </div>
    </div>
@endsection
