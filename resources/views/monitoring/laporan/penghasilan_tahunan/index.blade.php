@extends('layout.main')
@section('aside-menu')
    @include('monitoring.sidemenu')
@endsection         
@section('main-content')

    <div id="main-content-header">
        <div class="row">
            <div class="row">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <div class="col-lg-5">
                        <h1 class="h3">Penghasilan Tahunan</h1>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-8">
                        <a href="" class="btn btn-sm btn-outline-success ml-1 mt-1 mb-1">2022</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="main-content">
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="text-center">
                            <tr class="align-middle">
                                <th rowspan="2">No</th>
                                <th rowspan="2">Bulan</th>
                                <th colspan="3">Gaji</th>
                                <th colspan="3">Uang Makan</th>
                                <th colspan="3">Uang Lembur</th>
                                <th colspan="3">Tunjangan Kinerja</th>
                                <th colspan="3">Total</th>
                                <th rowspan="2">Cetak</th>
                            </tr>
                            <tr class="align-middle">
                                <th>Bruto</th>
                                <th>Pot</th>
                                <th>Netto</th>
                                <th>Bruto</th>
                                <th>Pot</th>
                                <th>Netto</th>
                                <th>Bruto</th>
                                <th>Pot</th>
                                <th>Netto</th>
                                <th>Bruto</th>
                                <th>Pot</th>
                                <th>Netto</th>
                                <th>Bruto</th>
                                <th>Pot</th>
                                <th>Netto</th>
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
                                    <td class="text-right"></td>
                                    <td class="text-right"></td>
                                    <td class="text-right"></td>
                                    <td class="text-right"></td>
                                    <td class="text-right"></td>
                                    <td class="text-right"></td>
                                    <td class="text-right"></td>
                                    <td class="text-right"></td>
                                    <td class="text-right"></td>
                                    <td class="text-right"></td>
                                    <td class="pb-0 pt-0">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="/monitoring/laporan/penghasilan-tahunan/surat" class="btn btn-sm btn-outline-success pt-0 pb-0">Surat</a>
                                            <a href="/monitoring/laporan/penghasilan-tahunan/daftar" class="btn btn-sm btn-outline-success pt-0 pb-0">Daftar</a>
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
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
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
        </div>
    </div>
    <div id="paginator">
        {{-- {{$data->links()}} --}}
    </div>


@endsection