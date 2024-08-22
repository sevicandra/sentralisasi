@extends('layout.main')
@section('aside-menu')
    @include('belanja-51-pusat.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 py-2 px-4">
            <div class="breadcrumbs text-sm">
                <ul>
                    <li><span class="btn btn-xs btn-ghost btn-active">Periode</span></li>
                    <li>Preview</li>
                </ul>
            </div>
            <div>
                <div class="flex gap-1 flex-wrap">
                    @foreach ($tahun as $item)
                        <a href="{{ config('app.url') }}/belanja-51-pusat/uang-lembur/create/{{ $item }}"
                            class="btn btn-xs btn-outline btn-primary @if ((!$thn && $item == date('Y')) || $item == $thn) btn-active @endif">{{ $item }}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="grid grid-rows-[auto_1fr] grid-cols-1 overflow-hidden px-4 pb-2">
            <div></div>
            <div class="overflow-x-auto overflow-y-auto h-full w-full">
                <x-table class="collapse">
                <x-table.header>
                    <tr class="*:border-x *:text-center">
                        <x-table.header.column>No</x-table.header.column>
                        <x-table.header.column>Bulan</x-table.header.column>
                        <x-table.header.column>Jumlah Pegawai</x-table.header.column>
                        <x-table.header.column>Action</x-table.header.column>
                    </tr>
                </x-table.header>
                <x-table.body>
                    @foreach ($bulan as $item)
                    <tr class="*:border">
                        <x-table.body.column class="text-center">{{ $loop->iteration }}</x-table.body.column>
                        <x-table.body.column class="text-center">{{ $item->nmbulan }}</x-table.body.column>
                        <x-table.body.column class="text-center">{{ $item->jml }}</x-table.body.column>
                        <x-table.body.column class="text-center">
                            <a href="/belanja-51-pusat/uang-lembur/create/{{ $thn }}/{{ $item->bulan }}"
                                class="btn btn-xs btn-primary">proses</a>
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
