@extends('layout.main')
@section('aside-menu')
    @include('admin.sidemenu')
@endsection
@section('main-content')
    <div id="main-content-header">
    </div>
    <div id="main-content">
        <div class="row">
            <div class="col-xxl-12">
                <form action="" method="post" autocomplete="off">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="col-lg-3">
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
                                <label for="">nama_ttd_skp:</label>
                                <input type="text" name="nama_ttd_skp"
                                    class="form-control @error('nama_ttd_skp') is-invalid @enderror"
                                    value="{{ $data->nama_ttd_skp }}">
                                @error('nama_ttd_skp')
                                    <div class="text-danger">
                                        <small>
                                            {{ $message }}
                                        </small>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="">nip_ttd_skp:</label>
                                <input type="text" name="nip_ttd_skp"
                                    class="form-control @error('nip_ttd_skp') is-invalid @enderror"
                                    value="{{ $data->nip_ttd_skp }}">
                                @error('nip_ttd_skp')
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
                                <label for="">jab_ttd_skp:</label>
                                <input type="text" name="jab_ttd_skp"
                                    class="form-control @error('jab_ttd_skp') is-invalid @enderror"
                                    value="{{ $data->jab_ttd_skp }}">
                                @error('jab_ttd_skp')
                                    <div class="text-danger">
                                        <small>
                                            {{ $message }}
                                        </small>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="">nama_ttd_kp4:</label>
                                <input type="text" name="nama_ttd_kp4"
                                    class="form-control @error('nama_ttd_kp4') is-invalid @enderror"
                                    value="{{ $data->nama_ttd_kp4 }}">
                                @error('nama_ttd_kp4')
                                    <div class="text-danger">
                                        <small>
                                            {{ $message }}
                                        </small>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="">nip_ttd_kp4:</label>
                                <input type="text" name="nip_ttd_kp4"
                                    class="form-control @error('nip_ttd_kp4') is-invalid @enderror"
                                    value="{{ $data->nip_ttd_kp4 }}">
                                @error('nip_ttd_kp4')
                                    <div class="text-danger">
                                        <small>
                                            {{ $message }}
                                        </small>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="">jab_ttd_kp4:</label>
                                <input type="text" name="jab_ttd_kp4"
                                    class="form-control @error('jab_ttd_kp4') is-invalid @enderror"
                                    value="{{ $data->jab_ttd_kp4 }}">
                                @error('jab_ttd_kp4')
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
                                <label for="">npwp_bendahara:</label>
                                <input type="text" name="npwp_bendahara"
                                    class="form-control @error('npwp_bendahara') is-invalid @enderror"
                                    value="{{ $data->npwp_bendahara }}">
                                @error('npwp_bendahara')
                                    <div class="text-danger">
                                        <small>
                                            {{ $message }}
                                        </small>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="">nama_bendahara:</label>
                                <input type="text" name="nama_bendahara"
                                    class="form-control @error('nama_bendahara') is-invalid @enderror"
                                    value="{{ $data->nama_bendahara }}">
                                @error('nama_bendahara')
                                    <div class="text-danger">
                                        <small>
                                            {{ $message }}
                                        </small>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="">nip_bendahara:</label>
                                <input type="text" name="nip_bendahara"
                                    class="form-control @error('nip_bendahara') is-invalid @enderror"
                                    value="{{ $data->nip_bendahara }}">
                                @error('nip_bendahara')
                                    <div class="text-danger">
                                        <small>
                                            {{ $message }}
                                        </small>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="">tgl_spt:</label>
                                <input type="date" name="tgl_spt"
                                    class="form-control @error('tgl_spt') is-invalid @enderror"
                                    value="{{ date('Y-m-d', $data->tgl_spt) }}" placeholder="dd-mm-yyyy">
                                @error('tgl_spt')
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
                                <a href="/admin/penandatangan" class="btn btn-sm btn-outline-secondary">Batal</a>
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
