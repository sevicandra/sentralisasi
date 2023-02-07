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
                <div class="col-lg-5">
                    <form action="" method="get" autocomplete="off">
                        <div class="input-group">
                            <input type="text" name="nip" class="form-control" placeholder="nip">
                            <input type="text" name="tahun" class="form-control" placeholder="tahun">
                            <button class="btn btn-sm btn-outline-secondary" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
      </div>
    </div>
    <div id="main-content">
      <div class="card">
        <div class="card-header" style="display: flex; justify-content:space-between">
        
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-sm table-bordered table-hover">
              <thead>
                <tr>
                  <th class="text-center">No</th>
                  @canany(['adm_server'], auth()->user()->id)
                  <th class="text-center">ID</th>
                  @endcan
                  <th class="text-center">Bulan</th>
                  <th class="text-center">Tahun</th>
                  <th class="text-center">NIP</th>
                  <th class="text-center">bruto</th>
                  <th class="text-center">pph</th>
                  <th class="text-center">netto</th>
                  <th class="text-center">jenis</th>
                  <th class="text-center">uraian</th>
                  <th class="text-center">tanggal</th>
                  <th class="text-center">nospm</th>
                  @canany(['adm_server'], auth()->user()->id)
                  <th class="text-center">#</th>
                  @endcan
                </tr>
              </thead>
              <tbody>
                @php
                    $i=1;
                @endphp
                @foreach ($data as $item)
                  <tr>
                    <td>{{ $i++ }}</td>
                    @canany(['adm_server'], auth()->user()->id)
                    <td>{{ $item->id }}</td>
                    @endcan
                    <td>{{ $item->bulan }}</td>
                    <td>{{ $item->tahun }}</td>
                    <td>{{ $item->nip }}</td>
                    <td class="text-right">{{ number_format($item->bruto,2, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->pph,2, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->netto,2, ',', '.') }}</td>
                    <td>{{ $item->jenis }}</td>
                    <td>{{ $item->uraian }}</td>
                    <td>{{ date('d-m-Y',$item->tanggal) }}</td>
                    <td>{{ $item->nospm }}</td>
                    @canany(['adm_server'], auth()->user()->id)
                    <td>
                      <span class="d-flex" style="gap:2px">
                        <span>
                          <a href="/data-payment/server/{{ $item->id }}/edit" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Ubah</a>
                        </span>
                        <form action="/data-payment/server/{{ $item->id }}" method="post">
                          @csrf
                          @method('DELETE')
                          <button onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');" type="submit" class="btn btn-sm btn-outline-danger pt-0 pb-0">Hapus</button>
                        </form>
                      </span>
                    </td>
                    @endcan
                  </tr>
                @endforeach
              </tbody>
            </table>            
          </div>
        </div>
      </div>

    </div>
    <div id="paginator">
        {{$data->links()}}
    </div>


@endsection