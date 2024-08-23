@extends('layout.main')
@section('aside-menu')
    @include('admin.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex gap-2 flex-wrap py-2 px-4">
        </div>
        <div class="grid grid-rows-[auto_1fr] grid-cols-1 overflow-hidden px-4 pb-2">
            <div></div>
            <div class="overflow-x-auto overflow-y-auto h-full w-full">
                <form action="" method="post" autocomplete="off">
                    @csrf
                    @method('PATCH')
                    <div class="flex flex-col gap-2 w-full max-w-2xl">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 p-2 gap-2">
                            <x-input type="text" name="tahun" size="w-full" value="{{ old('tahun', $data->tahun) }}"
                                label="Tahun:" :required="true" />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 p-2 gap-2">
                            <x-input type="text" name="kdsatker" size="w-full" value="{{ old('kdsatker', $data->kdsatker) }}"
                                label="Kode Satker:" :required="true" />
                            <x-input type="text" name="kdunit" size="w-full" value="{{ old('kdunit', $data->kdunit) }}"
                                label="Kode Unit:" />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 p-2 gap-2">
                            <x-input type="text" name="nomor" value="{{ old('nomor', $data->nomor) }}" size="w-full"
                                label="Nomor:" />
                            <x-input type="text" name="ext" size="w-full" value="{{ old('ext', $data->ext) }}"
                                label="Ext:" />
                        </div>
                        <div class="flex gap-2 p-2">
                            <a href="/admin/ref-nomor" class="btn btn-xs btn-secondary">Kembali</a>
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