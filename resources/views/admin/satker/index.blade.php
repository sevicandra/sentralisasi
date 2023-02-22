@extends('layout.main')
@section('aside-menu')
    @include('admin.sidemenu')
@endsection         
@section('main-content')

    <div id="main-content-header">
        <div class="row">
            <div class="row">
                <div class="col-lg-5">
                    <form action="" method="get">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="" value="{{ request('search') }}">
                            <button class="btn btn-sm btn-outline-secondary" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="main-content">
        <div>
            <div >
                @include('layout.flashmessage')
            </div>
            <div class="card-header">
                <a href="/admin/satker/create" class="btn btn-outline-secondary active mr-1">Tambah</a>
            </div>
        </div>
        <div class="table-warper">
            <table class="table table-bordered table-hover">
                <thead class="text-center">
                    <tr class="align-middle">
                        <th>No</th>
                        <th>Kode Satker</th>
                        <th>Nama Satker</th>
                        <th>Kode Koordinator</th>
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
                            <td> {{$item->kdsatker}} </td>
                            <td> {{$item->nmsatker}} </td>
                            <td> {{$item->kdkoordinator}} </td>
                            <td class="pb-0 pr-0">
                                <div class="btn-group btn-group-sm" role="group">
                                    <div>
                                        <a href="/admin/satker/{{$item->kdsatker}}/edit" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Ubah</a>
                                    </div>
                                    <form action="/admin/satker/{{$item->kdsatker}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger pt-0 pb-0">Hapus</button>
                                    </form>
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
        {{$data->links()}}
    </div>


@endsection