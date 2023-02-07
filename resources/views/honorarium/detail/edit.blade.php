@extends('layout.main')
@section('aside-menu')
    @include('honorarium.sidemenu')
@endsection         
@section('main-content')

    <div id="main-content-header">
    </div>
    <div id="main-content">
        <div class="row">
          <div class="col-xxl-6">
            <div class="card">
              <form action="/honorarium/{{ $data->id }}/update-detail" method="post" enctype="multipart/form-data" autocomplete="off">
                @csrf
                @method('PATCH')
                <div class="card-header">
                  <div class="card-text">
                    <p></p>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label for="">Nama:</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ $data->nama }}">
                        @error('nama')
                        <div class="text-danger">
                          <small>
                            {{ $message }}
                          </small>
                        </div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label for="jmlpegawai">NIP</label>
                        <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ $data->nip }}">
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
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label for="">Bruto:</label>
                        <input type="text" name="bruto" class="form-control @error('bruto') is-invalid @enderror" value="{{ $data->bruto }}">
                        @error('bruto')
                        <div class="text-danger">
                          <small>
                            {{ $message }}
                          </small>
                        </div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label for="jmlpegawai">PPh</label>
                        <input type="text" name="pph" class="form-control @error('pph') is-invalid @enderror" value="{{ $data->pph }}">
                        @error('pph')
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
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label for="">Tanggal:</label>
                        <input type="text" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ date('d-m-Y', $data->tanggal) }}" >
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
                  <div class="row">
                    <div class="col-lg-8">
                          <div class="form-group">
                            <label for="">Uraian:</label>
                            <div class="custom-file">
                            <input type="text" class="form-control custom @error('uraian') is-invalid @enderror" name="uraian" value="{{ $data->uraian }}">
                            @error('uraian')
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
                </div>

                <div class="card-footer">
                  <a href="/honorarium/{{ $data->file }}/detail" class="btn btn-sm btn-secondary float-left"><i class="fa fa-undo"></i> Kembali</a>
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