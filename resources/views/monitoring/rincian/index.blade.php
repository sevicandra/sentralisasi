@extends('layout.main')
@section('aside-menu')
    @include('monitoring.sidemenu')
@endsection         
@section('main-content')

    <div id="main-content-header">
        <div class="row">
            <div class="row">
                <div class="row">
                    <div class="col-lg-5">
                        <form action="" method="get">
                            <div class="input-group">
                                <input type="text" name="keyword" class="form-control" placeholder="nama atau nip">
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

                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="pb-0 pr-0">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="/monitoring/rincian/penghasilan" class="btn btn-sm btn-outline-secondary pt-0 pb-0" target="_blank">Penghasilan</a>
                                    <a href="/monitoring/rincian/gaji" class="btn btn-sm btn-outline-secondary pt-0 pb-0" target="_blank">Gaji</a>
                                    <a href="/monitoring/rincian/uang-makan" class="btn btn-sm btn-outline-secondary pt-0 pb-0" target="_blank">Uang Makan</a>
                                    <a href="/monitoring/rincian/uang-lembur" class="btn btn-sm btn-outline-secondary pt-0 pb-0" target="_blank">Uang Lembur</a>
                                    <a href="/monitoring/rincian/tunjangan-kinerja" class="btn btn-sm btn-outline-secondary pt-0 pb-0" target="_blank">Tunjangan Kinerja</a>
                                    <a href="/monitoring/rincian/lainnya" class="btn btn-sm btn-outline-secondary pt-0 pb-0" target="_blank">Lainnya</a>
                                </div>
                            </td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div id="paginator">
        {{-- {{$data->links()}} --}}
    </div>


@endsection