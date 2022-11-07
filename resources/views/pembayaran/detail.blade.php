@extends('layout.main')
@section('aside-menu')
    @include('pembayaran.sidemenu')
@endsection         
@section('main-content')

    <div id="main-content-header">
        <div class="row">
            <div class="col-lg-12">
                <a href="/pembayaran/index/{{ $thn }}" class="btn btn-sm btn-outline-success ml-1 mt-1 mb-2">Kembali ke halaman sebelumnya</a>
            </div>
        </div>
    </div>
    <div id="main-content">
        <div>
            <div >
                @include('layout.flashmessage')
            </div>
        </div>
        <div class="table-warper">
                <table class="table table-bordered table-hover">
                    <thead class="text-center">
                        <tr class="align-middle">
                            <th>No</th>
                            <th>Uraian</th>
                            <th>Tgl</th>
                            <th>File</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i=1;
                        @endphp
                        @foreach ($data as $item)
                            <tr class="align-middle">
                                <td>{{ $i++ }}</td>
                                <td>{{ $item->keterangan }}</td>
                                <td>{{ $item->updated_at }}</td>
                                <td>
                                    <a href="{{ Storage::url($item->file) }}" target="_blank" class="btn btn-sm btn-outline-primary pt-0 pb-0">
                                        <i class="bi bi-filetype-pdf"></i>
                                    </a>    
                                </td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                </table>
        </div>
    </div>
    <div id="paginator">
        {{-- {{$data->links()}} --}}
    </div>


@endsection