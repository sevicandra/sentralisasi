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
                <a href="/admin/user/{{$data->nip}}/role" class="btn btn-outline-secondary active mr-1">Kembali</a>
            </div>
        </div>
        <div class="table-warper">
            <table class="table table-bordered table-hover">
                <thead class="text-center">
                    <tr class="align-middle">
                        <th>No</th>
                        <th>Kode Role</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i=1
                    @endphp
                    @foreach ($role as $item)
                        <tr>
                            <td> {{$i}} </td>
                            <td> {{$item->kode}} </td>
                            <td> {{$item->role}} </td>
                            <form action="/admin/user/{{$data->nip}}/role/{{$item->id}}" method="post" onsubmit="return confirm('Apakah Anda yakin akan menambah role ini?');">
                                <td class="pb-0 pr-0">
                                    <div class="btn-group btn-group-sm" role="group">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success pt-0 pb-0" >Tambah</button>
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
        {{-- {{$data->links()}} --}}
    </div>


@endsection