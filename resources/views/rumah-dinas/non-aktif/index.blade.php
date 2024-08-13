@extends('layout.main')
@section('aside-menu')
    @include('rumah-dinas.sidemenu')
@endsection
@section('main-content')
<div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
    <div class="flex gap-2 flex-wrap py-2 px-4">

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
                    <tr class="text-center align-middle">
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Nomor SIP</th>
                        <th>Tanggal SIP</th>
                        <th>TMT</th>
                        <th>Tanggal Kirim</th>
                        <th>TMT Penghentian</th>
                        <th>Tanggal Usulan Non Aktif</th>
                        <th>Alasan Penghentian</th>
                        <th>Nilai Sewa</th>
                        <th>file</th>
                    </tr>
                </x-table.header>
                <x-table.body>
                    @foreach ($data as $item)
                        <tr class="*:border">
                            <x-table.body.column class="text-center">{{ $loop->iteration }}</x-table.body.column>
                            <x-table.body.column class="whitespace-nowrap">{{ $item->nama }}</x-table.body.column>
                            <x-table.body.column>{{ $item->nip }}</x-table.body.column>
                            <x-table.body.column class="whitespace-nowrap">{{ $item->nomor_sip }}</x-table.body.column>
                            <x-table.body.column class="text-center whitespace-nowrap">{{ $item->tanggal_sip }}</x-table.body.column>
                            <x-table.body.column class="text-center whitespace-nowrap">{{ $item->tmt }}</x-table.body.column>
                            <x-table.body.column class="text-center whitespace-nowrap">{{ $item->tanggal_kirim }}</x-table.body.column>
                            <x-table.body.column class="text-center whitespace-nowrap">{{ $item->tanggal_selesai }}</x-table.body.column>
                            <x-table.body.column class="text-center whitespace-nowrap">{{ $item->tanggal_usulan_non_aktif }}</x-table.body.column>
                            <x-table.body.column class="text-center min-w-64">{{ $item->alasan_penghentian }}</x-table.body.column>
                            <x-table.body.column class="text-right">{{ number_format($item->nilai_potongan, 0, ',', '.') }}</x-table.body.column>
                            <x-table.body.column class="text-center">
                                @if ($item->file)
                                <form action="/sewa-rumdin/{{ $item->id }}/dokumen" method="post"
                                    target="_blank">
                                    @csrf
                                    @method('patch')
                                    <button class="btn btn-xs btn-outline btn-primary">file</button>
                                </form>
                                @endif
                            </x-table.body.column>
                        </tr>
                    @endforeach
                </x-table.body>
            </x-table>
        </div>
    </div>
    <div class="px-4 py-2">
        {{$data->links()}}
    </div>
</div>
@endsection