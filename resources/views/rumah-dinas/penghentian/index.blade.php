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
                        <tr class="*:text-center *:border-x">
                            <x-table.header.column>No</x-table.header.column>
                            <x-table.header.column>Nama</x-table.header.column>
                            <x-table.header.column>NIP</x-table.header.column>
                            <x-table.header.column>Satker</x-table.header.column>
                            <x-table.header.column>Nomor SIP</x-table.header.column>
                            <x-table.header.column>TMT Penghentian</x-table.header.column>
                            <x-table.header.column>Tanggal Usulan Penghentian</x-table.header.column>
                            <x-table.header.column>Alasan Penghentian</x-table.header.column>
                            <x-table.header.column>Nilai Sewa</x-table.header.column>
                            <x-table.header.column>file</x-table.header.column>
                            <x-table.header.column>Action</x-table.header.column>
                        </tr>
                    </x-table.header>
                    <x-table.body>
                        @foreach ($data as $item)
                            <tr>
                                <x-table.body.column class="text-center">{{ $loop->iteration }}</x-table.body.column>
                                <x-table.body.column class="whitespace-nowrap">{{ $item->nama }}</x-table.body.column>
                                <x-table.body.column>{{ $item->nip }}</x-table.body.column>
                                <x-table.body.column class="whitespace-nowrap">{{ $item->nmsatker }}</x-table.body.column>
                                <x-table.body.column class="whitespace-nowrap">{{ $item->nomor_sip }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-center whitespace-nowrap">{{ $item->tanggal_selesai }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-center whitespace-nowrap">{{ $item->tanggal_usulan_ }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-center whitespace-nowrap">{{ $item->tanggal_usulan_non_aktif }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->nilai_potongan, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column class="text-center">
                                    @if ($item->file)
                                        <form action="/sewa-rumdin/penghentian/{{ $item->id }}/dokumen" method="post"
                                            target="_blank">
                                            @csrf
                                            @method('patch')
                                            <button class="btn btn-xs btn-outline btn-primary pt-0 pb-0">file</button>
                                        </form>
                                    @endif
                                </x-table.body.column>
                                <x-table.body.column class="text-center">
                                    <form action="/sewa-rumdin/penghentian/{{ $item->id }}/approve" method="post"
                                        onsubmit="return confirm('Apakah Anda yakin ?');">
                                        @csrf
                                        @method('PATCH')
                                        <div class="btn-group">
                                            <button class="btn btn-xs btn-success pt-0 pb-0">Approve</button>
                                        </div>
                                    </form>
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

@section('main-footer')
@endsection
