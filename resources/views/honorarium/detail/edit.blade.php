@extends('layout.main')
@section('aside-menu')
    @include('honorarium.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 py-2 px-4">
        </div>
        <div class="grid grid-rows-[auto_1fr] grid-cols-1 overflow-hidden px-4 pb-2">
            <form action="/honorarium/{{ $data->id }}/update-detail" method="post" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                @method('PATCH')
                <div class="flex flex-col gap-2 w-full max-w-2xl">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 p-2">
                        <x-input name="nama" value="{{ old('nama', $data->nama) }}" label="Nama:" />
                        <x-input name="nip" value="{{ old('nip', $data->nip) }}" label="NIP:" />
                        <x-input name="bruto" value="{{ old('bruto', $data->bruto) }}" label="Bruto:" />
                        <x-input name="pph" value="{{ old('pph', $data->pph) }}" label="PPh:" />
                        <x-input type="date" name="tanggal" value="{{ old('tanggal', \Carbon\Carbon::parse($data->tanggal)->format('Y-m-d')) }}"
                            label="Tanggal:" />
                        <x-input name="uraian" value="{{ old('uraian', $data->uraian) }}" label="Uraian:"
                            class="md:col-span-3" />
                    </div>
                    <div class="flex gap-2 p-2">
                        <a href="/honorarium/{{ $data->file }}/detail" class="btn btn-xs btn-secondary">Kembali</a>
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
