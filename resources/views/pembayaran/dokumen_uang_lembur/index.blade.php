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
            <div class="col">
              <div class="card">
                <form action="" method="post">
                  <div class="card-header">
                      <a href="" class="btn btn-outline-secondary active mr-1">2022</a>
                  </div>
                  <div class=" card-body">
                      <a href="" class="btn btn-outline-secondary active mb-3 mr-1">1</a>
      
                    <div class="table-responsive">
                      <table class="table table-sm table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Berkas</th>
                            <th>Jml Peg</th>
                            <th>File</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                            <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td><a href="/pembayaran/dokumen-uang-makan/detail"><i class="bi bi-filetype-pdf"></i></a></td>
                              <td>
                                <?php if (isset($q)) : ?>
                                  <?php if ($q['sts'] == '1') : ?>
                                    <span class="text-primary">terkirim</span>
                                  <?php else : ?>
                                    <span class="text-primary"></span>
                                  <?php endif; ?>
                                <?php endif; ?>
                              </td>
                            </tr>
                        </tbody>
                        <thead>
                          <tr>
                            <th colspan="4">Jumlah</th>
                            <th></th>
                            <th></th>
                            <th></th>
                          </tr>
                        </thead>
                      </table>
                    </div>
      
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