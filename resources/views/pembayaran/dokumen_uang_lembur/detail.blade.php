@extends('layout.main')
@section('aside-menu')
    @include('pembayaran.sidemenu')
@endsection         
@section('main-content')
    <div id="main-content-header">
      <div class="row">
        <div class="col-lg-12">
          <a href="/pembayaran/dokumen-uang-lembur/{{ $thn }}/{{ $bln }}" class="btn btn-sm btn-outline-success ml-1 mt-1 mb-2">Kembali ke halaman sebelumnya</a>
        </div>
        @include('layout.flashmessage')
      </div>
    </div>
    <div id="main-content">
      <div class="row">
        <div class="col-lg-8">
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
                          <td>
                            <a href="{{ Storage::url($item->file) }}" target="_blank" class="btn btn-sm btn-outline-primary pt-0 pb-0">
                              <i class="bi bi-filetype-pdf"></i>
                            </a>    
                          <td>
                            @if ($item->terkirim)
                            <span class="text-primary">terkirim</span>
                            @else
                            <span class="text-primary">draft</span>
                            @endif
                          </td>
                          <td>{{ $item->created_at }}</td>
                          <td>
                            @if ($item->terkirim)
                                {{ $item->updated_at }}
                            @endif
                          </td>
                          <td>
                            @if ($item->terkirim)
                            <form action="/pembayaran/dokumen-uang-lembur/{{ $item->id }}" method="post">
                              @csrf
                              @method('DELETE')
                              <button onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');" type="submit" class="btn btn-sm btn-outline-danger pt-0 pb-0"><i class="bi bi-send-x"></i></button>
                            </form>ß
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