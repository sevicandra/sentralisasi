@extends('layout.main')
@section('aside-menu')
    @include('spt.sidemenu')
@endsection
@section('main-content')
    <div id="main-content-header">
        <div class="row">
            <div class="row">
                <div class="row">
                    <div class="col-md-7">
                        @foreach ($tahun as $item)
                            <a href="{{ Request::url() }}?thn={{ $item->tahun }}&search={{ request('search') }}"
                                class="btn btn-sm btn-outline-success @if ($item->tahun === $thn) active @endif ml-1 mt-1 mb-1">{{ $item->tahun }}</a>
                        @endforeach
                    </div>
                    <div class="col-md-5">
                        <form action="" method="get">
                            @if (request('thn'))
                                <input type="text" name="thn" class="form-control" hidden
                                    value="{{ request('thn') }}">
                            @endif
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="NIP">
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
            <div>
                @include('layout.flashmessage')
            </div>
        </div>
        <div class="table-warper">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr class="text-center align-middle">
                        <th>No</th>
                        {{-- <th>Nama</th> --}}
                        <th>NIP</th>
                        <th>NPWP</th>
                        <th>Gol.</th>
                        <th>Alamat</th>
                        <th>Kd. Kawin</th>
                        <th>Jabatan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                @php
                    $i = 1;
                @endphp
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td class="text-center">{{ $i++ }}</td>
                            {{-- <td>{{ $item->nmpeg }}</td> --}}
                            <td>{{ $item->nip }}</td>
                            <td>{{ $item->npwp }}</td>
                            <td class="text-center">{{ $item->nama_pangkat }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td class="text-center">{{ $item->kdkawin }}</td>
                            <td>{{ $item->nama_jabatan }}</td>
                            <td>
                                <form action="/spt-monitoring/{{ $kdsatker }}/{{ $item->id }}" method="post"
                                    onsubmit="return confirm('Apakah Anda yakin akan menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <div class="btn-group">
                                        <a href="/spt-monitoring/{{ $kdsatker }}/{{ $item->id }}/edit"
                                            class="btn btn-sm btn-outline-secondary pt-0 pb-0">Ubah</a>
                                        <button type="submit"
                                            class="btn btn-sm btn-outline-danger pt-0 pb-0">Hapus</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div id="paginator">
        {{ $data->links() }}
    </div>
@endsection
