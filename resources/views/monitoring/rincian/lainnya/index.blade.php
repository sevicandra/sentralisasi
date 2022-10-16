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
                    <tr>
                        <th>No</th>
                        <th>Bulan</th>
                        <th>Bruto</th>
                        <th>PPh</th>
                        <th>Netto</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td class="text-center"></td>
                            <td><a href="{{ Request::url() }}/detail">Januari</a>
                            </td>
                            <td class="text-right">
                            </td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                        </tr>
                    <tr>
                        <th colspan="2" class="text-center">Jumlah</th>
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