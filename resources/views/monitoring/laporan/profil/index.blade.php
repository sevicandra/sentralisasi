@extends('layout.main')
@section('aside-menu')
    @include('monitoring.sidemenu')
@endsection         
@section('main-content')

    <div id="main-content-header">
    </div>
    <div id="main-content">
        <div class="row">
            <div class="col-lg-6">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="text-center">
                            <tr>
                                <th colspan="2">Data Pegawai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>NIP</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>TTL</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Pangkat/ Gol</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td> ( Anak)</td>
                            </tr>
                            <tr>
                                <td>Jabatan</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Masa Kerja</td>
                                <td> tahun</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="text-center">
                                    <tr>
                                        <th colspan="5">Data Keluarga</th>
                                    </tr>
                                    <tr class="align-middle">
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Tgl Lahir</th>
                                        <th>Status</th>
                                        <th>Tunjangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr class="align-middle">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
    
                                    <tr>
                                        <td colspan="5"><a href="{{ Request::url() }}/kp4" class="btn btn-sm btn-outline-success pt-0 pb-0">Download KP4</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="text-center">
                                    <tr>
                                        <th colspan="5">Data Rekening</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Nomor</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Bank</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Atas Nama</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>NPWP</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="paginator">
        {{-- {{$data->links()}} --}}
    </div>


@endsection