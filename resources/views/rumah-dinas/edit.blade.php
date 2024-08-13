@extends('layout.main')
@section('aside-menu')
    @include('rumah-dinas.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex gap-2 flex-wrap py-2 px-4">
        </div>
        <div class="grid grid-rows-[auto_1fr] grid-cols-1 overflow-hidden px-4 pb-2">
            <div></div>
            <div class="overflow-x-auto overflow-y-auto h-full w-full">
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="flex flex-col gap-2 w-full max-w-2xl">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 p-2 gap-2">
                            <x-input name="nama" value="{{ old('nama', $data->nama) }}" label="Nama:" size="w-full"
                                :required="true" />
                            <x-input name="nip" value="{{ old('nip', $data->nip) }}" label="NIP:" size="w-full"
                                :required="true" />
                            <x-input name="nomor_sip" value="{{ old('nomor_sip', $data->nomor_sip) }}" label="Nomor SIP:"
                                size="w-full" :required="true" />
                            <x-input type="date" name="tanggal_sip"
                                value="{{ old('tanggal_sip', \Carbon\Carbon::parse($data->tanggal_sip)->format('Y-m-d')) }}"
                                label="Tanggal SIP:" size="w-full" :required="true" />
                            <x-input type="date" name="tmt"
                                value="{{ old('tmt', \Carbon\Carbon::parse($data->tmt)->format('Y-m-d')) }}" label="TMT:"
                                size="w-full" :required="true" />
                            <x-input name="nilai" value="{{ old('nilai', $data->nilai_potongan) }}" label="Nilai:"
                                size="w-full" :required="true" />
                            <x-input.file name="file" label="Upload File SIP:" size="w-full md:col-span-2 lg:col-span-3"
                                accept="application/pdf" />
                        </div>
                        <div class="flex gap-2 p-2">
                            <a href="/sewa-rumdin" class="btn btn-xs btn-secondary">Kembali</a>
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
