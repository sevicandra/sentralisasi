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
            <div class="col-lg-12">
              <div class="card">
                  <div class="card-header" style="display: flex; justify-content:space-between">
                    <div>
                        <a href="" class="btn btn-outline-secondary  mr-1">2022</a>
                    </div>
                    <a href="/pembayaran/uang-makan/create" class="btn btn-outline-secondary mr-2" data-toggle="tooltip" data-placement="bottom" title="Tambah"><i class="bi bi-plus"></i></a>
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
                          </tr>
                        </thead>
                        <tbody>
                            <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td><a href="" download="download">
                                  <i class="bi bi-file-pdf-o"></i>
                                </a></td>
                              <td>
                                <?php if (false) : ?>
                                  <span class="text-primary">terkirim</span>
                                <?php else : ?>
                                  <a href="/pembayaran/uang-makan/edit" data-toggle="tooltip" data-placement="bottom" title="Ubah"><i class="nav-icon bi bi-pencil-square ml-1"></i></a>
                                  <a href="" data-toggle="tooltip" data-placement="bottom" title="Hapus" onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');"><i class="nav-icon bi bi-trash ml-1"></i></a>
                                  <a href="" data-toggle="tooltip" data-placement="bottom" title="Kirim" onclick="return confirm('Apakah Anda yakin akan mengirim data ini?');"><i class="nav-icon bi bi-send ml-1"></i></a>
                                <?php endif; ?>
                              </td>
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