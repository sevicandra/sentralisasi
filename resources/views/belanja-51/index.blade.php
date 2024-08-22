@extends('layout.main')
@section('aside-menu')
    @include('belanja-51.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 py-2 px-4">
            <div class="w-full flex gap-1 flex-wrap justify-between">
                <h1>Penolakan</h1>
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
                            <x-table.header.column class="w-6">No</x-table.header.column>
                            <x-table.header.column>Nomor</x-table.header.column>
                            <x-table.header.column>Catatan</x-table.header.column>
                            <x-table.header.column>#</x-table.header.column>
                        </tr>
                    </x-table.header>
                    <x-table.body>
                        @foreach ($data as $item)
                            <tr class="*:border">
                                <x-table.body.column class="text-center">{{ $loop->iteration }}</x-table.body.column>
                                <x-table.body.column class="text-center">{{ $item->nomor }}</x-table.body.column>
                                <x-table.body.column>{{ $item->catatan }}</x-table.body.column>
                                <x-table.body.column class="text-center">
                                    <form action="/belanja-51-vertikal/notifikasi/{{ $item->id }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-xs btn-success btn-outline">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-check">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                        </button>
                                    </form>
                                </x-table.body.column>
                            </tr>
                        @endforeach
                    </x-table.body>
                </x-table>
            </div>
        </div>
        <div class="px-4 py-2">

        </div>
    </div>
@endsection
