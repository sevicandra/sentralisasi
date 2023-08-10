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
                        <th>Satker</th>
                        <th>Nomor SIP</th>
                        <th>Tanggal SIP</th>
                        <th>TMT</th>
                        <th>Nilai Sewa</th>
                        <th>file</th>
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
                            <td>{{ $item->kdsatker }}</td>
                            <td>{{ $item->nomor_sip }}</td>
                            <td class="text-center">{{ $item->tanggal_sip }}</td>
                            <td class="text-center">{{ $item->tmt }}</td>
                            <td class="text-right">{{ number_format($item->nilai_potongan, 0, ',', '.') }}</td>
                            <td>
                                <form action="/sewa-rumdin/usulan/{{ $item->id }}/dokumen" method="post" target="_blank">
                                    @csrf
                                    @method('patch')
                                    <button class="btn btn-sm btn-outline-primary pt-0 pb-0"><i
                                            class="bi bi-filetype-pdf"></i></button>
                                </form>
                            </td>
                            <td>
                                <form action="/sewa-rumdin/usulan/{{ $item->id }}/approve" method="post" onsubmit="return confirm('Apakah Anda yakin ?');">
                                    @csrf
                                    @method('PATCH')
                                    <div class="btn-group">
                                        <button
                                            type="button"
                                            value="{{ $item->id }}"
                                            
                                            class="btn btn-sm btn-outline-danger pt-0 pb-0 reject-btn"
                                        >
                                            Tolak
                                        </button>
                                        <button
                                            class="btn btn-sm btn-outline-success pt-0 pb-0"
                                        >Approve</button>
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
    <div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="myModal" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
                <form action="" method="POST" id="form-tolak">
                    @csrf
                    @method('PATCH')
                    <div class="row mb-2">
                        <div class="form-group">
                            <label for="">Catatan:</label>
                            <input type="text"
                                class="form-control"
                                name="catatan" required
                            >
                        </div>
                    </div>
                    <div class="row">
                        <div>
                            <button
                                class="btn btn-sm btn-outline-danger"
                            >Tolak</button>
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
            $(".reject-btn").click(function(){
                console.log($(this).val());
                const action = "/sewa-rumdin/usulan/"+ $(this).val() +"/tolak"
                $("#form-tolak").attr("action", action);
                $("#myModal").modal('toggle');
            });
        });
    </script>
@endsection
