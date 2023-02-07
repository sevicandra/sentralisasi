@extends('layout.main')
@section('aside-menu')
    @include('data-payment.sidemenu')
@endsection         
@section('main-content')

    <div id="main-content-header">
    </div>
    <div id="main-content">
        <div class="row">
          <div class="col-xxl-6">
            <div class="card">
              <form action="/data-payment/lain" method="post" enctype="multipart/form-data" autocomplete="off">
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
                              <label for="">Upload File <span>Template (<a href="/template/Upload_Pembayaran_Lain.xlsx">download</a>)</span>  Excel: </label>
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
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                  <a href="/data-payment/lain" class="btn btn-sm btn-secondary float-left"><i class="fa fa-undo"></i> Kembali</a>
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