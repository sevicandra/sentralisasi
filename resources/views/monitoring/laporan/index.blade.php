@extends('layout.main')
@section('aside-menu')
    @include('monitoring.sidemenu')
@endsection         
@section('main-content')

    <div id="main-content-header">
        <div class="row">
            <div class="row">
                <div class="row">
                    <div class="col-lg-5">
                        <form action="" method="get">
                            <div class="input-group">
                                <input type="text" name="keyword" class="form-control" placeholder="nama atau nip">
                                <button class="btn btn-sm btn-outline-secondary" type="submit">Cari</button>
                            </div>
                        </form>
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
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="pb-0 pr-0">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="/monitoring/laporan/profil" class="btn btn-sm btn-outline-secondary pt-0 pb-0" target="_blank">Profil</a>
                                    <a href="/monitoring/laporan/pph-pasal-21" class="btn btn-sm btn-outline-secondary pt-0 pb-0" target="_blank">PPh Pasal 21</a>
                                    <a href="/monitoring/laporan/pph-pasal-21-final" class="btn btn-sm btn-outline-secondary pt-0 pb-0" target="_blank">PPh Pasal 21 Final</a>
                                    <a href="/monitoring/laporan/penghasilan-tahunan" class="btn btn-sm btn-outline-secondary pt-0 pb-0" target="_blank">Penghasilan Tahunan</a>
                                    {{-- <a href="/monitoring/laporan/dokumen-perubahan" class="btn btn-sm btn-outline-secondary pt-0 pb-0" target="_blank">Dokumen Perubahan</a> --}}
                                </div>
                            </td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div id="paginator">
        {{-- {{$data->links()}} --}}
    </div>


@endsection