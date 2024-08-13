@extends('layout.main')
@section('aside-menu')
    @include('data-payment.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex gap-2 flex-wrap py-2 px-4">
            <div class="w-full flex gap-1 flex-wrap">
                <a href="/data-payment/honorarium" class="btn btn-xs btn-primary">kembali</a>
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
                                <x-table.body.column class="text-center">{{ $loop->iteration }}</x-table.body.column>
                                <x-table.body.column>{{ $item->nama }}</x-table.body.column>
                                <x-table.body.column>{{ $item->nip }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->bruto, 2, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->pph, 2, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->bruto - $item->pph, 2, ',', '.') }}</x-table.body.column>
                                <x-table.body.column>
                                    <div class="w-full h-full flex gap-1 justify-center">
                                        <form action="/data-payment/honorarium/{{ $item->id }}/detail" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');"
                                                type="submit" class="btn btn-xs btn-error">tolak</button>
                                        </form>
                                        <a href="/data-payment/honorarium/{{ $item->id }}/upload-detail"
                                            data-toggle="tooltip" data-placement="bottom" title="Kirim"
                                            onclick="return confirm('Apakah Anda yakin akan mengirim data ini?');"
                                            class="btn btn-xs btn-primary">upload</a>
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
