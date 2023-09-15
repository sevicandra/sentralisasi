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
                          <label for="">no_skp:</label>
                          <input type="text" name="no_skp" class="form-control @error('no_skp') is-invalid @enderror" value="{{ old('no_skp') }}">
                          @error('no_skp')
                          <div class="text-danger">
                              <small>
                                  {{ $message }}
                              </small>
                          </div>
                          @enderror
                      </div>
                      <div class="form-group mb-2">
                          <label for="">nama_ttd_skp:</label>
                          <input type="text" name="nama_ttd_skp" class="form-control @error('nama_ttd_skp') is-invalid @enderror" value="{{ old('nama_ttd_skp') }}">
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
                        <input type="text" name="nip_ttd_skp" class="form-control @error('nip_ttd_skp') is-invalid @enderror" value="{{ old('nip_ttd_skp') }}">
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
                          <input type="text" name="jab_ttd_skp" class="form-control @error('jab_ttd_skp') is-invalid @enderror" value="{{ old('jab_ttd_skp') }}">
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
                          <input type="text" name="nama_ttd_kp4" class="form-control @error('nama_ttd_kp4') is-invalid @enderror" value="{{ old('nama_ttd_kp4') }}">
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
                          <input type="text" name="nip_ttd_kp4" class="form-control @error('nip_ttd_kp4') is-invalid @enderror" value="{{ old('nip_ttd_kp4') }}">
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
                        <input type="text" name="jab_ttd_kp4" class="form-control @error('jab_ttd_kp4') is-invalid @enderror" value="{{ old('jab_ttd_kp4') }}">
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
                          <input type="text" name="npwp_bendahara" class="form-control @error('npwp_bendahara') is-invalid @enderror" value="{{ old('npwp_bendahara') }}">
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
                          <input type="text" name="nama_bendahara" class="form-control @error('nama_bendahara') is-invalid @enderror" value="{{ old('nama_bendahara') }}">
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
                          <input type="text" name="nip_bendahara" class="form-control @error('nip_bendahara') is-invalid @enderror" value="{{ old('nip_bendahara') }}">
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
                        <input type="date" name="tgl_spt" class="form-control @error('tgl_spt') is-invalid @enderror" value="{{ old('tgl_spt') }}" placeholder="dd-mm-yyyy">
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
                          <a href="/admin/ref-penandatangan/{{ $kdsatker }}" class="btn btn-sm btn-outline-secondary">Batal</a>
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