@extends('layout.main')
@section('aside-menu')
    @include('admin.sidemenu')
@endsection         
@section('main-content')

    <div id="main-content-header">

    </div>
    <div id="main-content">
        <div>
            <div >
                @include('layout.flashmessage')
            </div>
            <div class="card-header">
                <a href="/admin/ref-penandatangan/{{ $kdsatker }}/create" class="btn btn-outline-secondary active mr-1">Tambah</a>
            </div>
        </div>
        <div class="table-warper overflow-auto">
            <table class="table table-bordered table-hover">
                <thead class="text-center">
                    <tr class="align-middle">
                        <th>No</th>
                        <th>Tahun</th>
                        <th>Nama_ttd_skp</th>
                        <th>NIP_ttd_skp</th>
                        <th>Jab_ttd_skp</th>
                        <th>Nama_ttd_kp4</th>
                        <th>NIP_ttd_kp4</th>
                        <th>Jab_ttd_kp4</th>
                        <th>NPWP_bendahara</th>
                        <th>Nama_bendahara</th>
                        <th>NIP_bendahara</th>
                        <th>Tgl_spt</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i=1
                    @endphp
                    @foreach ($data as $item)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$item->tahun}}</td>
                            <td>{{$item->nama_ttd_skp}}</td>
                            <td>{{$item->nip_ttd_skp}}</td>
                            <td>{{$item->jab_ttd_skp}}</td>
                            <td>{{$item->nama_ttd_kp4}}</td>
                            <td>{{$item->nip_ttd_kp4}}</td>
                            <td>{{$item->jab_ttd_kp4}}</td>
                            <td>{{$item->npwp_bendahara}}</td>
                            <td>{{$item->nama_bendahara}}</td>
                            <td>{{$item->nip_bendahara}}</td>
                            <td>{{ date("d-m-Y", $item->tgl_spt) }}</td>
                            <td>
                                <a href="/admin/ref-penandatangan/{{ $kdsatker }}/{{$item->id}}/edit" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Edit</a>
                            </td>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div id="paginator">
        {{-- {{$data->links()}} --}}
    </div>


@endsection