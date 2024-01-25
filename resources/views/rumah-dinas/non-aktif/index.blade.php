@extends('layout.main')
@section('aside-menu')
    @include('rumah-dinas.sidemenu')
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
        <div class="table-warper">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr class="text-center align-middle">
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Nomor SIP</th>
                        <th>Tanggal SIP</th>
                        <th>TMT</th>
                        <th>Tanggal Kirim</th>
                        <th>TMT Penghentian</th>
                        <th>Tanggal Usulan Non Aktif</th>
                        <th>Alasan Penghentian</th>
                        <th>Nilai Sewa</th>
                        <th>file</th>
                    </tr>
                </thead>
                @php
                    $i = 1;
                @endphp
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td class="text-center">{{ $i++ }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->nip }}</td>
                            <td>{{ $item->nomor_sip }}</td>
                            <td class="text-center">{{ $item->tanggal_sip }}</td>
                            <td class="text-center">{{ $item->tmt }}</td>
                            <td class="text-center">{{ $item->tanggal_kirim }}</td>
                            <td class="text-center">{{ $item->tanggal_selesai }}</td>
                            <td class="text-center">{{ $item->tanggal_usulan_non_aktif }}</td>
                            <td class="text-center">{{ $item->alasan_penghentian }}</td>
                            <td class="text-right">{{ number_format($item->nilai_potongan, 0, ',', '.') }}</td>
                            <td>
                                @if ($item->file)
                                <form action="/sewa-rumdin/{{ $item->id }}/dokumen" method="post"
                                    target="_blank">
                                    @csrf
                                    @method('patch')
                                    <button class="btn btn-sm btn-outline-primary pt-0 pb-0"><i
                                            class="bi bi-filetype-pdf"></i></button>
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