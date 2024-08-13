@extends('layout.main')
@section('aside-menu')
    @include('honorarium.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 py-2 px-4">
            <div class="w-full flex gap-1 flex-wrap">
                <a href="/honorarium" class="btn btn-xs btn-primary">kembali</a>
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
                    <x-table.header class="text-center">
                        <tr class="*:border-x *:text-center">
                            <x-table.header.column>No.</x-table.header.column>
                            <x-table.header.column>Nama</x-table.header.column>
                            <x-table.header.column>NIP</x-table.header.column>
                            <x-table.header.column>Bruto</x-table.header.column>
                            <x-table.header.column>PPh</x-table.header.column>
                            <x-table.header.column>Netto</x-table.header.column>
                            <x-table.header.column>Aksi</x-table.header.column>
                        </tr>
                    </x-table.header>
                    <x-table.body>
                        @foreach ($data as $item)
                            <tr class="*:border">
                                <x-table.body.column class="text-center">{{ $loop->iteration }}</x-table.body.column>
                                <x-table.body.column class="text-left">{{ $item->nama }}</x-table.body.column>
                                <x-table.body.column>{{ $item->nip }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->bruto, 2, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->pph, 2, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->bruto - $item->pph, 2, ',', '.') }}</x-table.body.column>
                                <x-table.body.column>
                                    <div class="flex gap-1 w-full h-full justify-center">
                                        @if ($item->sts === '0')
                                            <form action="/honorarium/hapus-detail/{{ $item->id }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');"
                                                    type="submit" class="btn btn-xs btn-error">hapus</button>
                                            </form>
                                            <a href="/honorarium/edit-detail/{{ $item->id }}" data-toggle="tooltip"
                                                data-placement="bottom" title="Ubah"
                                                class="btn btn-xs btn-primary">ubah</a>
                                            <a href="/honorarium/kirim-detail/{{ $item->id }}" data-toggle="tooltip"
                                                data-placement="bottom" title="Kirim"
                                                onclick="return confirm('Apakah Anda yakin akan mengirim data ini?');"
                                                class="btn btn-xs btn-success">kirim</a>
                                        @endif
                                    </div>
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
