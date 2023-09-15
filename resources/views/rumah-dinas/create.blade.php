@extends('layout.main')
@section('aside-menu')
    @include('rumah-dinas.sidemenu')
@endsection
@section('main-content')
    <div id="main-content-header">
    </div>
    <div id="main-content">
        <div class="row">
            <div class="col-xxl-8">
                <div class="card">
                    <form action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header">
                            <div class="card-text">
                                <p></p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="nama">Nama:</label>
                                        <input type="text" name="nama"
                                            class="form-control @error('nama') is-invalid @enderror"
                                            value="{{ old('nama') }}">
                                        @error('nama')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="nip">NIP:</label>
                                        <input type="text" name="nip"
                                            class="form-control @error('nip') is-invalid @enderror"
                                            value="{{ old('nip') }}">
                                        @error('nip')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4 ">
                                    <div class="form-group">
                                        <label for="nomor_sip">Nomor SIP:</label>
                                        <input type="text" name="nomor_sip"
                                            class="form-control @error('nomor_sip') is-invalid @enderror"
                                            value="{{ old('nomor_sip') }}">
                                        @error('nomor_sip')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Tanggal SIP:</label>
                                        <input type="date"
                                            class="form-control @error('tanggal_sip') is-invalid @enderror"
                                            name="tanggal_sip" required
                                            value="{{ old('tanggal_sip') }}">
                                        @error('tanggal_sip')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">TMT:</label>
                                        <input type="date" class="form-control @error('tmt') is-invalid @enderror"
                                            name="tmt" required
                                            value="{{ old('tmt') }}">
                                        @error('tmt')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="nilai">Nilai:</label>
                                        <input type="text" name="nilai"
                                            class="form-control @error('nilai') is-invalid @enderror"
                                            value="{{ old('nilai') }}">
                                        @error('nilai')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Upload File SIP:</label>
                                        <div class="custom-file">
                                            <input type="file"
                                                class="form-control custom @error('file') is-invalid @enderror"
                                                name="file" required>
                                            @error('file')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <span><small class="text-muted ">file dengan format .pdf, ukuran maksimal 10
                                                Mb</small></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="/sewa-rumdin" class="btn btn-sm btn-secondary float-left"><i
                                    class="fa fa-undo"></i> Kembali</a>
                            <button type="submit" class="btn btn-sm btn-success ml-2"><i class="fa fa-save"></i>
                                Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="paginator">
        {{-- {{$data->links()}} --}}
    </div>
@endsection
