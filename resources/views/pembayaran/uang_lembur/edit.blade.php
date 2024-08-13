@extends('layout.main')
@section('aside-menu')
    @include('pembayaran.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex gap-2 flex-wrap py-2 px-4">
        </div>
        <div class="grid grid-rows-[auto_1fr] grid-cols-1 overflow-hidden px-4 pb-2">
            <div></div>
            <div class="overflow-x-auto overflow-y-auto h-full w-full">

                <form action="/belanja-51/uang-lembur/{{ $data->id }}/update" method="post" enctype="multipart/form-data"
                    autocomplete="off">
                    @csrf
                    @method('PATCH')
                    <div class="flex flex-col gap-2 w-full max-w-2xl">
                        <div class="flex flex-col">
                            <div class="flex flex-col md:flex-row md:gap-2 p-2">
                                <x-select name="bulan" label="Bulan:" size="w-full">
                                    @foreach ($bulan as $item)
                                        <option value="{{ $item->bulan }}"
                                            @if (old('bulan', $data->bulan) === $item->bulan) selected @endif>
                                            {{ $item->nmbulan }}</option>
                                    @endforeach
                                </x-select>
                                <x-input name="tahun" value="{{ old('tahun', $data->tahun) }}" label="Tahun:" size="w-full" />
                                <x-input name="jmlpegawai" value="{{ old('jmlpegawai', $data->jmlpegawai) }}" label="Jumlah Pegawai:"
                                    size="w-full" />
                            </div>
                            <div class="flex flex-col md:flex-row md:gap-2 p-2">
                                <x-input.file name="file" value="{{ old('file') }}" label="File Pdf:" size="w-full" accept="application/pdf" />
                                <x-input.file name="file_excel" value="{{ old('file_excel') }}" label="File Excel:"
                                    size="w-full" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />
                            </div>
                            <div class="flex flex-col md:flex-row md:gap-2 p-2">
                                <x-input name="keterangan" value="{{ old('keterangan', $data->keterangan) }}" label="Keterangan:"
                                    size="w-full" />
                            </div>
                        </div>
                        <div class="flex gap-2 p-2">
                            <a href="/belanja-51/uang-lembur/index" class="btn btn-xs btn-secondary">Kembali</a>
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
