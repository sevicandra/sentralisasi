@extends('layout.main')
@section('aside-menu')
    @include('belanja-51.sidemenu')
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
                        <a href="{{ config('app.url') }}/belanja-51-v2/uang-lembur/create/{{ $item }}"
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
                            <a href="/belanja-51-v2/uang-lembur/create/{{ $thn }}/{{ $item->bulan }}"
                                class="btn btn-xs btn-primary">proses</a>
                        </x-table.body.column>
                    </tr>
                    @endforeach
                </x-table.body>
                </x-table>
                {{-- <form action="" enctype="multipart/form-data" autocomplete="off">
                    <div class="flex flex-col gap-2 w-full max-w-2xl">
                        <div class="flex flex-col">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 p-2">
                                <x-select name="bulan" label="Bulan:" size="w-full" :required="true">
                                    @foreach ($bulan as $item)
                                        <option value="{{ $item->bulan }}"
                                            @if (old('bulan') === $item->bulan) selected @endif>
                                            {{ $item->nmbulan }}</option>
                                    @endforeach
                                </x-select>
                                <x-input name="tahun" value="{{ old('tahun') }}" label="Tahun:" size="w-full"
                                    :required="true" />
                            </div>
                        </div>
                        <div class="flex gap-2 p-2">
                            <a href="/belanja-51-v2/uang-lembur" class="btn btn-xs btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-xs btn-success">Berikutnya</button>
                        </div>
                    </div>
                </form> --}}
            </div>
        </div>
        <div>
            {{-- {{$data->links()}} --}}
        </div>
    </div>
@endsection
