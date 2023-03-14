@extends('layout.main')
@section('aside-menu')
    @include('data-payment.sidemenu')
@endsection         
@section('main-content')
    <div id="main-content-header">
      @include('layout.flashmessage')
      <div class="row">
        <div class="row">
          <div class="row">
              <div class="col-lg-12">
                @foreach ($tahun as $item)
                  <a href="{{ config('app.url') }}/data-payment/lain?thn={{ $item->tahun }}" class="btn btn-outline-secondary @if (!$thn && $item->tahun === date('Y') || $item->tahun === $thn) active @endif mr-1">{{ $item->tahun }}</a>
                @endforeach
              </div>
          </div>
        </div>
        <div class="row">
          <div class="row">
              <div class="col-lg-12">
                @foreach ($bulan as $item)
                  <a href="{{ config('app.url') }}/data-payment/lain?thn={{ $thn }}&bln={{ $item->bulan }}" class="btn btn-outline-secondary @if (!$bln && $item->bulan === date('m') || $item->bulan === $bln) active @endif mr-1">{{ $item->bulan }}</a>
                @endforeach
              </div>
          </div>
        </div>
      </div>
    </div>
    <div id="main-content">
              <div class="card">
                  <div class="card-header d-flex flex-row-reverse" style="justify-content:space-between">

                    <a href="/data-payment/lain/create" class="btn btn-outline-secondary mr-2" data-toggle="tooltip" data-placement="bottom" title="Tambah"><i class="bi bi-plus"></i></a>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-sm table-bordered table-hover">
                        <thead>
                          <tr class="text-center">
                            <th>No</th>
                            <th>Satker</th>
                            <th>jenis</th>
                            <th>Jml Pegawai</th>
                            <th>Bruto</th>
                            <th>PPh</th>
                            <th>Netto</th>
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
                              <td>{{ $item->nmsatker }}</td>
                              <td>{{ $item->jenis }}</td>
                              <td>{{ $item->jml }}</td>
                              <td class="text-right">{{ number_format($item->bruto,2,',','.') }}</td>
                              <td class="text-right">{{ number_format($item->pph,2,',','.') }}</td>
                              <td class="text-right">{{ number_format($item->bruto-$item->pph,2,',','.') }}</td>
                              <td>
                                <span class="d-flex justify-content-center">
                                  <form action="/data-payment/lain/{{ $item->kdsatker }}/{{ $item->jenis }}/{{ $thn }}/{{ $bln }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');" type="submit" class="btn btn-sm btn-outline-danger pt-0 pb-0">hapus</button>
                                  </form>
                                  <span>
                                    <a href="/data-payment/lain/{{ $item->kdsatker }}/{{ $item->jenis }}/{{ $thn }}/{{ $bln }}/detail" data-toggle="tooltip" data-placement="bottom" title="detail" class="btn btn-sm btn-outline-primary pt-0 pb-0">detail</a>
                                  </span>
                                  <form action="/data-payment/lain/{{ $item->kdsatker }}/{{ $item->jenis }}/{{ $thn }}/{{ $bln }}" method="post">
                                    @csrf
                                    <button type="submit"  onclick="return confirm('Apakah Anda yakin akan mengirim data ini?');" class="btn btn-sm btn-outline-primary pt-0 pb-0">upload</button>
                                  </form>
                                </span>
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