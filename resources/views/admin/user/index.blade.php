@extends('layout.main')
@section('aside-menu')
    @include('monitoring.sidemenu')
@endsection         
@section('main-content')

    <div id="main-content-header">

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
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>No HP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td>1.</td>
                            <td>Sevi Candra Sunarso</td>
                            <td>199606202018011002</td>
                            <td>081299084970</td>
                            <td class="pb-0 pr-0">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="/monitoring/penghasilan/satker" class="btn btn-sm btn-outline-secondary pt-0 pb-0" target="_blank">Pegawai</a>
                                </div>
                            </td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div id="paginator">
        {{-- {{$data->links()}} --}}
    </div>


@endsection