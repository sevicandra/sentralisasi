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
                        @foreach ($tahun as $item)
                          <a href="{{ config('app.url') }}/pembayaran/uang-makan/index/{{ $item }}" class="btn btn-outline-secondary @if (!$thn && $item === date('Y') || $item === $thn) active @endif mr-1">{{ $item }}</a>
                        @endforeach
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
                          @php
                              $i=1;
                          @endphp
                          @foreach ($data as $item)
                            <tr>
                              <td>{{ $i++ }}</td>
                              <td>{{ $item->nmbulan }}</td>
                              <td>{{ $item->jmlpegawai }}</td>
                              <td>{{ $item->keterangan }}</td>
                              <td>
                                <a href="{{ Storage::url($item->file) }}" target="_blank" class="btn btn-sm btn-outline-primary pt-0 pb-0">
                                <i class="bi bi-filetype-pdf"></i>
                                </a>
                              </td>
                              <td>
                                <?php if ($item->terkirim) : ?>
                                  <span class="text-primary">terkirim</span>
                                <?php else : ?>
                                <form action="/pembayaran/uang-makan/{{ $item->id }}/delete" method="post">
                                  @csrf
                                  @method('DELETE')
                                  <a href="/pembayaran/uang-makan/{{ $item->id }}/edit" data-toggle="tooltip" data-placement="bottom" title="Ubah" class="btn btn-sm btn-outline-primary pt-0 pb-0"><i class="nav-icon bi bi-pencil-square"></i></a>
                                  <button onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');" type="submit" class="btn btn-sm btn-outline-primary pt-0 pb-0"><i class="nav-icon bi bi-trash"></i></button>
                                  <a href="/pembayaran/uang-makan/{{ $item->id }}/kirim" data-toggle="tooltip" data-placement="bottom" title="Kirim" onclick="return confirm('Apakah Anda yakin akan mengirim data ini?');" class="btn btn-sm btn-outline-primary pt-0 pb-0"><i class="nav-icon bi bi-send"></i></a>
                                </form>
                                <?php endif; ?>
                              </td>
                            </tr>
                          @endforeach
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