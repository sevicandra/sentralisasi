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
                          <a href="{{ config('app.url') }}/belanja-51/uang-lembur/index/{{ $item }}" class="btn btn-outline-secondary @if (!$thn && $item === date('Y') || $item === $thn) active @endif mr-1">{{ $item }}</a>
                        @endforeach
                    </div>
                    <a href="/belanja-51/uang-lembur/create" class="btn btn-sm btn-outline-secondary" >Tambah</a>
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
                              <td class="d-flex">
                                <div class="px-1">
                                  <form action="/belanja-51/uang-lembur/{{$item->id}}/dokumen" method="post" target="_blank">
                                    @csrf
                                    @method('patch')
                                    <button class="btn btn-sm btn-outline-primary pt-0 pb-0"><i class="bi bi-filetype-pdf"></i></button>
                                  </form>
                                </div>
                                <div class="px-1">
                                  <form action="/belanja-51/uang-lembur/{{$item->id}}/dokumen-excel" method="post" target="_blank">
                                    @csrf
                                    @method('patch')
                                    <button class="btn btn-sm btn-outline-primary pt-0 pb-0"><i class="bi bi-filetype-xls"></i></button>
                                  </form>
                                </div>
                              </td>
                              <td>
                                <?php if ($item->terkirim) : ?>
                                  <span class="text-primary">terkirim</span>
                                <?php else : ?>
                                <form action="/belanja-51/uang-lembur/{{ $item->id }}/delete" method="post">
                                  @csrf
                                  @method('DELETE')
                                  <a href="/belanja-51/uang-lembur/{{ $item->id }}/edit" data-toggle="tooltip" data-placement="bottom" title="Ubah" class="btn btn-sm btn-outline-primary pt-0 pb-0"><i class="nav-icon bi bi-pencil-square"></i></a>
                                  <button onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');" type="submit" class="btn btn-sm btn-outline-primary pt-0 pb-0"><i class="nav-icon bi bi-trash"></i></button>
                                  <a href="/belanja-51/uang-lembur/{{ $item->id }}/kirim" data-toggle="tooltip" data-placement="bottom" title="Kirim" onclick="return confirm('Apakah Anda yakin akan mengirim data ini?');" class="btn btn-sm btn-outline-primary pt-0 pb-0"><i class="nav-icon bi bi-send"></i></a>
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