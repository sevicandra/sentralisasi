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
                                <input type="text" name="search" class="form-control" placeholder="Kode atau Nama Satker">
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
                        <th>Kode</th>
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
                                    <a href="/monitoring/pelaporan/satker" class="btn btn-sm btn-outline-secondary pt-0 pb-0" target="_blank">Pegawai</a>
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