@extends('layout.main')
@section('aside-menu')
    @include('admin.sidemenu')
@endsection         
@section('main-content')

    <div id="main-content-header">
    </div>
    <div id="main-content">
        <div class="row">
          <div class="col-xxl-8">
            <div class="card">
              <form action="/admin/user/store" method="post" autocomplete="off">
                @csrf
                <div class="card-header">
                  <div class="card-text">
                    <p></p>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label for="">Nama:</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}">
                        @error('nama')
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
                    <div class="col-lg-12 ">
                      <div class="form-group">
                        <label for="jumlah">NIP:</label>
                        <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip') }}">
                        @error('nip')
                        <div class="text-danger">
                            <small>
                                {{ $message }}
                            </small>
                        </div>
                        @enderror
                      </div>
                    </div>
                  </div>
                  @if (Auth::guard('web')->check())
                      @can('sys_admin', auth()->user()->id)
                      <div class="row">
                        <div class="col-lg-12 ">
                          <div class="form-group">
                            <label for="jumlah">Kode Satker:</label>
                            <input type="text" name="kdsatker" class="form-control @error('nip') is-invalid @enderror" value="{{ old('kdsatker') }}">
                            @error('kdsatker')
                              <div class="invalid-feedback">
                                {{$message}}
                              </div>
                            @enderror
                          </div>
                        </div>
                      </div>
                      @endcan
                  @endif
                  
                  <div class="row">
                    <div class="col-lg-12 ">
                      <div class="form-group">
                        <label for="jumlah">Nomor HP:</label>
                        <input type="text" name="nohp" class="form-control @error('nohp') is-invalid @enderror" value="{{ old('nohp') }}">
                        @error('nohp')
                        <div class="text-danger">
                            <small>
                                {{ $message }}
                            </small>
                        </div>
                        @enderror
                      </div>
                    </div>
                  </div>

                </div>
                <div class="card-footer">
                  <a href="/admin/user" class="btn btn-sm btn-secondary float-left"><i class="fa fa-undo"></i> Kembali</a>
                  <button type="submit" class="btn btn-sm btn-success ml-2"><i class="fa fa-save"></i> Simpan</button>
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