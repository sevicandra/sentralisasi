@extends('layout.main')
@section('aside-menu')
    @include('admin.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 flex-wrap py-2 px-4">
            <div class="flex justify-end w-full">
                <a href="/admin/ref-penandatangan/{{ $kdsatker }}/create" class="btn btn-xs btn-primary">Tambah</a>
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
                            <x-table.header.column>Tahun</x-table.header.column>
                            <x-table.header.column>Nama_ttd_skp</x-table.header.column>
                            <x-table.header.column>NIP_ttd_skp</x-table.header.column>
                            <x-table.header.column>Jab_ttd_skp</x-table.header.column>
                            <x-table.header.column>Nama_ttd_kp4</x-table.header.column>
                            <x-table.header.column>NIP_ttd_kp4</x-table.header.column>
                            <x-table.header.column>Jab_ttd_kp4</x-table.header.column>
                            <x-table.header.column>NPWP_bendahara</x-table.header.column>
                            <x-table.header.column>Nama_bendahara</x-table.header.column>
                            <x-table.header.column>NIP_bendahara</x-table.header.column>
                            <x-table.header.column>Tgl_spt</x-table.header.column>
                            <x-table.header.column>Action</x-table.header.column>
                        </tr>
                    </x-table.header>
                    <x-table.body>
                        @foreach ($data as $item)
                            <tr>
                                <x-table.body.column>{{ $loop->iteration }}</x-table.body.column>
                                <x-table.body.column>{{ $item->tahun }}</x-table.body.column>
                                <x-table.body.column>{{ $item->nama_ttd_skp }}</x-table.body.column>
                                <x-table.body.column>{{ $item->nip_ttd_skp }}</x-table.body.column>
                                <x-table.body.column>{{ $item->jab_ttd_skp }}</x-table.body.column>
                                <x-table.body.column>{{ $item->nama_ttd_kp4 }}</x-table.body.column>
                                <x-table.body.column>{{ $item->nip_ttd_kp4 }}</x-table.body.column>
                                <x-table.body.column>{{ $item->jab_ttd_kp4 }}</x-table.body.column>
                                <x-table.body.column>{{ $item->npwp_bendahara }}</x-table.body.column>
                                <x-table.body.column>{{ $item->nama_bendahara }}</x-table.body.column>
                                <x-table.body.column>{{ $item->nip_bendahara }}</x-table.body.column>
                                <x-table.body.column>{{ date('d-m-Y', $item->tgl_spt) }}</x-table.body.column>
                                <x-table.body.column>
                                    <a href="/admin/ref-penandatangan/{{ $kdsatker }}/{{ $item->id }}/edit"
                                        class="btn btn-xs btn-primary">Edit</a>
                                </x-table.body.column>
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
