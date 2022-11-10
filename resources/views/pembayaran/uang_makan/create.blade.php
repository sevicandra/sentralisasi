@extends('layout.main')
@section('aside-menu')
    @include('pembayaran.sidemenu')
@endsection         
@section('main-content')

    <div id="main-content-header">
    </div>
    <div id="main-content">
        <div class="row">
          <div class="col-xxl-8">
            <div class="card">
              <form action="/belanja-51/uang-makan/store" method="post" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="card-header">
                  <div class="card-text">
                    <p></p>
                  </div>
                </div>
                <div class="card-body">
    
                  <div class="row">
                    <div class="col-lg-8">
                      <div class="form-group">
                        <label for="">Bulan:</label>
                        <select name="bulan" class="form-control">
                          @foreach ($bulan as $item)
                          <option value="{{ $item->bulan }}" @if (old('bulan') === $item->bulan)selected @endif>{{ $item->nmbulan }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label for="jmlpegawai">Jumlah Pegawai:</label>
                        <input type="text" name="jmlpegawai" class="form-control @error('jmlpegawai') is-invalid @enderror" value="{{ old('jmlpegawai') }}">
                        @error('jmlpegawai')
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label for="">Upload File :</label>
                        <div class="custom-file">
                          <input type="file" class="form-control custom @error('file') is-invalid @enderror" name="file" required>
                          @error('file')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>
                        <span><small class="text-muted ">file dengan format .pdf, ukuran maksimal 10 Mb</small></span>
                      </div>
                    </div>
                    <div class="col-lg-8">
                      <div class="form-group">
                        <label for="keterangan">Keterangan:</label>
                        <input type="text" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" value="{{ old('keterangan') }}">
                        @error('keterangan')
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                    </div>
                  </div>
    
    
                </div>
                <div class="card-footer">
                  <a href="/belanja-51/uang-makan/index" class="btn btn-sm btn-secondary float-left"><i class="fa fa-undo"></i> Kembali</a>
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