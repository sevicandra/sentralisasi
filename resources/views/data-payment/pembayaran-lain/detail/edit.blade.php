@extends('layout.main')
@section('aside-menu')
    @include('data-payment.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 flex-wrap py-2 px-4">
        </div>
        <div class="grid grid-rows-[auto_1fr] grid-cols-1 overflow-hidden px-4 pb-2">
            <div></div>
            <div class="overflow-x-auto overflow-y-auto h-full w-full">
                <form action="/data-payment/lain/{{ $data->id }}" method="post" autocomplete="off">
                    @csrf
                    @method('PATCH')
                    <div class="flex flex-col gap-2 w-full max-w-2xl">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 p-2 gap-2">
                            <x-input name="nama" value="{{ old('nama', $data->nama) }}" label="Nama:" size="w-full" />
                            <x-input name="nip" value="{{ old('nip', $data->nip) }}" label="NIP:" size="w-full" />
                            <x-input name="bruto" value="{{ old('bruto', $data->bruto) }}" label="bruto:"
                                size="w-full" />
                            <x-input name="pph" value="{{ old('pph', $data->pph) }}" label="pph:" size="w-full" />
                            <x-input type="date" name="tanggal"
                                value="{{ old('tanggal', \Carbon\Carbon::parse($data->tanggal)->format('Y-m-d')) }}"
                                label="tanggal:" size="w-full" />
                            <x-input name="uraian" value="{{ old('uraian', $data->uraian) }}" label="uraian:"
                                size="w-full" />
                        </div>
                        <div class="flex gap-2 p-2">
                            <a href="/data-payment/lain/{{ $data->kdsatker }}/{{ $data->tahun }}/{{ $data->bulan }}/detail"
                                class="btn btn-xs btn-secondary">Kembali</a>
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
