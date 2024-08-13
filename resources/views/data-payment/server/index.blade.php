@extends('layout.main')
@section('aside-menu')
    @include('data-payment.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex gap-2 flex-wrap py-2 px-4">
            <div class="flex justify-end w-full">
                <form action="" method="get" autocomplete="off">
                    <div class="join">
                        <input type="text" name="nip" class="input input-sm join-item input-bordered focus:outline-none"
                            placeholder="nip">
                        <input type="text" name="tahun"
                            class="input input-sm join-item input-bordered focus:outline-none" placeholder="tahun">
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
                            @canany(['adm_server'], auth()->user()->id)
                                <x-table.header.column>ID</x-table.header.column>
                            @endcan
                            <x-table.header.column>Bulan</x-table.header.column>
                            <x-table.header.column>Tahun</x-table.header.column>
                            <x-table.header.column>NIP</x-table.header.column>
                            <x-table.header.column>bruto</x-table.header.column>
                            <x-table.header.column>pph</x-table.header.column>
                            <x-table.header.column>netto</x-table.header.column>
                            <x-table.header.column>jenis</x-table.header.column>
                            <x-table.header.column>uraian</x-table.header.column>
                            <x-table.header.column>tanggal</x-table.header.column>
                            <x-table.header.column>nospm</x-table.header.column>
                            @canany(['adm_server'], auth()->user()->id)
                                <x-table.header.column>#</x-table.header.column>
                            @endcan
                        </tr>
                    </x-table.header>
                    <x-table.body>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($data as $item)
                            <tr class="*:border">
                                <x-table.body.column>{{ $i++ }}</x-table.body.column>
                                @canany(['adm_server'], auth()->user()->id)
                                    <x-table.body.column>{{ $item->id }}</x-table.body.column>
                                @endcan
                                <x-table.body.column>{{ $item->bulan }}</x-table.body.column>
                                <x-table.body.column>{{ $item->tahun }}</x-table.body.column>
                                <x-table.body.column>{{ $item->nip }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->bruto, 2, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->pph, 2, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->netto, 2, ',', '.') }}</x-table.body.column>
                                <x-table.body.column class="whitespace-nowrap">{{ $item->jenis }}</x-table.body.column>
                                <x-table.body.column class="min-w-80">{{ $item->uraian }}</x-table.body.column>
                                <x-table.body.column class="whitespace-nowrap">{{ date('d-m-Y', $item->tanggal) }}</x-table.body.column>
                                <x-table.body.column>{{ $item->nospm }}</x-table.body.column>
                                @canany(['adm_server'], auth()->user()->id)
                                    <x-table.body.column class="text-center">
                                        <span class="flex gap-2">
                                            <a href="/data-payment/server/{{ $item->id }}/edit"
                                                class="btn btn-xs btn-primary">Ubah</a>

                                            <form action="/data-payment/server/{{ $item->id }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');"
                                                    type="submit"
                                                    class="btn btn-xs btn-error">Hapus</button>
                                            </form>
                                        </span>
                                    </x-table.body.column>
                                @endcan
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
