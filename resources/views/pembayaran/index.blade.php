@extends('layout.main')
@section('aside-menu')
    @include('pembayaran.sidemenu')
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
        </div>
    </div>
    <div id="main-content">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">Permohonan Pembayaran Uang Makan</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Dokumen</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 0; $i < 12; $i++)
                                    <tr>
                                        <td>{{ $i+1 }}</td>
                                        <td></td>
                                        <td>
                                            <a href="/pembayaran/detail"><i class="bi bi-search"></i></a>
                                        </td>
                                    </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">Permohonan Pembayaran Uang Lembur</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Dokumen</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 0; $i < 12; $i++)
                                    <tr>
                                        <td>{{ $i+1 }}</td>
                                        <td></td>
                                        <td>
                                            <a href="/pembayaran/detail"><i class="bi bi-search"></i></a>
                                        </td>
                                    </tr>
                                    @endfor
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