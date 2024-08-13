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
                            placeholder="Kode atau Nama Satker">
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
                        <tr class="*:border-x *:text-center">
                            <x-table.header.column>No</x-table.header.column>
                            <x-table.header.column>Kode</x-table.header.column>
                            <x-table.header.column>Nama</x-table.header.column>
                            <x-table.header.column>Detail</x-table.header.column>
                        </tr>
                    </x-table.header>
                    <x-table.body>
                        @foreach ($data as $item)
                            <tr>
                                <x-table.body.column class="text-center">{{ $loop->iteration }}</x-table.body.column>
                                <x-table.body.column>{{ $item->kdsatker }}</x-table.body.column>
                                <x-table.body.column class="text-center">{{ $item->nmsatker }}</x-table.body.column>
                                <x-table.body.column class="text-center">
                                    <a href="/admin/ref-penandatangan/{{ $item->kdsatker }}" class="btn btn-xs btn-primary"
                                        target="_blank">Detail</a>
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
