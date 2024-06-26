@extends('layout.main')
@section('aside-menu')
    @include('pembayaran.sidemenu')
@endsection         
@section('main-content')
    <div id="main-content-header">
      <div class="row">
        <div class="col-lg-12">
          <a href="/belanja-51/dokumen-uang-makan/{{ $thn }}/{{ $bln }}" class="btn btn-sm btn-outline-success ml-1 mt-1 mb-2">Kembali ke halaman sebelumnya</a>
        </div>
        @include('layout.flashmessage')
      </div>
    </div>
    <div id="main-content">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
              <div class="card-header">
                Kantor Pusat
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-sm table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Jml Pegawai</th>
                        <th>Ket</th>
                        <th>File</th>
                        <th>#</th>
                        <th>Tgl Upload</th>
                        <th>Tgl Kirim</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                          $i=1;
                      @endphp
                      @foreach ($data as $item)
                        <tr>
                          <td>{{ $i++ }}</td>
                          <td>{{ $item->jmlpegawai }}</td>
                          <td>{{ $item->keterangan }}</td>
                          <td class="d-flex">
                            <div class="px-1">
                              <form action="/belanja-51/dokumen-uang-makan/{{ $item->id }}/dokumen" method="post" target="_blank">
                                @csrf
                                @method('patch')
                                <button class="btn btn-sm btn-outline-primary pt-0 pb-0">pdf</i></button>
                              </form>
                            </div>
                            <div class="px-1">
                              <form action="/belanja-51/dokumen-uang-makan/{{ $item->id }}/dokumen-excel" method="post" target="_blank">
                                @csrf
                                @method('patch')
                                <button class="btn btn-sm btn-outline-primary pt-0 pb-0">excel</i></button>
                              </form>
                            </div>
                          <td>
                            @switch($item->terkirim)
                                @case(0)
                                  <span class="text-primary">draft</span>
                                    @break
                                @case(1)
                                  <span class="text-primary">terkirim</span>
                                    @break
                                @case(2)
                                  <span class="text-primary">approve</span>
                                    @break
                                @default
                            @endswitch
                          </td>
                          <td>{{ $item->created_at }}</td>
                          <td>
                            @if ($item->terkirim)
                                {{ $item->updated_at }}
                            @endif
                          </td>
                          <td>
                            @if ($item->terkirim != 0)
                            <form action="/belanja-51/dokumen-uang-makan/{{ $item->id }}" method="post">
                              @csrf
                              @method('DELETE')
                              <button onclick="return confirm('Apakah Anda yakin akan menolak data ini?');" type="submit" class="btn btn-sm btn-outline-danger pt-0 pb-0">tolak</button>
                            </form>
                            @endif
                            @if ($item->terkirim === 1)
                            <form action="/belanja-51/dokumen-uang-makan/{{ $item->id }}/approve" method="post">
                              @csrf
                              @method('PATCH')
                              <button onclick="return confirm('Apakah Anda yakin akan menyimpan data ini?');" type="submit" class="btn btn-sm btn-outline-primary pt-0 pb-0">approve</button>
                            </form>
                            @endif
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