@extends('layout.main')
@section('aside-menu')
    @include('spt.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 py-2 px-4">
            <div class="w-full flex gap-1 flex-wrap">
                @foreach ($tahun as $item)
                    <a href="{{ Request::url() }}?thn={{ $item->tahun }}"
                        class="btn btn-xs btn-outline btn-primary @if ($item->tahun === $thn) btn-active @endif">{{ $item->tahun }}</a>
                @endforeach
            </div>
            <div class="w-full flex gap-1 flex-wrap justify-between">
                <div>
                    <a href="/spt/create" class="btn btn-xs btn-secondary">
                        Tambah
                    </a>
                    <a href="/spt/import" class="btn btn-xs btn-secondary">
                        import
                    </a>
                </div>
                <div>
                    <form action="" method="get" autocomplete="off">
                        <div class="join">
                            <input type="text" name="nip"
                                class="input input-sm join-item input-bordered focus:outline-none" placeholder="NIP">
                            <input type="text" name="thn"
                                class="input input-sm join-item input-bordered focus:outline-none" placeholder="tahun">
                            <button class="btn btn-sm join-item btn-neutral" type="submit">Cari</button>
                        </div>
                    </form>
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
                            <x-table.header.column>NIP</x-table.header.column>
                            <x-table.header.column>NPWP</x-table.header.column>
                            <x-table.header.column>Gol.</x-table.header.column>
                            <x-table.header.column>Alamat</x-table.header.column>
                            <x-table.header.column>Kd. Kawin</x-table.header.column>
                            <x-table.header.column>Jabatan</x-table.header.column>
                            <x-table.header.column>Action</x-table.header.column>
                        </tr>
                    </x-table.header>
                    <tbody>
                        @foreach ($data as $item)
                            <tr class="*:border">
                                <x-table.body.column class="text-center">{{ $loop->iteration }}</x-table.body.column>
                                <x-table.body.column>{{ $item->nip }}</x-table.body.column>
                                <x-table.body.column>{{ $item->npwp }}</x-table.body.column>
                                <x-table.body.column class="text-center">{{ $item->nama_pangkat }}</x-table.body.column>
                                <x-table.body.column class="w-[200px]">{{ $item->alamat }}</x-table.body.column>
                                <x-table.body.column class="text-center">{{ $item->kdkawin }}</x-table.body.column>
                                <x-table.body.column>{{ $item->nama_jabatan }}</x-table.body.column>
                                <x-table.body.column>
                                    <div class="w-full h-full flex gap-1 justify-center">
                                        <form action="/spt/{{ $item->id }}" method="post"
                                            onsubmit="return confirm('Apakah Anda yakin akan menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <div class="btn-group">
                                                <button type="submit" class="btn btn-xs btn-error">Hapus</button>
                                            </div>
                                        </form>
                                        <a href="/spt/{{ $item->id }}/edit" class="btn btn-xs btn-primary">Ubah</a>
                                    </div>
                                </x-table.body.column>
                            </tr>
                        @endforeach
                    </tbody>
                </x-table>
            </div>
        </div>
        <div class="px-4 py-2">
            {{ $data->links() }}
        </div>
    </div>
@endsection
