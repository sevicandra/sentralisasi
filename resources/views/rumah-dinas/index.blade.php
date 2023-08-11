@extends('layout.main')
@section('aside-menu')
    @include('rumah-dinas.sidemenu')
@endsection
@section('main-content')
    <div id="main-content-header">
        <div class="row">
            <div class="row">
                <div class="row">
                    <div class="col-lg-12">
                        <a href="/sewa-rumdin/create" class="btn btn-sm btn-outline-success ml-1 mt-1 mb-1">
                            Tambah
                        </a>
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
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Nomor SIP</th>
                        <th>Tanggal SIP</th>
                        <th>TMT</th>
                        <th>Nilai Sewa</th>
                        <th>file</th>
                        <th>Status</th>
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
                                <form action="/sewa-rumdin/{{ $item->id }}/dokumen" method="post"
                                    target="_blank">
                                    @csrf
                                    @method('patch')
                                    <button class="btn btn-sm btn-outline-primary pt-0 pb-0"><i
                                            class="bi bi-filetype-pdf"></i></button>
                                </form>
                                @endif
                            </td>
                            <td class="text-center">{{ str_replace('_', ' ',  $item->status) }}</td>
                            <td>
                                @if ($item->status === 'draft')
                                    <form action="sewa-rumdin/{{ $item->id }}/delete" method="post"
                                        onsubmit="return confirm('Apakah Anda yakin akan menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <div class="btn-group">
                                            <a href="sewa-rumdin/{{ $item->id }}/edit"
                                                class="btn btn-sm btn-outline-secondary pt-0 pb-0">Ubah</a>
                                            <button type="submit"
                                                class="btn btn-sm btn-outline-danger pt-0 pb-0">Hapus</button>
                                            <a href="sewa-rumdin/{{ $item->id }}/kirim"
                                                class="btn btn-sm btn-outline-success pt-0 pb-0"
                                                onclick="return confirm('Apakah Anda yakin akan mengirim data ini?');"
                                                >Kirim</a>
                                        </div>
                                    </form>
                                @elseif($item->status === 'aktif')
                                    <button
                                        type="button"
                                        value="{{ $item->id }}"
                                        
                                        class="btn btn-sm btn-outline-danger pt-0 pb-0 non-aktif-btn"
                                    >
                                        Non Aktif
                                    </button>
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
    <div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="myModal" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
                <form action="" method="POST" id="form-non-aktif">
                    @csrf
                    @method('PATCH')
                    <div class="row mb-2">
                        <div class="form-group">
                            <label for="">Alasan Penghentian:</label>
                            <input type="text"
                                class="form-control"
                                name="alasan_penghentian" required
                            >
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="form-group">
                            <label for="">TMT Penghentian:</label>
                            <input type="date"
                                class="form-control"
                                name="tanggal_selesai" required
                            >
                        </div>
                    </div>
                    <div class="row">
                        <div>
                            <button
                                class="btn btn-sm btn-outline-danger"
                            >Kirim</button>
                        </div>
                    </div>
                </form>
            </div>
          </div>
        </div>
    </div>
@endsection

@section('main-footer')
    <script>
        $(document).ready(function(){
            $(".non-aktif-btn").click(function(){
                console.log($(this).val());
                const action = "/sewa-rumdin/"+ $(this).val() +"/non-aktif"
                $("#form-non-aktif").attr("action", action);
                $("#myModal").modal('toggle');
            });
        });
    </script>
@endsection
