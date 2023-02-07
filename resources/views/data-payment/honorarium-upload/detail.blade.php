@extends('layout.main')
@section('aside-menu')
    @include('data-payment.sidemenu')
@endsection         
@section('main-content')

    <div id="main-content-header">

    </div>
    <div id="main-content">
        <div>
            <div>
                @include('layout.flashmessage')
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
                        <tr class="align-middle">
                            <td class="text-center">{{ $i++ }}</td>
                            <td>{{$item->nama}}</td>
                            <td>{{$item->nip}}</td>
                            <td class="text-right">{{number_format($item->bruto, 2, ',', '.')}}</td>
                            <td class="text-right">{{number_format($item->pph, 2, ',', '.')}}</td>
                            <td class="text-right">{{number_format($item->bruto - $item->pph, 2, ',', '.')}}</td>
                            <td>
                                @can('adm_server', auth()->user()->id)
                                <form action="/data-payment/upload/honorarium/{{ $item->id }}/detail" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');" type="submit" class="btn btn-sm btn-outline-danger pt-0 pb-0">tolak</button>
                                </form>
                                @endcan
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