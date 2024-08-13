@extends('layout.main')
@section('aside-menu')
    @include('spt.sidemenu')
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
            <div class="grid grid-rows-[auto_1fr] h-full w-full overflow-x-hidden">
                <div>
                    <form action="" method="post" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        @method('POST')
                        <div class="flex flex-col">
                            <div class="flex flex-col md:flex-row md:gap-2 p-2">
                                <x-input.file name="file_excel" value="{{ old('file_excel') }}" label="Upload File:"
                                    size="w-full"
                                    accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />
                            </div>
                        </div>
                        <div class="flex gap-2 p-2">
                            <a href="/spt" class="btn btn-xs btn-secondary">Kembali</a>
                            <a href="/template/Upload_spt.xlsx" class="btn btn-xs btn-accent">Download Template</a>
                            <button type="submit" class="btn btn-xs btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
                @if (Session::has('rowsErrors'))
                    <div class="overflow-x-auto overflow-y-auto">
                        <x-table class="collapse">
                            <x-table.header>
                                <tr class="*:border-x *:text-center">
                                    <x-table.header.column>No</x-table.header.column>
                                    <x-table.header.column>tahun</x-table.header.column>
                                    <x-table.header.column>nip</x-table.header.column>
                                    <x-table.header.column>npwp</x-table.header.column>
                                    <x-table.header.column>alamat</x-table.header.column>
                                    <x-table.header.column>kdgol</x-table.header.column>
                                    <x-table.header.column>kdkawin</x-table.header.column>
                                    <x-table.header.column>kdjab</x-table.header.column>
                                </tr>
                            </x-table.header>
                            <x-table.body>
                                @foreach (Session::get('rowsErrors') as $item)
                                    <tr
                                        class=" @if ($item->status) text-success
                                  @else
                                  text-error @endif *:border ">
                                        <x-table.body.column class="text-center">{{ $item->row }}</x-table.body.column>
                                        <x-table.body.column>{{ $item->errors->tahun }}</x-table.body.column>
                                        <x-table.body.column>{{ $item->errors->nip }}</x-table.body.column>
                                        <x-table.body.column>{{ $item->errors->npwp }}</x-table.body.column>
                                        <x-table.body.column>{{ $item->errors->alamat }}</x-table.body.column>
                                        <x-table.body.column>{{ $item->errors->kdgol }}</x-table.body.column>
                                        <x-table.body.column>{{ $item->errors->kdkawin }}</x-table.body.column>
                                        <x-table.body.column>{{ $item->errors->kdjab }}</x-table.body.column>
                                    </tr>
                                @endforeach
                            </x-table.body>
                        </x-table>
                    </div>
                @endif
            </div>
        </div>
        <div>
            {{-- {{$data->links()}} --}}
        </div>
    </div>

@endsection
