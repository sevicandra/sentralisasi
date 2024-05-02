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
                        @foreach ($tahun as $item)
                            <a href="{{ config('app.url') }}/belanja-51/index/{{ $item }}" class="btn btn-sm btn-outline-success @if ($item === $thn) active @endif ml-1 mt-1 mb-1">{{ $item }}</a>
                        @endforeach
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
                                    @for ($i = 1; $i <= 12; $i++)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $uangMakan->where('bulan', $i)->count() }}</td>
                                        <td>
                                            @if ($uangMakan->where('bulan', $i)->count() > 0)
                                            <a href="/belanja-51/uang-makan/{{ $thn }}/{{ $uangMakan->where('bulan', $i)->first()->bulan }}/detail">detail</a>
                                            @endif
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
                                    @for ($i = 1; $i <= 12; $i++)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $uangLembur->where('bulan', $i)->count() }}</td>
                                        <td>
                                            @if ($uangLembur->where('bulan', $i)->count() > 0)
                                            <a href="/belanja-51/uang-lembur/{{ $thn }}/{{ $uangLembur->where('bulan', $i)->first()->bulan }}/detail"><i class="bi bi-search"></i></a>
                                            @endif
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