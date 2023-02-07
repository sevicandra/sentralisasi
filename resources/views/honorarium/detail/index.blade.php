@extends('layout.main')
@section('aside-menu')
    @include('honorarium.sidemenu')
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
                        <tr class="align-middle text-center">
                            <td>{{ $i++ }}</td>
                            <td class="text-left">{{$item->nama}}</td>
                            <td>{{$item->nip}}</td>
                            <td class="text-right">{{number_format($item->bruto, 2, ',', '.')}}</td>
                            <td class="text-right">{{number_format($item->pph, 2, ',', '.')}}</td>
                            <td class="text-right">{{number_format($item->bruto - $item->pph, 2, ',', '.')}}</td>
                            <td>
                                @if ($item->sts === '0')
                                <form action="/honorarium/hapus-detail/{{ $item->id }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a href="/honorarium/edit-detail/{{ $item->id }}" data-toggle="tooltip" data-placement="bottom" title="Ubah" class="btn btn-sm btn-outline-primary pt-0 pb-0">ubah</a>
                                    <a href="/honorarium/kirim-detail/{{ $item->id }}" data-toggle="tooltip" data-placement="bottom" title="Kirim" onclick="return confirm('Apakah Anda yakin akan mengirim data ini?');"  class="btn btn-sm btn-outline-primary pt-0 pb-0">kirim</a>
                                    <button onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');" type="submit" class="btn btn-sm btn-outline-danger pt-0 pb-0">hapus</button>
                                </form>
                                @endif
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