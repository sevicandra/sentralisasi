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
                            <a href="" class="btn btn-sm btn-outline-success active ml-1 mt-1 mb-1">2022</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="row">
                    <div class="col-lg-12">
                        <a href="" class="btn btn-sm btn-outline-success active ml-1 mt-1 mb-1">gaji-rutin</a>
                        <a href="" class="btn btn-sm btn-outline-success ml-1 mt-1 mb-1">kekurangan-gaji</a>
                        <a href="" class="btn btn-sm btn-outline-success ml-1 mt-1 mb-1">uang-makan</a>
                        <a href="" class="btn btn-sm btn-outline-success ml-1 mt-1 mb-1">uang-lembur</a>
                        <a href="" class="btn btn-sm btn-outline-success ml-1 mt-1 mb-1">tukin-rutin</a>
                        <a href="" class="btn btn-sm btn-outline-success ml-1 mt-1 mb-1">kekurangan-tukin</a>
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
                            <th>Bulan</th>
                            <th>Jumlah Pegawai</th>
                            <th>Jumlah Bruto</th>
                            <th>Jumlah Potongan</th>
                            <th>Jumlah Netto</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < 100; $i++)
                        <tr>
                            <td class="text-center"></td>
                            <td></td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="pb-0 pt-0">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="" class="btn btn-sm btn-outline-success pt-0 pb-0" target="_blank">Daftar</a>
                                </div>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
        </div>
    </div>
    <div id="paginator">
        {{-- {{$data->links()}} --}}
    </div>


@endsection