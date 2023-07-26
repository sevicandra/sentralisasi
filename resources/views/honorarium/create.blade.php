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
              <form action="/honorarium/import" method="post" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="card-header">
                  <div class="card-text">
                    <p></p>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label for="">Bulan:</label>
                        <input type="text" name="bulan" class="form-control @error('bulan') is-invalid @enderror" value="{{ old('bulan') }}" placeholder="01 - 12">
                        @error('bulan')
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
                        <label for="jmlpegawai">Tahun</label>
                        <input type="text" name="tahun" class="form-control @error('tahun') is-invalid @enderror" value="{{ old('tahun') }}">
                        @error('tahun')
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
                              <label for="">Upload File <span>Template (<a href="/template/Upload_Honorarium.xlsx">download</a>)</span>  Excel: </label>
                              <div class="custom-file">
                              <input type="file" class="form-control custom @error('file') is-invalid @enderror" name="file_excel" accept=".xlsx" required>
                              @error('file_excel')
                              <div class="text-danger">
                                  <small>
                                      {{ $message }}
                                  </small>
                              </div>
                              @enderror
                          </div>
                              <span><small class="text-muted ">file dengan format .xlsx</small></span>
                          </div>
                          <div class="form-group">
                            <label for="">Upload File Dokumen Pendukung:</label>
                            <div class="custom-file">
                            <input type="file" class="form-control custom @error('file') is-invalid @enderror" name="file_pendukung" accept=".pdf" required>
                            @error('file_pendukung')
                            <div class="text-danger">
                                <small>
                                    {{ $message }}
                                </small>
                            </div>
                            @enderror
                        </div>
                            <span><small class="text-muted ">file dengan format .pdf</small></span>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                  <a href="/honorarium" class="btn btn-sm btn-secondary float-left"><i class="fa fa-undo"></i> Kembali</a>
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