@extends('layout.main')
@section('aside-menu')
    @include('data-payment.sidemenu')
@endsection
@section('main-content')
    <div id="main-content">
        <div class="row">
            <div class="col-lg-12">
                <form action="/data-payment/server/{{ $data->id }}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group mb-2">
                                <label for="">bulan:</label>
                                <input type="text" name="bulan"
                                    class="form-control @error('bulan') is-invalid @enderror" value="{{ $data->bulan }}">
                                @error('bulan')
                                    <div class="text-danger">
                                        <small>
                                            {{ $message }}
                                        </small>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="">tahun:</label>
                                <input type="text" name="tahun"
                                    class="form-control @error('tahun') is-invalid @enderror" value="{{ $data->tahun }}">
                                @error('tahun')
                                    <div class="text-danger">
                                        <small>
                                            {{ $message }}
                                        </small>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="">kdsatker:</label>
                                <input type="text" name="kdsatker"
                                    class="form-control @error('kdsatker') is-invalid @enderror"
                                    value="{{ $data->kdsatker }}">
                                @error('kdsatker')
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
                                <label for="">nip:</label>
                                <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror"
                                    value="{{ $data->nip }}">
                                @error('nip')
                                    <div class="text-danger">
                                        <small>
                                            {{ $message }}
                                        </small>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="">bruto:</label>
                                <input type="text" name="bruto"
                                    class="form-control @error('bruto') is-invalid @enderror" value="{{ $data->bruto }}">
                                @error('bruto')
                                    <div class="text-danger">
                                        <small>
                                            {{ $message }}
                                        </small>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="">pph:</label>
                                <input type="text" name="pph" class="form-control @error('pph') is-invalid @enderror"
                                    value="{{ $data->pph }}">
                                @error('pph')
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
                                <label for="">netto:</label>
                                <input type="text" name="netto"
                                    class="form-control @error('netto') is-invalid @enderror" value="{{ $data->netto }}">
                                @error('netto')
                                    <div class="text-danger">
                                        <small>
                                            {{ $message }}
                                        </small>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="">jenis:</label>
                                <input type="text" name="jenis"
                                    class="form-control @error('jenis') is-invalid @enderror" value="{{ $data->jenis }}">
                                @error('jenis')
                                    <div class="text-danger">
                                        <small>
                                            {{ $message }}
                                        </small>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="">nospm:</label>
                                <input type="text" name="nospm"
                                    class="form-control @error('nospm') is-invalid @enderror" value="{{ $data->nospm }}">
                                @error('nospm')
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
                                <label for="">uraian:</label>
                                <input type="text" name="uraian"
                                    class="form-control @error('uraian') is-invalid @enderror" value="{{ $data->uraian }}">
                                @error('uraian')
                                    <div class="text-danger">
                                        <small>
                                            {{ $message }}
                                        </small>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="">tanggal:</label>
                                <input type="text" name="tanggal"
                                    class="form-control @error('tanggal') is-invalid @enderror" placeholder="dd-mm-yyyy"
                                    value="{{ \Carbon\Carbon::parse($data->tanggal)->format('Y-m-d') }}">
                                @error('tanggal')
                                    <div class="text-danger">
                                        <small>
                                            {{ $message }}
                                        </small>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <div class="form-group">
                                <a href="" class="btn btn-sm btn-outline-secondary">Batal</a>
                                <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="paginator">
        {{-- {{$data->links()}} --}}
    </div>
@endsection
