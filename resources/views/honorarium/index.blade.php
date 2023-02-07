@extends('layout.main')
@section('aside-menu')
    @include('honorarium.sidemenu')
@endsection         
@section('main-content')
    <div id="main-content-header">
      @include('layout.flashmessage')
    </div>
    <div id="main-content">

              <div class="card">
                  <div class="card-header" style="display: flex; justify-content:space-between">
                    <div>
                        @foreach ($tahun as $item)
                          <a href="{{ config('app.url') }}/honorarium/{{ $item->tahun }}" class="btn btn-outline-secondary @if (!$thn && $item->tahun === date('Y') || $item->tahun === $thn) active @endif mr-1">{{ $item->tahun }}</a>
                        @endforeach
                    </div>
                    <a href="/honorarium/create" class="btn btn-outline-secondary mr-2" data-toggle="tooltip" data-placement="bottom" title="Tambah"><i class="bi bi-plus"></i></a>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-sm table-bordered table-hover">
                        <thead>
                          <tr class="text-center">
                            <th>No</th>
                            <th>Bulan</th>
                            <th>Jml Pegawai</th>
                            <th>Bruto</th>
                            <th>PPh</th>
                            <th>Netto</th>
                            <th>Status</th>
                            <th>File</th>
                            <th>#</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php
                              $i=1;
                          @endphp
                          @foreach ($data as $item)
                            <tr class="text-center">
                              <td>{{ $i++ }}</td>
                              <td class="text-left">{{ $item->nmbulan }}</td>
                              <td>{{ $item->jmh }}</td>
                              <td class="text-right">{{ number_format($item->bruto,2, ',', '.') }}</td>
                              <td class="text-right">{{ number_format($item->pph,2, ',', '.') }}</td>
                              <td class="text-right">{{ number_format($item->bruto-$item->pph,2, ',', '.') }}</td>
                              <td class="@switch($item->minSts) @case(0) text-danger @break @case(1) text-success @break @case(2) text-primary @break @default text-danger @endswitch">
                                @switch( $item->minSts)
                                    @case(0)
                                        draft
                                        @break
                                    @case(1)
                                        Send
                                        @break
                                      @case(2)
                                        Uploaded
                                        @break
                                    @default
                                        draft
                                @endswitch
                              </td>
                              <td>
                                <form action="/honorarium/{{$item->file}}/dokumen" method="post" target="_blank">
                                  @csrf
                                  @method('patch')
                                  <button class="btn btn-sm btn-outline-primary pt-0 pb-0"><i class="bi bi-filetype-pdf"></i></button>
                                </form>
                              </td>
                              <td>
                                @if ($item->where('file', $item->file)->max('sts') === '0')
                                <form action="/honorarium/{{ $item->file }}" method="post">
                                  @csrf
                                  @method('DELETE')
                                  <button onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');" type="submit" class="btn btn-sm btn-outline-danger pt-0 pb-0">hapus</button>
                                  <a href="/honorarium/{{ $item->file }}/edit" data-toggle="tooltip" data-placement="bottom" title="Ubah" class="btn btn-sm btn-outline-primary pt-0 pb-0">ubah</a>
                                  <a href="/honorarium/{{ $item->file }}/detail" data-toggle="tooltip" data-placement="bottom" title="detail" class="btn btn-sm btn-outline-primary pt-0 pb-0">detail</a>
                                  <a href="/honorarium/{{ $item->file }}/kirim" data-toggle="tooltip" data-placement="bottom" title="Kirim" onclick="return confirm('Apakah Anda yakin akan mengirim data ini?');" class="btn btn-sm btn-outline-primary pt-0 pb-0">kirim</a>
                                </form>
                                @elseif($item->where('file', $item->file)->min('sts') === '0')
                                  <a href="/honorarium/{{ $item->file }}/kirim" data-toggle="tooltip" data-placement="bottom" title="Kirim" onclick="return confirm('Apakah Anda yakin akan mengirim data ini?');" class="btn btn-sm btn-outline-primary pt-0 pb-0">kirim</a>
                                  <a href="/honorarium/{{ $item->file }}/detail" data-toggle="tooltip" data-placement="bottom" title="detail" class="btn btn-sm btn-outline-primary pt-0 pb-0">detail</a>
                                @else
                                  <a href="/honorarium/{{ $item->file }}/detail" data-toggle="tooltip" data-placement="bottom" title="detail" class="btn btn-sm btn-outline-primary pt-0 pb-0">detail</a>
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
    <div id="paginator">
        {{-- {{$data->links()}} --}}
    </div>


@endsection