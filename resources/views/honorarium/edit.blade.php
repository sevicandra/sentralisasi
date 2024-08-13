@extends('layout.main')
@section('aside-menu')
    @include('honorarium.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex gap-2 flex-wrap py-2 px-4">
        </div>
        <div class="grid grid-rows-[auto_1fr] grid-cols-1 overflow-hidden px-4 pb-2">
            <div></div>
            <div class="overflow-x-auto overflow-y-auto h-full w-full">
                <form action="/honorarium/import" method="post" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="flex flex-col gap-2 w-full max-w-2xl">
                        <div class="flex flex-col">
                            <div class="flex flex-col md:flex-row md:gap-2 p-2">
                                <x-input name="bulan" value="{{ old('bulan', $data->bulan) }}" label="Bulan:" size="w-full"
                                    placeholder="01 - 12" />
                                <x-input name="tahun" value="{{ old('tahun', $data->tahun) }}" label="Tahun:" size="w-full" />
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <div class="flex flex-col md:flex-row md:gap-2 p-2">
                                <x-input.file name="file_pendukung" value="{{ old('file_pendukung') }}"
                                    label="Dokumen Pendukung:" size="w-full" accept="application/pdf" />
                            </div>
                        </div>
                        <div class="flex gap-2 p-2">
                            <a href="/honorarium" class="btn btn-xs btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-xs btn-success">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div>
            {{-- {{$data->links()}} --}}
        </div>
    </div>
@endsection
