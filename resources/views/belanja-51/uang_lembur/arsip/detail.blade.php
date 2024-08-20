@extends('layout.main')
@section('aside-menu')
    @include('belanja-51.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 py-2 px-4">
            <div class="w-full flex gap-1 flex-wrap justify-between">
                <a href="/belanja-51-v2/uang-lembur/arsip" class="btn btn-xs btn-primary">kembali</a>
            </div>
        </div>
        <div class="grid grid-rows-[auto_1fr] grid-cols-1 overflow-hidden px-4 pb-2">
            <div>
                <div>
                    @include('layout.flashmessage')
                </div>
            </div>
            <div class="h-full w-full carousel scroll-auto">
                <div class="carousel-item w-full grid grid-rows-[auto_1fr] gap-2" id="Register">
                    <div class="w-full flex gap-1 flex-wrap">
                        <div role="tablist" class="tabs tabs-bordered">
                            <a role="tab" class="tab tab-active" href="#Register">Register</a>
                            <a role="tab" class="tab" href="#Lampiran">Lampiran</a>
                        </div>
                    </div>
                    <div class="border border-base-300 p-1 rounded-box">
                        <x-pdf-viewer src="{{ env('APP_URL') }}/belanja-51-v2/document/{{ $permohonan->file }}" />
                    </div>
                </div>
                <div class="carousel-item w-full grid grid-rows-[auto_1fr] gap-2" id="Lampiran">
                    <div class="w-full flex gap-1 flex-wrap">
                        <div role="tablist" class="tabs tabs-bordered">
                            <a role="tab" class="tab" href="#Register">Register</a>
                            <a role="tab" class="tab tab-active" href="#Lampiran">Lampiran</a>
                        </div>
                    </div>
                    <div class="border border-base-300 p-1 rounded-box grid grid-rows-[auto_1fr]">
                        <div class="p-1">
                            <h2 class="font-bold text-lg">
                                Lampiran
                            </h2>
                            <hr>
                        </div>
                        <div class="overflow-x-auto overflow-y-auto h-full w-full">
                            <x-table class="collapse">
                                <x-table.header>
                                    <tr class="*:border-x *:text-center">
                                        <x-table.header.column>No</x-table.header.column>
                                        <x-table.header.column>Nama</x-table.header.column>
                                        <x-table.header.column>File</x-table.header.column>
                                        <x-table.header.column>Status</x-table.header.column>
                                        <x-table.header.column>#</x-table.header.column>
                                    </tr>
                                </x-table.header>
                                <x-table.body>
                                    @foreach ($permohonan->dokumen as $item)
                                        <tr class="*:border">
                                            <x-table.body.column
                                                class="text-center">{{ $loop->iteration }}</x-table.body.column>
                                            <x-table.body.column
                                                class="whitespace-nowrap">{{ $item->nama }}</x-table.body.column>
                                            <x-table.body.column class="text-center">
                                                <a href="{{ env('APP_URL') }}/belanja-51-v2/document/{{ $item->file }}"
                                                    class="btn btn-xs btn-primary btn-outline" target="_blank">Preview</a>
                                            </x-table.body.column>
                                            <x-table.body.column class="text-center">
                                                <div
                                                    class="badge badge-sm @switch($item->status)
                                                    @case('draft')
                                                        badge-warning
                                                        @break

                                                    @case('proses')
                                                        badge-info
                                                        @break

                                                    @case('success')
                                                        badge-success
                                                        @break

                                                    @case('failed')
                                                        badge-error
                                                        @break
                                                    @default
                                                @endswitch">
                                                    {{ $item->status }}
                                                </div>
                                            </x-table.body.column>
                                            <x-table.body.column class="text-center">

                                            </x-table.body.column>
                                        </tr>
                                    @endforeach
                                </x-table.body>
                            </x-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            {{-- {{$data->links()}} --}}
        </div>
    </div>
@endsection
