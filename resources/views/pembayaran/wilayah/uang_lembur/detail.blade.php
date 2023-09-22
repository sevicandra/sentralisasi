@extends('layout.main')
@section('aside-menu')
    @include('pembayaran.sidemenu')
@endsection         
@section('main-content')
    <div id="main-content-header">
      <div class="row">
        <div class="col-lg-12">
          <a href="/belanja-51/wilayah/uang-lembur/{{ $thn }}/{{ $bln }}" class="btn btn-sm btn-outline-success ml-1 mt-1 mb-2">Kembali ke halaman sebelumnya</a>
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
                              <form action="/belanja-51/wilayah/uang-lembur/{{ $item->id }}/dokumen" method="post" target="_blank">
                                @csrf
                                @method('patch')
                                <button class="btn btn-sm btn-outline-primary pt-0 pb-0"><i class="bi bi-filetype-pdf"></i></button>
                              </form>
                            </div>
                            <div class="px-1">
                              <form action="/belanja-51/wilayah/uang-lembur/{{ $item->id }}/dokumen-excel" method="post" target="_blank">
                                @csrf
                                @method('patch')
                                <button class="btn btn-sm btn-outline-primary pt-0 pb-0"><i class="bi bi-filetype-xls"></i></button>
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