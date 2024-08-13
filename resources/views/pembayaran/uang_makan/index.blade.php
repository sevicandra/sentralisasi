@extends('layout.main')
@section('aside-menu')
    @include('pembayaran.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 py-2 px-4">
            <div class="w-full flex gap-1 flex-wrap justify-between">
                <div class="flex gap-1 flex-wrap">
                    @foreach ($tahun as $item)
                        <a href="{{ config('app.url') }}/belanja-51/uang-makan/index/{{ $item }}"
                            class="btn btn-xs btn-outline btn-primary @if ((!$thn && $item === date('Y')) || $item === $thn) btn-active @endif">{{ $item }}</a>
                    @endforeach
                </div>
                <div class="flex">
                    <a href="/belanja-51/uang-makan/create" class="btn btn-xs btn-primary">Tambah</a>
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
                        <tr class="*:border-x">
                            <x-table.header.column class="text-center">No</x-table.header.column>
                            <x-table.header.column class="text-center">Bulan</x-table.header.column>
                            <x-table.header.column class="text-center">Jml Pegawai</x-table.header.column>
                            <x-table.header.column class="text-center">Keterangan</x-table.header.column>
                            <x-table.header.column class="text-center">File</x-table.header.column>
                            <x-table.header.column class="text-center">#</x-table.header.column>
                        </tr>
                    </x-table.header>
                    <x-table.body>
                        @foreach ($data as $item)
                            <tr class="*:border">
                                <x-table.body.column class="text-center">{{ $loop->iteration }}</x-table.body.column>
                                <x-table.body.column class="text-center">{{ $item->nmbulan }}</x-table.body.column>
                                <x-table.body.column class="text-center">{{ $item->jmlpegawai }}</x-table.body.column>
                                <x-table.body.column >{{ $item->keterangan }}</x-table.body.column>
                                <x-table.body.column>
                                    <div class="flex gap-1 w-full h-full justify-center">
                                        <div>
                                            <form action="/belanja-51/uang-makan/{{ $item->id }}/dokumen" method="post"
                                                target="_blank">
                                                @csrf
                                                @method('patch')
                                                <button class="btn btn-xs btn-outline btn-primary">pdf</button>
                                            </form>
                                        </div>
                                        <div>
                                            <form action="/belanja-51/uang-makan/{{ $item->id }}/dokumen-excel"
                                                method="post" target="_blank">
                                                @csrf
                                                @method('patch')
                                                <button class="btn btn-xs btn-outline btn-primary">Xlsx</button>
                                            </form>
                                        </div>
                                    </div>
                                </x-table.body.column>
                                <x-table.body.column>
                                    @if ($item->terkirim)
                                    <div class="flex gap-1 w-full h-full justify-center">
                                        <div class="badge badge-success">
                                            terkirim
                                        </div>
                                    </div>
                                    @else
                                        <div class="flex gap-1 w-full h-full justify-center">
                                            <a href="/belanja-51/uang-makan/{{ $item->id }}/edit" data-toggle="tooltip"
                                                data-placement="bottom" title="Ubah"
                                                class="btn btn-xs btn-primary">ubah</a>
                                            <form action="/belanja-51/uang-makan/{{ $item->id }}/delete"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');"
                                                    type="submit" class="btn btn-xs btn-error">hapus</button>
                                            </form>
                                            <a href="/belanja-51/uang-makan/{{ $item->id }}/kirim"
                                                data-toggle="tooltip" data-placement="bottom" title="Kirim"
                                                onclick="return confirm('Apakah Anda yakin akan mengirim data ini?');"
                                                class="btn btn-xs btn-success">kirim</a>
                                        </div>
                                    @endif

                                </x-table.body.column>
                            </tr>
                        @endforeach
                    </x-table.body>
                </x-table>
            </div>
        </div>
        <div>

        </div>
    </div>
@endsection
