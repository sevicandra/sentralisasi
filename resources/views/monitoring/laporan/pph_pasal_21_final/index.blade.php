@extends('layout.main')
@section('aside-menu')
    @include('monitoring.sidemenu')
@endsection         
@section('main-content')

    <div id="main-content-header">
        <div class="row">
            <div class="row">
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
            <div class="col-lg-8">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Jenis Pembayaran</th>
                                <th>Jumlah Bruto</th>
                                <th>PPh Final</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Uang Makan</td>
                                <td class="text-right"></td>
                                <td class="text-right"></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Uang Lembur</td>
                                <td class="text-right"></td>
                                <td class="text-right"></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="{{ Request::url() }}/cetak" class="btn btn-sm btn-outline-success">Download Form 1721-VII</a>
                                </td>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
    </div>
    <div id="paginator">
        {{-- {{$data->links()}} --}}
    </div>


@endsection