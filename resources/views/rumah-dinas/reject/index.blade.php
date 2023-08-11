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
                        <th>Nilai Sewa</th>
                        <th>file</th>
                        <th>Catatan</th>
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
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->nip }}</td>
                            <td>{{ $item->nomor_sip }}</td>
                            <td class="text-center">{{ $item->tanggal_sip }}</td>
                            <td class="text-center">{{ $item->tmt }}</td>
                            <td class="text-right">{{ number_format($item->nilai_potongan, 0, ',', '.') }}</td>
                            <td>
                                @if ($item->file)
                                <form action="/sewa-rumdin/reject/{{ $item->id }}/dokumen" method="post"
                                    target="_blank">
                                    @csrf
                                    @method('patch')
                                    <button class="btn btn-sm btn-outline-primary pt-0 pb-0"><i
                                            class="bi bi-filetype-pdf"></i></button>
                                </form>
                                @endif
                            </td>
                            <td class="text-center">{{ $item->catatan }}</td>
                            <td>

                                <form action="/sewa-rumdin/reject/{{ $item->id }}/delete" method="post"
                                    onsubmit="return confirm('Apakah Anda yakin akan menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <div class="btn-group">
                                        <a href="/sewa-rumdin/reject/{{ $item->id }}/edit"
                                            class="btn btn-sm btn-outline-secondary pt-0 pb-0">Ubah</a>
                                        <button type="submit"
                                            class="btn btn-sm btn-outline-danger pt-0 pb-0">Hapus</button>
                                        <a href="/sewa-rumdin/reject/{{ $item->id }}/kirim"
                                            class="btn btn-sm btn-outline-success pt-0 pb-0"
                                            onclick="return confirm('Apakah Anda yakin akan mengirim data ini?');"
                                            >Kirim</a>
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
        {{$data->links()}}
    </div>
@endsection
