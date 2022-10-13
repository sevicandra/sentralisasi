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
        <div class="table-warper" style="overflow-x:auto">
            <table class="table table-bordered table-hover">
                <thead class="text-center">
                    <tr class="align-middle">
                        <th rowspan="2">No</th>
                        <th rowspan="2">Bulan</th>
                        <th colspan="3">Bruto</th>
                        <th>Potongan</th>
                        <th rowspan="2">Netto</th>
                    </tr>
                    <tr class="align-middle">
                        <th>Jml Hari</th>
                        <th>Tarif</th>
                        <th>Jumlah</th>
                        <th>PPh Final</th>
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
                        </tr>

                    <tr class="align-middle">
                        <th colspan="2" class="text-center">Jumlah</th>
                        <th class="text-right"></th>
                        <th class="text-right"></th>
                        <th class="text-right"></th>
                        <th class="text-right"></th>
                        <th class="text-right"></th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div id="paginator">
        {{-- {{$data->links()}} --}}
    </div>


@endsection