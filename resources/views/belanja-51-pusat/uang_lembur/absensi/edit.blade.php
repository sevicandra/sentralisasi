@extends('layout.main')
@section('aside-menu')
    @include('belanja-51-pusat.sidemenu')
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
                        <div class="flex flex-col">
                            <div class="flex flex-col md:flex-row md:gap-2 p-2">
                                <x-input name="absensimasuk" value="{{ old('absensimasuk', $data->absensimasuk) }}"
                                    label="Absensi Masuk:" size="w-full" :required="true" />
                                <x-input name="absensikeluar" value="{{ old('absensikeluar', $data->absensikeluar) }}"
                                    label="Absensi Keluar:" size="w-full" :required="true" />
                                <x-input name="jumlahjam" value="{{ old('jumlahjam', $data->jumlahjam) }}"
                                    label="Jumlah Jam:" size="w-full" :required="true" />
                                <x-select name="jenishari" label="Jenis Hari:" size="w-full" :required="true">
                                    <option value="kerja" @if (old('jenishari', $data->jenishari) == 'kerja') selected @endif>Kerja</option>
                                    <option value="libur" @if (old('jenishari', $data->jenishari) == 'libur') selected @endif>Libur</option>
                                </x-select>
                                <x-select name="golongan" label="Golongan:" size="w-full" :required="true">
                                    <option value="1" @if (old('golongan', $data->golongan) == '1') selected @endif>Gol I</option>
                                    <option value="2" @if (old('golongan', $data->golongan) == '2') selected @endif>Gol II</option>
                                    <option value="3" @if (old('golongan', $data->golongan) == '3') selected @endif>Gol III
                                    </option>
                                    <option value="4" @if (old('golongan', $data->golongan) == '4') selected @endif>Gol IV</option>
                                </x-select>
                            </div>
                        </div>
                        <div class="flex gap-2 p-2">
                            <a href="/belanja-51-pusat/uang-lembur/absensi/{{ $tahun }}/{{ $bulan }}/{{ $data->nip }}"
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
