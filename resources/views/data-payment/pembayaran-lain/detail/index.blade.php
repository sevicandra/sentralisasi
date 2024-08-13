@extends('layout.main')
@section('aside-menu')
    @include('data-payment.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 flex-wrap py-2 px-4">
            <div class="w-full flex gap-1 flex-wrap">
                <a href="{{ config('app.url') }}/data-payment/lain" class="btn btn-xs btn-primary">Kembali</a>
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
                                <x-table.body.column>{{ $loop->iteration }}</x-table.body.column>
                                <x-table.body.column class="text-left">{{ $item->nama }}</x-table.body.column>
                                <x-table.body.column>{{ $item->nip }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->bruto, 2, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->pph, 2, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->bruto - $item->pph, 2, ',', '.') }}</x-table.body.column>
                                <x-table.body.column>
                                    <span class="w-full h-full flex gap-1 justify-center">
                                        <form action="/data-payment/lain/{{ $item->id }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');"
                                                type="submit" class="btn btn-xs btn-error">hapus</button>
                                        </form>
                                        <a href="/data-payment/lain/{{ $item->id }}/edit" data-toggle="tooltip"
                                            data-placement="bottom" title="Ubah" class="btn btn-xs btn-primary">ubah</a>
                                        <form action="/data-payment/lain/{{ $item->id }}" method="post">
                                            @csrf
                                            <button onclick="return confirm('Apakah Anda yakin akan mengirim data ini?');"
                                                class="btn btn-xs btn-success" type="submit">upload</button>
                                        </form>
                                    </span>
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
