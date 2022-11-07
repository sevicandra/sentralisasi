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
                <a href="/admin/bulan/create" class="btn btn-outline-secondary active mr-1">Tambah</a>
            </div>
        </div>
        <div class="table-warper">
            <table class="table table-bordered table-hover">
                <thead class="text-center">
                    <tr class="align-middle">
                        <th>No</th>
                        <th>Bulan</th>
                        <th>Nama Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i=1
                    @endphp
                    @foreach ($data as $item)
                        <tr>
                            <td>{{$i}}</td>
                            <td> {{$item->bulan}} </td>
                            <td> {{$item->nmbulan}} </td>
                            <td class="pb-0 pr-0">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="/admin/bulan/{{$item->id}}/edit" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Ubah</a>
                                </div>
                            </td>
                        </tr>
                        @php
                            $i++
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div id="paginator">
        {{-- {{$data->links()}} --}}
    </div>


@endsection