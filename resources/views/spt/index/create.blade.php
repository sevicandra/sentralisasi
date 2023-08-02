@extends('layout.main')
@section('aside-menu')
    @include('spt.sidemenu')
@endsection         
@section('main-content')
<div id="main-content-header">
    <div class="row">
        <div class="row">
            <div class="row">
                <div class="col-lg-12">
                    <a href="/spt" class="btn btn-sm btn-outline-success ml-1 mt-1 mb-1">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="main-content" class="container-fluid">
    <form action="" method="post">
        @csrf
        <div class="row">
            <div class="col-lg-3">
                <div class="form-group mb-2">
                    <label for="">tahun:</label>
                    <input type="text" name="tahun" class="form-control @error('tahun') is-invalid @enderror" value="{{ old('tahun') }}">
                    @error('tahun')
                        <div class="text-danger">
                            <small>
                                {{ $message }}
                            </small>
                        </div>
                    @enderror
                </div>
                <div class="form-group mb-2">
                    <label for="">nip:</label>
                    <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip') }}">
                    @error('nip')
                        <div class="text-danger">
                            <small>
                                {{ $message }}
                            </small>
                        </div>
                    @enderror
                </div>
                <div class="form-group mb-2">
                    <label for="">npwp:</label>
                    <input type="text" name="npwp" class="form-control @error('npwp') is-invalid @enderror" value="{{ old('npwp') }}">
                    @error('npwp')
                        <div class="text-danger">
                            <small>
                                {{ $message }}
                            </small>
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-3">
    
                <div class="form-group mb-2">
                    <label for="">kdgol:</label>
                    <select name="kdgol" class="form-control @error('kdgol') is-invalid @enderror">
                        @foreach ($refPang as $item)
                            <option value="{{ $item->kdgol }}" @if (old('kdgol') == $item->kdgol) selected @endif>{{ $item->nmgol }}</option>
                        @endforeach
                    </select>
                    @error('kdgol')
                        <div class="text-danger">
                            <small>
                                {{ $message }}
                            </small>
                        </div>
                    @enderror
                </div>
                <div class="form-group mb-2">
                    <label for="">alamat:</label>
                    <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat') }}">
                    @error('alamat')
                        <div class="text-danger">
                            <small>
                                {{ $message }}
                            </small>
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group mb-2">
                    <label for="">kdkawin:</label>
                    <select name="kdkawin" id="" class="form-control @error('kdkawin') is-invalid @enderror">
                        <option value="1000" @if (old('kdkawin') == '1000') selected @endif>TK/0</option>
                        <option value="1000" @if (old('kdkawin') == '1000') selected @endif>TK/1</option>
                        <option value="1000" @if (old('kdkawin') == '1000') selected @endif>TK/2</option>
                        <option value="1000" @if (old('kdkawin') == '1000') selected @endif>TK/3</option>
                        <option value="1100" @if (old('kdkawin') == '1100') selected @endif>K/0</option>
                        <option value="1101" @if (old('kdkawin') == '1101') selected @endif>K/1</option>
                        <option value="1102" @if (old('kdkawin') == '1102') selected @endif>K/2</option>
                        <option value="1103" @if (old('kdkawin') == '1103') selected @endif>K/3</option>
                    </select>
                    @error('kdkawin')
                        <div class="text-danger">
                            <small>
                                {{ $message }}
                            </small>
                        </div>
                    @enderror
                </div>
                <div class="form-group mb-2">
                    <label for="">kdjab:</label>
                    <select name="kdjab" class="form-control @error('kdjab') is-invalid @enderror">
                        @foreach ($refJab as $item)
                            <option value="{{ $item->kode }}" @if (old('kdjab') == $item->kode) selected @endif>{{ $item->nama }}</option>
                        @endforeach
                    </select>
                    @error('kdjab')
                        <div class="text-danger">
                            <small>
                                {{ $message }}
                            </small>
                        </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </form>
</div>
<div id="paginator">

</div>

@endsection