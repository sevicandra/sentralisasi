@extends('layout.main')
@section('aside-menu')
    @include('admin.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex gap-2 flex-wrap py-2 px-4">
        </div>
        <div class="overflow-x-auto overflow-y-auto h-full w-full">
            <form action="/admin/role/{{ $data->id }}" method="post" autocomplete="off">
                @csrf
                @method('PATCH')
                <div class="flex flex-col gap-2 w-full max-w-2xl">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 p-2 gap-2">
                        <x-input type="text" name="kode" size="w-full" value="{{ old('kode', $data->kode) }}"
                            label="Kode:" />
                        <x-input type="text" name="role" size="w-full" value="{{ old('role', $data->role) }}"
                            label="Role:" />
                    </div>
                    <div class="flex gap-2 p-2">
                        <a href="/admin/role" class="btn btn-xs btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-xs btn-success">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
        <div>
            {{-- {{$data->links()}} --}}
        </div>
    </div>
@endsection
