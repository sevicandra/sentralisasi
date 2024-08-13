@extends('layout.main')
@section('aside-menu')
    @include('spt.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex gap-2 flex-wrap py-2 px-4">
        </div>
        <div class="grid grid-rows-[auto_1fr] grid-cols-1 overflow-hidden px-4 pb-2">
            <div></div>
            <div class="overflow-x-auto overflow-y-auto h-full w-full">
                <form action="" method="post">
                    @csrf
                    <div class="flex flex-col gap-2 w-full max-w-2xl">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 p-2 gap-2">
                            <x-input name="tahun" value="{{ old('tahun') }}" label="Tahun:" size="w-full" />
                            <x-input name="nip" value="{{ old('nip') }}" label="Nip:" size="w-full" />
                            <x-input name="npwp" value="{{ old('npwp') }}" label="npwp:" size="w-full" />
                            <x-select name="kdgol" label="kdgol:" size="w-full">
                                @foreach ($refPang as $item)
                                    <option value="{{ $item->kdgol }}" @if (old('kdgol') == $item->kdgol) selected @endif>
                                        {{ $item->nmgol }}</option>
                                @endforeach
                            </x-select>
                            <x-select name="kdkawin" label="kdkawin:" size="w-full">
                                <option value="1000" @if (old('kdkawin') == '1000') selected @endif>TK/0</option>
                                <option value="1000" @if (old('kdkawin') == '1000') selected @endif>TK/1</option>
                                <option value="1000" @if (old('kdkawin') == '1000') selected @endif>TK/2</option>
                                <option value="1000" @if (old('kdkawin') == '1000') selected @endif>TK/3</option>
                                <option value="1100" @if (old('kdkawin') == '1100') selected @endif>K/0</option>
                                <option value="1101" @if (old('kdkawin') == '1101') selected @endif>K/1</option>
                                <option value="1102" @if (old('kdkawin') == '1102') selected @endif>K/2</option>
                                <option value="1103" @if (old('kdkawin') == '1103') selected @endif>K/3</option>
                            </x-select>
                            <x-select name="kdjab" label="kdjab:" size="w-full">
                                @foreach ($refJab as $item)
                                    <option value="{{ $item->kode }}" @if (old('kdjab') == $item->kode) selected @endif>
                                        {{ $item->nama }}</option>
                                @endforeach
                            </x-select>
                            <x-input name="alamat" value="{{ old('alamat') }}" label="alamat:" size="w-full"
                                class="col-span-1 md:col-span-2 lg:col-span-3" />
                        </div>
                        <div class="flex gap-2 p-2">
                            <a href="/spt" class="btn btn-xs btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-xs btn-success">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div>

        </div>
    </div>
@endsection
