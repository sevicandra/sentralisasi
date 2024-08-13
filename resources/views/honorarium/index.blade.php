@extends('layout.main')
@section('aside-menu')
    @include('honorarium.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex gap-2 flex-wrap py-2 px-4">
            <div class="flex justify-between w-full">
                <div class="w-full flex gap-1 flex-wrap">
                    @foreach ($tahun as $item)
                        <a href="{{ config('app.url') }}/honorarium/{{ $item->tahun }}"
                            class="btn btn-xs btn-outline btn-primary @if ((!$thn && $item->tahun === date('Y')) || $item->tahun === $thn) btn-active @endif">{{ $item->tahun }}</a>
                    @endforeach
                </div>
                <div class="flex">
                    <a href="/honorarium/create" class="btn btn-xs btn-primary" title="Tambah">Tambah</a>
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
                            <x-table.header.column>Bulan</x-table.header.column>
                            <x-table.header.column>Jml Pegawai</x-table.header.column>
                            <x-table.header.column>Bruto</x-table.header.column>
                            <x-table.header.column>PPh</x-table.header.column>
                            <x-table.header.column>Netto</x-table.header.column>
                            <x-table.header.column>Status</x-table.header.column>
                            <x-table.header.column>File</x-table.header.column>
                            <x-table.header.column>#</x-table.header.column>
                        </tr>
                    </x-table.header>
                    <x-table.body>
                        @foreach ($data as $item)
                            <tr class="*:border">
                                <x-table.body.column class="text-center">{{ $loop->iteration }}</x-table.body.column>
                                <x-table.body.column class="text-left">{{ $item->nmbulan }}</x-table.body.column>
                                <x-table.body.column class="text-center">{{ $item->jmh }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->bruto, 2, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->pph, 2, ',', '.') }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->bruto - $item->pph, 2, ',', '.') }}
                                </x-table.body.column>
                                <x-table.body.column class="text-center">
                                    @switch($item->minSts)
                                        @case(0)
                                            <div class="badge badge-warning">
                                                draft
                                            </div>
                                        @break

                                        @case(1)
                                            <div class="badge badge-success">
                                                Send
                                            </div>
                                        @break

                                        @case(2)
                                            <div class="badge badge-primary">
                                                Uploaded
                                            </div>
                                        @break

                                        @default
                                            <div class="badge badge-warning">
                                                draft
                                            </div>
                                    @endswitch
                                </x-table.body.column>
                                <x-table.body.column>
                                    <form action="/honorarium/{{ $item->file }}/dokumen" method="post" target="_blank">
                                        @csrf
                                        @method('patch')
                                        <button class="btn btn-xs btn-outline btn-primary">file</button>
                                    </form>
                                </x-table.body.column>
                                <x-table.body.column class="min-w-[200px]">
                                    <div class="w-full h-full gap-1 flex justify-center flex-wrap">
                                        @if ($item->where('file', $item->file)->max('sts') === '0')
                                            <form action="/honorarium/{{ $item->file }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');"
                                                    type="submit" class="btn btn-xs btn-error">hapus</button>
                                            </form>
                                            <a href="/honorarium/{{ $item->file }}/edit"
                                                class="btn btn-xs btn-primary">ubah</a>
                                            <a href="/honorarium/{{ $item->file }}/detail"
                                                class="btn btn-xs btn-primary">detail</a>
                                            <a href="/honorarium/{{ $item->file }}/kirim"
                                                onclick="return confirm('Apakah Anda yakin akan mengirim data ini?');"
                                                class="btn btn-xs btn-success">kirim</a>
                                        @elseif($item->where('file', $item->file)->min('sts') === '0')
                                            <a href="/honorarium/{{ $item->file }}/kirim" data-toggle="tooltip"
                                                data-placement="bottom" title="Kirim"
                                                onclick="return confirm('Apakah Anda yakin akan mengirim data ini?');"
                                                class="btn btn-xs btn-success">kirim</a>
                                            <a href="/honorarium/{{ $item->file }}/detail" data-toggle="tooltip"
                                                data-placement="bottom" title="detail"
                                                class="btn btn-xs btn-primary">detail</a>
                                        @else
                                            <a href="/honorarium/{{ $item->file }}/detail" data-toggle="tooltip"
                                                data-placement="bottom" title="detail"
                                                class="btn btn-xs btn-primary">detail</a>
                                        @endif
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
