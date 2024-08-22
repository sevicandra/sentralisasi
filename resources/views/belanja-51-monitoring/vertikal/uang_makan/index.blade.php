@extends('layout.main')
@section('aside-menu')
    @include('belanja-51-monitoring.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 py-2 px-4">
            <div class="w-full flex gap-1 flex-wrap justify-between">

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
                            <x-table.header.column>Nomor</x-table.header.column>
                            <x-table.header.column>Satker</x-table.header.column>
                            <x-table.header.column>Tanggal</x-table.header.column>
                            <x-table.header.column>Uraian</x-table.header.column>
                            <x-table.header.column>Status</x-table.header.column>
                            <x-table.header.column>Action</x-table.header.column>
                        </tr>
                    </x-table.header>
                    <x-table.body>
                        @foreach ($data as $item)
                            <tr class="*:border">
                                <x-table.body.column class="text-center">{{ $loop->iteration }}</x-table.body.column>
                                <x-table.body.column class="whitespace-nowrap">{{ $item->nomor }}</x-table.body.column>
                                <x-table.body.column>{{ $item->satker->nmsatker }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)->locale('id_ID')->isoFormat('D-MMM-Y') }}</x-table.body.column>
                                <x-table.body.column class="min-w-60">{{ $item->uraian }}</x-table.body.column>
                                <x-table.body.column class="text-center">
                                    <div class="badge badge-sm badge-warning">
                                        {{ $item->status }}
                                    </div>
                                </x-table.body.column>
                                <x-table.body.column class="text-center">
                                    <a href="/belanja-51-monitoring/vertikal/uang-makan/detail/{{ $item->id }}"
                                        class="btn btn-xs btn-primary">Detail</a>
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
