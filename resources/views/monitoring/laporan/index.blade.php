@extends('layout.main')
@section('aside-menu')
    @include('monitoring.sidemenu')
@endsection         
@section('main-content')

    <div id="main-content-header">
        <div class="row">
            <div class="row">
                <div class="row">
                    <div class="col-md-5">
                        <select class="form-control" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                            @foreach ($status as $item)
                            <option value="?status={{ $item }} @if (request('search'))&search={{ request('search') }} @endif" @if (request('status') === $item) selected  @endif>
                                {{ $item }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <form action="" method="get">
                            @if (request('status'))
                                <input type="text" name="status" class="form-control" hidden value="{{ request('status') }}">
                            @endif
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Nama/NIP">
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
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $item->Nip18 }}</td>
                            <td>{{ $item->Nama }}</td>
                            <td class="pb-0 pr-0">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ config('app.url') }}/monitoring/laporan/profil/{{ $item->Nip18 }}" class="btn btn-sm btn-outline-secondary pt-0 pb-0" target="_blank">Profil</a>
                                    <a href="{{ config('app.url') }}/monitoring/laporan/pph-pasal-21/{{ $item->Nip18 }}" class="btn btn-sm btn-outline-secondary pt-0 pb-0" target="_blank">PPh Pasal 21</a>
                                    <a href="{{ config('app.url') }}/monitoring/laporan/pph-pasal-21-final/{{ $item->Nip18 }}" class="btn btn-sm btn-outline-secondary pt-0 pb-0" target="_blank">PPh Pasal 21 Final</a>
                                    <a href="{{ config('app.url') }}/monitoring/laporan/penghasilan-tahunan/{{ $item->Nip18 }}" class="btn btn-sm btn-outline-secondary pt-0 pb-0" target="_blank">Penghasilan Tahunan</a>
                                    {{-- <a href="/monitoring/laporan/dokumen-perubahan" class="btn btn-sm btn-outline-secondary pt-0 pb-0" target="_blank">Dokumen Perubahan</a> --}}
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