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
              <form action="/admin/role/{{ $data->id }}" method="post" autocomplete="off">
                @csrf
                @method('PATCH')
                <div class="card-header">
                  <div class="card-text">
                    <p></p>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label for="">Kode:</label>
                        <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" value="{{ $data->kode }}">
                        @error('kode')
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
                        <label for="jumlah">Role:</label>
                        <input type="text" name="role" class="form-control @error('role') is-invalid @enderror" value="{{ $data->role }}">
                        @error('role')
                          <div class="invalid-feedback">
                            {{$message}}
                          </div>
                        @enderror
                      </div>
                    </div>
                  </div>

                </div>
                <div class="card-footer">
                  <a href="/admin/role" class="btn btn-sm btn-secondary float-left"><i class="fa fa-undo"></i> Kembali</a>
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