@extends('layout.main')
@section('aside-menu')
    @include('monitoring.sidemenu')
@endsection         
@section('main-content')

    <div id="main-content-header">
        <div class="row">
            <div class="row">
                <div class="row">
                    <div class="col-lg-5">
                        <form action="" method="get">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="nip">
                                <button class="btn btn-sm btn-outline-secondary" type="submit">Cari</button>
                            </div>
                        </form>
                    </div>
                </div>
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
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i=1;
                    @endphp
                    @if (request('page'))
                        @php
                            $i=(request('page')-1)*15+1
                        @endphp
                    @endif
                    @foreach ($data as $item)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $item->Nip18 }}</td>
                        <td>{{ $item->Nama }}</td>
                        <td class="pb-0 pr-0">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ Request::url() }}/{{ $item->Nip18 }}/penghasilan" class="btn btn-sm btn-outline-secondary pt-0 pb-0" target="_blank">Penghasilan</a>
                                <a href="{{ Request::url() }}/{{ $item->Nip18 }}/gaji" class="btn btn-sm btn-outline-secondary pt-0 pb-0" target="_blank">Gaji</a>
                                <a href="{{ Request::url() }}/{{ $item->Nip18 }}/uang-makan" class="btn btn-sm btn-outline-secondary pt-0 pb-0" target="_blank">Uang Makan</a>
                                <a href="{{ Request::url() }}/{{ $item->Nip18 }}/uang-lembur" class="btn btn-sm btn-outline-secondary pt-0 pb-0" target="_blank">Uang Lembur</a>
                                <a href="{{ Request::url() }}/{{ $item->Nip18 }}/tunjangan-kinerja" class="btn btn-sm btn-outline-secondary pt-0 pb-0" target="_blank">Tunjangan Kinerja</a>
                                <a href="{{ Request::url() }}/{{ $item->Nip18 }}/lainnya" class="btn btn-sm btn-outline-secondary pt-0 pb-0" target="_blank">Lainnya</a>
                            </div>
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