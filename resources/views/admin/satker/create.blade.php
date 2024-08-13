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
                <form action="/admin/satker/store" method="post" autocomplete="off">
                    @csrf
                    <div class="flex flex-col gap-2 w-full max-w-2xl">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 p-2 gap-2">
                            <x-input name="nmsatker" value="{{ old('nmsatker') }}" label="Nama Satker:" size="w-full" />
                            <x-input name="kdsatker" value="{{ old('kdsatker') }}" label="Kode Satker:" size="w-full" />
                            <x-input name="kdkoordinator" value="{{ old('kdkoordinator') }}"
                                label="Kode Satker Koordinator:" size="w-full" />
                            <x-select name="jnssatker" label="Jenis Satker:" size="w-full">
                                <option value="1" @if (old('jnssatker') === '1') selected @endif>
                                    Eselon 1</option>
                                <option value="2" @if (old('jnssatker') === '2') selected @endif>
                                    Eselon 2</option>
                                <option value="3" @if (old('jnssatker') === '3') selected @endif>
                                    Eselon 3</option>
                            </x-select>
                            <x-input name="order" value="{{ old('order') }}" label="Order:" size="w-full" />
                        </div>
                        <div class="flex gap-2 p-2">
                            <a href="/admin/satker" class="btn btn-xs btn-secondary">Kembali</a>
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
