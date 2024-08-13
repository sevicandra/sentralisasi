@extends('layout.main')
@section('aside-menu')
    @include('data-payment.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 flex-wrap py-2 px-4">
            <div class="w-full flex gap-1 flex-wrap">
                @foreach ($tahun as $item)
                    <a href="{{ config('app.url') }}/data-payment/lain?thn={{ $item->tahun }}"
                        class="btn btn-xs btn-outline btn-primary @if ((!$thn && $item->tahun === date('Y')) || $item->tahun === $thn) btn-active @endif">{{ $item->tahun }}</a>
                @endforeach
            </div>
            <div class="w-full flex gap-1 flex-wrap">
                @foreach ($bulan as $item)
                    <a href="{{ config('app.url') }}/data-payment/lain?thn={{ $thn }}&bln={{ $item->bulan }}"
                        class="btn btn-xs btn-outline btn-primary @if ((!$bln && $item->bulan === date('m')) || $item->bulan === $bln) btn-active @endif">{{ $item->bulan }}</a>
                @endforeach
            </div>
            <div class="w-full flex gap-1 flex-wrap justify-end">
                <a href="/data-payment/lain/create" class="btn btn-xs btn-primary">Tambah</a>
            </div>
        </div>
        <div class="grid grid-rows-[auto_1fr] grid-cols-1 overflow-hidden px-4 pb-2">
            <div></div>
            <div class="overflow-x-auto overflow-y-auto h-full w-full">
                <x-table class="collapse">
                    <x-table.header>
                        <tr class="*:border *:text-center">
                            <x-table.header.column>No</x-table.header.column>
                            <x-table.header.column>Satker</x-table.header.column>
                            <x-table.header.column>jenis</x-table.header.column>
                            <x-table.header.column>Jml Pegawai</x-table.header.column>
                            <x-table.header.column>Bruto</x-table.header.column>
                            <x-table.header.column>PPh</x-table.header.column>
                            <x-table.header.column>Netto</x-table.header.column>
                            <x-table.header.column>#</x-table.header.column>
                        </tr>
                    </x-table.header>
                    <x-table.body>
                        @foreach ($data as $item)
                            <tr class="*:border">
                                <x-table.body.column>{{ $loop->iteration }}</x-table.body.column>
                                <x-table.body.column>{{ $item->nmsatker }}</x-table.body.column>
                                <x-table.body.column>{{ $item->jenis }}</x-table.body.column>
                                <x-table.body.column>{{ $item->jml }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->bruto, 2, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->pph, 2, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->bruto - $item->pph, 2, ',', '.') }}
                                </x-table.body.column>
                                <x-table.body.column>
                                    <div class="w-full h-full flex gap-1 justify-center">
                                        <form
                                            action="/data-payment/lain/{{ $item->kdsatker }}/{{ $item->jenis }}/{{ $thn }}/{{ $bln }}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');"
                                                type="submit"
                                                class="btn btn-xs btn-error">hapus</button>
                                        </form>
                                        <a href="/data-payment/lain/{{ $item->kdsatker }}/{{ $item->jenis }}/{{ $thn }}/{{ $bln }}/detail"
                                            class="btn btn-xs btn-primary">detail</a>
                                        <form
                                            action="/data-payment/lain/{{ $item->kdsatker }}/{{ $item->jenis }}/{{ $thn }}/{{ $bln }}"
                                            method="post">
                                            @csrf
                                            <button type="submit"
                                                onclick="return confirm('Apakah Anda yakin akan mengirim data ini?');"
                                                class="btn btn-xs btn-success">upload</button>
                                        </form>
                                    </div>
                                </x-table.body.column>
                            </tr>
                        @endforeach
                    </x-table.body>
                </x-table>
            </div>
        </div>
        <div>
            {{-- {{$data->links()}} --}}
        </div>
    </div>
@endsection
