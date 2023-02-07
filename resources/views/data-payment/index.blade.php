@extends('layout.main')
@section('aside-menu')
    @include('data-payment.sidemenu')
@endsection         
@section('main-content')
    <div id="main-content-header">
      @include('layout.flashmessage')
    </div>
    <div id="main-content">
      <div class="row">
          <div class="col-lg-6">
              <div class="card">
                  <div class="card-header">Data Honorarium Pending</div>
                  <div class="card-body">
                      <div class="table-responsive">
                          <table class="table table-sm">
                              <thead>
                                  <tr>
                                    <th>No</th>
                                    <th>Satker</th>
                                    <th>Jumlah Pegawai</th>
                                    <th>Nilai</th>
                                  </tr>
                              </thead>
                              <tbody>

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