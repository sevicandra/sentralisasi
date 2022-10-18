@extends('layout.main')
@section('aside-menu')
    @include('pembayaran.sidemenu')
@endsection         
@section('main-content')
    <div id="main-content-header">
      @include('layout.flashmessage')
    </div>
    <div id="main-content">
      <div class="row">
        <div class="col-lg-8">
          <div class="card">
              <div class="card-header">
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-sm table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Bulan</th>
                        <th>Jml Pegawai</th>
                        <th>Ket</th>
                        <th>File</th>
                        <th>#</th>
                        <th>Tgl Upload</th>
                        <th>Tgl Kirim</th>
                      </tr>
                    </thead>
                    <tbody>
                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td><a href="" download="download">
                              <i class="fa fa-file-pdf-o"></i>
                            </a></td>
                          <td>
                            <?php if (false) : ?>
                              <span class="text-primary">terkirim</span>
                            <?php else : ?>
                              <span class="text-primary">draft</span>
                            <?php endif; ?>
                          </td>
                          <td></td>
                          <td></td>
                        </tr>
                    </tbody>
                  </table>
                </div>
  
              </div>
          </div>
        </div>
      </div>
    </div>
    <div id="paginator">
        {{-- {{$data->links()}} --}}
    </div>


@endsection