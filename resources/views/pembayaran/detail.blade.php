@extends('layout.main')
@section('aside-menu')
    @include('pembayaran.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 py-2 px-4">
            <div class="w-full flex gap-1 flex-wrap">
                <a href="/belanja-51/index/{{ $thn }}" class="btn btn-xs btn-outline btn-primary btn-active">Kembali
                    ke halaman sebelumnya</a>
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
                            <x-table.header.column class="text-center">Uraian</x-table.header.column>
                            <x-table.header.column class="text-center">Tgl</x-table.header.column>
                            <x-table.header.column class="text-center">File</x-table.header.column>
                        </tr>
                    </x-table.header>
                    <x-table.body>
                        @foreach ($data as $item)
                            <tr class="*:border">
                                <x-table.body.column class="text-center">{{ $loop->iteration }}</x-table.body.column>
                                <x-table.body.column class="text-center">{{ $item->keterangan }}</x-table.body.column>
                                <x-table.body.column class="text-center">{{ $item->updated_at }}</x-table.body.column>
                                <x-table.body.column class="text-center">
                                    <form action="/belanja-51/{{ $jns }}/{{ $item->id }}/dokumen"
                                        method="post" target="_blank">
                                        @csrf
                                        @method('patch')
                                        <button class="btn btn-xs btn-outline btn-primary">pdf</button>
                                    </form>
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
