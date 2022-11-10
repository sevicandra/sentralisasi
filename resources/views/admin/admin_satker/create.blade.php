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
              <form action="/admin/admin-satker" method="post" autocomplete="off">
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
                        <label for="">Kode Satker:</label>
                        <input type="text" name="kdsatker" class="form-control @error('kdsatker') is-invalid @enderror" value="{{ old('kdsatker') }}">
                        @error('kdsatker')
                          <div class="invalid-feedback">
                            {{$message}}
                          </div>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12 ">
                      <div class="form-group">
                        <label for="jumlah">Kode Unit:</label>
                        <input type="text" name="kdunit" class="form-control @error('kdunit') is-invalid @enderror" value="{{ old('kdunit') }}">
                        @error('kdunit')
                          <div class="invalid-feedback">
                            {{$message}}
                          </div>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12 ">
                      <div class="form-group">
                        <label for="jumlah">Nama Jabatan:</label>
                        <input type="text" name="nmjabatan" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nmjabatan') }}">
                        @error('nmjabatan')
                          <div class="invalid-feedback">
                            {{$message}}
                          </div>
                        @enderror
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <a href="/admin/admin-satker" class="btn btn-sm btn-secondary float-left"><i class="fa fa-undo"></i> Kembali</a>
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