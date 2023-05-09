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
                    @foreach ($tahun as $item)
                      <a href="{{ config('app.url') }}/belanja-51/dokumen-uang-makan/{{ $item }}" class="btn btn-outline-secondary @if ($item === $thn) active @endif mr-1">{{ $item }}</a>
                    @endforeach
                  </div>
                  <div class=" card-body">
                    <div>
                      @foreach ($bulan as $item)
                        <a href="{{ config('app.url') }}/belanja-51/dokumen-uang-makan/{{ $thn }}/{{ $item }}" class="btn btn-outline-secondary @if ($item === $bln) active @endif mb-3 mr-1">{{ $item }}</a>
                      @endforeach
                    </div>
                    <div>
                      @if ($thn && $bln)
                        <a href="{{ config('app.url') }}/belanja-51/dokumen-uang-makan/rekap?thn={{ $thn }}&bln={{ $item }}" class="btn btn-outline-secondary @if ($item === $bln) active @endif mb-3 mr-1">Download Rekap</a>
                      @endif
                    </div>
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
                          @php
                              $i =1;
                              $totpeg=0;
                          @endphp
                          @foreach ($data as $item)
                            <tr>
                              <td>{{ $i++ }}</td>
                              <td>{{ $item->kdsatker }}</td>
                              <td>{{ $item->nmsatker }}</td>
                              <td>{{ $item->dokumenUangMakan($thn, $bln)->count() }}</td>
                              <td>{{ $item->dokumenUangMakan($thn, $bln)->sum('jmlpegawai') }}</td>
                              @php
                                  $totpeg += $item->dokumenUangMakan($thn, $bln)->sum('jmlpegawai');
                              @endphp
                              <td>
                                @if ($item->dokumenUangMakan($thn, $bln)->count()>0)
                                <a href="{{ config('app.url') }}/belanja-51/dokumen-uang-makan/{{ $item->kdsatker }}/{{ $thn }}/{{ $bln }}/detail"><i class="bi bi-filetype-pdf"></i></a>
                                @endif
                              </td>
                              <td>
                                @if ($item->dokumenUangMakan($thn, $bln)->min('terkirim') === 1)
                                  <span class="text-primary">terkirim</span>
                                @elseif($item->dokumenUangMakan($thn, $bln)->min('terkirim') === 0)
                                  <span class="text-danger">draft</span>
                                @else
                                  <span class="text-primary"></span>
                                @endif
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                        <thead>
                          <tr>
                            <th colspan="4">Jumlah</th>
                            <th>{{ $totpeg }}</th>
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