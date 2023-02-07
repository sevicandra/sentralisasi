@extends('layout.main')
@section('aside-menu')
    @include('data-payment.sidemenu')
@endsection         
@section('main-content')
    <div id="main-content-header">
        @include('layout.flashmessage')
        <div class="row">
            <div class="row">
                <div class="col-lg-12">
                    <a href="{{ config('app.url') }}/data-payment/lain" class="btn btn-outline-secondary mr-1">Kembali</a>
                </div>
            </div>
        </div>
    </div>
    <div id="main-content">
        <div>
            <div>
                
            </div>
        </div>
        <div class="table-warper" style="overflow-x:auto">
            <table class="table table-bordered table-hover">
                <thead class="text-center">
                    <tr class="align-middle">
                        <th>No.</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Bruto</th>
                        <th>PPh</th>
                        <th>Netto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i=1;
                    @endphp
                    @foreach ($data as $item)            
                        <tr class="align-middle text-center">
                            <td>{{ $i++ }}</td>
                            <td class="text-left">{{$item->nama}}</td>
                            <td>{{$item->nip}}</td>
                            <td class="text-right">{{number_format($item->bruto, 2, ',', '.')}}</td>
                            <td class="text-right">{{number_format($item->pph, 2, ',', '.')}}</td>
                            <td class="text-right">{{number_format($item->bruto - $item->pph, 2, ',', '.')}}</td>
                            <td>
                                <span class="d-flex justify-content-center">
                                    <form action="/data-payment/lain/{{ $item->id }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');" type="submit" class="btn btn-sm btn-outline-danger pt-0 pb-0">hapus</button>
                                    </form>
                                    <span>
                                        <a href="/data-payment/lain/{{ $item->id }}/edit" data-toggle="tooltip" data-placement="bottom" title="Ubah" class="btn btn-sm btn-outline-primary pt-0 pb-0">ubah</a>
                                    </span>
                                    <form action="/data-payment/lain/{{ $item->id }}" method="post">
                                        @csrf
                                        <button onclick="return confirm('Apakah Anda yakin akan mengirim data ini?');"  class="btn btn-sm btn-outline-primary pt-0 pb-0" type="submit">upload</button>
                                    </form>
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div id="paginator">
        {{$data->links()}}
    </div>


@endsection