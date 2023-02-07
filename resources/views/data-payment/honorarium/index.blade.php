@extends('layout.main')
@section('aside-menu')
    @include('data-payment.sidemenu')
@endsection         
@section('main-content')
    <div id="main-content-header">
      @include('layout.flashmessage')
    </div>
    <div id="main-content">

              <div class="card">
                  <div class="card-header" style="display: flex; justify-content:space-between">

                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-sm table-bordered table-hover">
                        <thead>
                          <tr class="text-center">
                            <th>No</th>
                            <th>Tahun</th>
                            <th>Bulan</th>
                            <th>Kode Satker</th>
                            <th>Jml Pegawai</th>
                            <th>Bruto</th>
                            <th>PPh</th>
                            <th>Netto</th>
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
                              <td class="text-center">{{ $i++ }}</td>
                              <td>{{ $item->tahun }}</td>
                              <td>{{ $item->nmbulan }}</td>
                              <td class="text-center">{{ $item->kdsatker }}</td>
                              <td class="text-center">{{ $item->jmh }}</td>
                              <td class="text-right">{{ number_format($item->bruto,2, ',', '.') }}</td>
                              <td class="text-right">{{ number_format($item->pph,2, ',', '.') }}</td>
                              <td class="text-right">{{ number_format($item->bruto-$item->pph,2, ',', '.') }}</td>
                              <td>
                                <form action="/data-payment/honorarium/{{$item->file}}/dokumen" method="post" target="_blank">
                                  @csrf
                                  @method('patch')
                                  <button class="btn btn-sm btn-outline-primary pt-0 pb-0"><i class="bi bi-filetype-pdf"></i></button>
                                </form>
                              </td>
                              <td>
                                <form action="/data-payment/honorarium/{{ $item->file }}" method="post">
                                  @csrf
                                  @method('DELETE')
                                  <button onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');" type="submit" class="btn btn-sm btn-outline-danger pt-0 pb-0">tolak</button>
                                  <a href="/data-payment/honorarium/{{ $item->file }}/detail" data-toggle="tooltip" data-placement="bottom" title="detail" class="btn btn-sm btn-outline-primary pt-0 pb-0">detail</a>
                                  <a href="/data-payment/honorarium/{{ $item->file }}/upload" data-toggle="tooltip" data-placement="bottom" title="upload" onclick="return confirm('Apakah Anda yakin akan mengirim data ini?');" class="btn btn-sm btn-outline-primary pt-0 pb-0">upload</a>
                                </form>
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