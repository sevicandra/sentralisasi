@extends('layout.main')
@section('aside-menu')
    @include('monitoring.sidemenu')
@endsection         
@section('main-content')
    <div id="main-content-header">
        <div class="row">
            <div class="row">
                <div class="row">
                    <div class="col-lg-12">
                        <a href="" class="btn btn-sm btn-outline-success active ml-1 mt-1 mb-1">Tahun Ini</a>
                        <a href="" class="btn btn-sm btn-outline-success active ml-1 mt-1 mb-1">Tahun Lalu</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="main-content">
        <div class="table-warper">
            <table class="table table-bordered table-hover">
                <thead class="text-center">
                    <tr class="align-middle">
                        <th>No</th>
                        <th>Bulan</th>
                        <th>Gaji</th>
                        <th>Uang Makan</th>
                        <th>Uang Lembur</th>
                        <th>Tunjangan Kinerja</th>
                        <th>Total</th>
                        <th>Cetak</th>
                    </tr>
                </thead>
                <tbody>
                        <tr class="align-middle">
                            <td class="text-center"></td>
                            <td></td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="pb-0 pt-0">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="/monitoring/rincian/penghasilan/surat" class="btn btn-sm btn-outline-success pt-0 pb-0">Surat</a>
                                    <a href="/monitoring/rincian/penghasilan/daftar" class="btn btn-sm btn-outline-success pt-0 pb-0">Daftar</a>
                                </div>
                            </td>
                        </tr>
                    <tr>
                        <th colspan="2" class="text-center">Jumlah</th>
                        <th class="text-right"></th>
                        <th class="text-right"></th>
                        <th class="text-right"></th>
                        <th class="text-right"></th>
                        <th class="text-right"></th>
                        <th></th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div id="paginator">
        {{-- {{$data->links()}} --}}
    </div>


@endsection