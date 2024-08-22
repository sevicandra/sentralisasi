@extends('layout.main')
@section('aside-menu')
    @include('belanja-51-pusat.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 py-2 px-4">
            <div class="w-full flex  gap-1 flex-wrap justify-between">
                <div class="flex gap-1 flex-wrap">
                    <a href="{{ config('app.url') }}/belanja-51-pusat/uang-lembur/absensi/{{ $thn }}/{{ $bln }}"
                        class="btn btn-xs btn-primary">kembali</a>
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
                            <x-table.header.column class="text-center">NIP</x-table.header.column>
                            <x-table.header.column class="text-center">Nama</x-table.header.column>
                            <x-table.header.column class="text-center">Golongan</x-table.header.column>
                            <x-table.header.column class="text-center">Tanggal</x-table.header.column>
                            <x-table.header.column class="text-center">Jenis Hari</x-table.header.column>
                            <x-table.header.column class="text-center">Absensi Masuk</x-table.header.column>
                            <x-table.header.column class="text-center">Absensi Keluar</x-table.header.column>
                            <x-table.header.column class="text-center">Jumlah Jam</x-table.header.column>
                            <x-table.header.column class="text-center">#</x-table.header.column>
                        </tr>
                    </x-table.header>
                    <x-table.body>
                        @foreach ($data as $item)
                            <tr class="*:border">
                                <x-table.body.column class="text-center">{{ $loop->iteration }}</x-table.body.column>
                                <x-table.body.column class="text-center">{{ $item->nip }}</x-table.body.column>
                                <x-table.body.column class="">{{ $item->nama }}</x-table.body.column>
                                <x-table.body.column class="text-center">{{ $item->golongan }}</x-table.body.column>
                                <x-table.body.column class="text-center">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d-M-Y') }}</x-table.body.column>
                                <x-table.body.column class="text-center">{{ $item->jenishari }}</x-table.body.column>
                                <x-table.body.column class="text-center">{{ $item->absensimasuk }}</x-table.body.column>
                                <x-table.body.column class="text-center">{{ $item->absensikeluar }}</x-table.body.column>
                                <x-table.body.column class="text-center">{{ $item->jumlahjam }}</x-table.body.column>
                                <x-table.body.column class="text-center">
                                    <div class="w-full h-full flex gap-1 flex-wrap justify-center">
                                        <a href="/belanja-51-pusat/uang-lembur/absensi/{{ $item->id }}/edit"
                                            class="btn btn-xs btn-primary">ubah</a>
                                        <form action="/belanja-51-pusat/uang-lembur/absensi/{{ $item->id }}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');"
                                                type="submit" class="btn btn-xs btn-error">hapus</button>
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

        </div>
    </div>
@endsection
