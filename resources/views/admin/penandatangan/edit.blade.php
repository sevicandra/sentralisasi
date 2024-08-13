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
                                label="Tahun:" />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 p-2 gap-2">
                            <x-input type="text" name="nama_ttd_skp" size="w-full"
                                value="{{ old('nama_ttd_skp', $data->nama_ttd_skp) }}" label="Nama Ttd SKP:" />
                            <x-input type="text" name="nip_ttd_skp" size="w-full"
                                value="{{ old('nip_ttd_skp', $data->nip_ttd_skp) }}" label="NIP Ttd SKP:" />
                            <x-input type="text" name="jab_ttd_skp" size="w-full"
                                value="{{ old('jab_ttd_skp', $data->jab_ttd_skp) }}" label="Jabatan Ttd SKP:" />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 p-2 gap-2">
                            <x-input type="text" name="nama_ttd_kp4"
                                value="{{ old('nama_ttd_kp4', $data->nama_ttd_kp4) }}" size="w-full"
                                label="Nama Ttd KP4:" />
                            <x-input type="text" name="nip_ttd_kp4" size="w-full"
                                value="{{ old('nip_ttd_kp4', $data->nip_ttd_kp4) }}" label="NIP Ttd KP4:" />
                            <x-input type="text" name="jab_ttd_kp4" size="w-full"
                                value="{{ old('jab_ttd_kp4', $data->jab_ttd_kp4) }}" label="Jabatan Ttd KP4:" />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 p-2 gap-2">
                            <x-input type="text" name="npwp_bendahara" size="w-full"
                                value="{{ old('npwp_bendahara', $data->npwp_bendahara) }}" label="NPWP Bendahara:" />
                            <x-input type="text" name="nama_bendahara" size="w-full"
                                value="{{ old('nama_bendahara', $data->nama_bendahara) }}" label="Nama Bendahara:" />
                            <x-input type="text" name="nip_bendahara" size="w-full"
                                value="{{ old('nip_bendahara', $data->nip_bendahara) }}" label="NIP Bendahara:" />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 p-2 gap-2">
                            <x-input type="date" name="tgl_spt" size="w-full"
                                value="{{ old('tgl_spt', \Carbon\Carbon::parse($data->tgl_spt)->format('Y-m-d')) }}"
                                placeholder="dd-mm-yyyy" label="Tgl SPT:" />
                        </div>
                        <div class="flex gap-2 p-2">
                            <a href="/admin/penandatangan" class="btn btn-xs btn-secondary">Kembali</a>
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
