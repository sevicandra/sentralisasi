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
                        <th colspan="7">Bruto</th>
                        <th>Potongan</th>
                        <th rowspan="2">Netto</th>
                        <th rowspan="2">Keterangan Potongan</th>
                    </tr>
                    <tr class="align-middle">
                        <th>Grade</th>
                        <th>Pokok</th>
                        <th>Tambahan</th>
                        <th>%</th>
                        <th>Absen</th>
                        <th>Pajak</th>
                        <th>Jumlah</th>
                        <th>PPh Psl 21</th>
                    </tr>
                </thead>
                <tbody>
                        <tr class="align-middle">
                            <td class="text-center"></td>
                            <td></td>
                            <td class="text-center"></td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="text-muted text-sm">
                            </td>
                        </tr>

                    <?php endforeach; ?>
                    <tr class="align-middle">
                        <th colspan="3" class="text-center">Jumlah</th>
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
    <div id="paginator">
        {{-- {{$data->links()}} --}}
    </div>


@endsection