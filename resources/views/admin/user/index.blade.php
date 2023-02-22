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
                <a href="/admin/user/create" class="btn btn-outline-secondary active mr-1">Tambah</a>
            </div>
        </div>
        <div class="table-warper">
            <table class="table table-bordered table-hover">
                <thead class="text-center">
                    <tr class="align-middle">
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Satker</th>
                        <th>No HP</th>
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
                            <td> {{$item->nama}} </td>
                            <td> {{$item->nip}} </td>
                            <td> {{$item->nmsatker}} </td>
                            <td> {{$item->nohp}} </td>
                            <form action="/admin/user/{{$item->nip}}" method="post">
                                <td class="pb-0 pr-0">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="/admin/user/{{$item->nip}}/role" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Role</a>
                                        <a href="/admin/user/{{$item->nip}}/edit" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Ubah</a>
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Apakah Anda yakin akan Menghapus data ini?');" type="submit" class="btn btn-sm btn-outline-danger pt-0 pb-0" >Hapus</button>
                                    </div>
                                </td>
                            </form>
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