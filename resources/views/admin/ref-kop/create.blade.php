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
                    <div class="flex flex-col gap-2 w-full max-w-2xl">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 p-2 gap-2">
                            <x-input type="text" name="kdsatker" size="w-full" value="{{ old('kdsatker') }}"
                                label="Kode Satker:" :required="true" />
                            <x-input type="text" name="kdunit" size="w-full" value="{{ old('kdunit') }}"
                                label="Kode Unit:" />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 p-2 gap-2">
                            <x-input type="text" name="eselon1" value="{{ old('eselon1') }}" size="w-full"
                                label="Eselon 1:" />
                            <x-input type="text" name="eselon2" size="w-full" value="{{ old('eselon2') }}"
                                label="Eselon 2:" />
                            <x-input type="text" name="eselon3" size="w-full" value="{{ old('eselon3') }}"
                                label="Eselon 3:" />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 p-2 gap-2">
                            <x-input.text name="alamat" value="{{ old('alamat') }}" size="w-full col-span-1 md:col-span-2 lg:col-span-3"
                                label="Alamat:" />
                        </div>
                        <div class="flex gap-2 p-2">
                            <a href="/admin/ref-kop" class="btn btn-xs btn-secondary">Kembali</a>
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
