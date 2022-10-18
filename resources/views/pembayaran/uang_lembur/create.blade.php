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
              <form action="/pembayaran/uang-lembur/store" method="post" enctype="multipart/form-data" autocomplete="off">
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
                          <option value=""></option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label for="jumlah">Jumlah Pegawai:</label>
                        <input type="text" name="jumlah" class="form-control is-invalid" value="">
                        <div class="invalid-feedback">
                          invalid
                        </div>
                      </div>
                    </div>
                  </div>
    
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label for="">Upload File :</label>
                        <div class="custom-file">
                          <input type="file" class="form-control custom" name="file" required>
                        </div>
                        <span><small class="text-muted">file dengan format .pdf, ukuran maksimal 10 Mb</small></span>
                      </div>
                    </div>
                    <div class="col-lg-8">
                      <div class="form-group">
                        <label for="ket">Keterangan:</label>
                        <input type="text" name="ket" class="form-control is-invalid" value="">
                        <div class="invalid-feedback">
                          invalid
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <a href="/pembayaran/uang-lembur" class="btn btn-sm btn-secondary float-left"><i class="fa fa-undo"></i> Kembali</a>
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