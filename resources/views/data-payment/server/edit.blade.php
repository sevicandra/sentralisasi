@extends('layout.main')
@section('aside-menu')
    @include('data-payment.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex gap-2 flex-wrap py-2 px-4">
        </div>
        <div class="grid grid-rows-[auto_1fr] grid-cols-1 overflow-hidden px-4 pb-2">
            <div></div>
            <div class="overflow-x-auto overflow-y-auto h-full w-full">
                <form action="/data-payment/server/{{ $data->id }}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="flex flex-col gap-2 w-full max-w-2xl">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 p-2 gap-2">
                            <x-input name="bulan" value="{{ old('bulan', $data->bulan) }}" label="Bulan:" size="w-full"
                                placeholder="01 - 12" />
                            <x-input name="tahun" value="{{ old('tahun', $data->tahun) }}" label="Tahun:"
                                size="w-full" />
                            <x-input name="kdsatker" value="{{ old('kdsatker', $data->kdsatker) }}" label="kdsatker:"
                                size="w-full" />
                            <x-input name="nip" value="{{ old('nip', $data->nip) }}" label="nip:" size="w-full" />
                            <x-input name="bruto" value="{{ old('bruto', $data->bruto) }}" label="bruto:"
                                size="w-full" />
                            <x-input name="pph" value="{{ old('pph', $data->pph) }}" label="pph:" size="w-full" />
                            <x-input name="netto" value="{{ old('netto', $data->netto) }}" label="netto:"
                                size="w-full" />
                            <x-input name="jenis" value="{{ old('jenis', $data->jenis) }}" label="jenis:"
                                size="w-full" />
                            <x-input name="nospm" value="{{ old('nospm', $data->nospm) }}" label="nospm:"
                                size="w-full" />
                            <x-input name="uraian" value="{{ old('uraian', $data->uraian) }}" label="uraian:"
                                size="w-full" />
                            <x-input type="date" name="tanggal" value="{{ old('tanggal', \Carbon\Carbon::parse(+$data->tanggal)->format('Y-m-d')) }}"
                                label="tanggal:" size="w-full" />
                        </div>
                        <div class="flex gap-2 p-2">
                            <a href="/data-payment/server" class="btn btn-xs btn-secondary">Kembali</a>
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
