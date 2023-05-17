@extends('layout.main')
@section('aside-menu')
    @include('monitoring.sidemenu')
@endsection         
@section('main-content')

    <div id="main-content-header">
    </div>
    <div id="main-content">
        <div class="row">
            <div class="col-lg-6">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="text-center">
                            <tr>
                                <th colspan="2">Data Pegawai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>NIP</td>
                                <td>{{$pegawai->Nip18}}</td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td>{{$pegawai->GelarDepan . ' ' . $pegawai->Nama . ', ' . $pegawai->GelarBelakang}}</td>
                            </tr>
                            <tr>
                                <td>TTL</td>
                                <td>{{$pegawai->TempatLahir}}, {{date('d-m-Y', strtotime($pegawai->TanggalLahir))}}</td>
                            </tr>
                            <tr>
                                <td>NPWP</td>
                                <td>{{$pegawai->Npwp}}</td>
                            </tr>
                            <tr>
                                <td>No Karpeg</td>
                                <td>{{$pegawai->NoKartuPegawai}}</td>
                            </tr>
                            <tr>
                                <td>NIK</td>
                                <td>{{$pegawai->Nik}}</td>
                            </tr>
                            <tr>
                                <td>Gol</td>
                                <td>{{$pegawai->KodeGolonganRuang}}</td>
                            </tr>
                            <tr>
                                <td>Grade</td>
                                <td>{{$pegawai->Grading}}</td>
                            </tr>
                            <tr>
                                <td>Jabatan</td>
                                <td>{{$pegawai->Jabatan}}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>{{$pegawai->AlamatKtp}}</td>
                            </tr>
                            <tr>
                                <td>No Telp</td>
                                <td>{{$pegawai->NomorTelepon}}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{$pegawai->Email}}</td>
                            </tr>
                            <tr>
                                <td>Gol Darah</td>
                                <td>{{$pegawai->GolonganDarah}}</td>
                            </tr>
                            <tr>
                                <td>Agama</td>
                                <td>{{$pegawai->Agama}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="text-center">
                                    <tr>
                                        <th colspan="5">Data Keluarga</th>
                                    </tr>
                                    <tr class="align-middle">
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>TTL</th>
                                        <th>Hubungan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($keluarga as $item)
                                        <tr class="align-middle">
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item->Nama }}</td>
                                            <td>{{ $item->TempatLahir . ', ' . date('d-m-Y', strtotime($item->TanggalLahir))}}</td>
                                            <td>{{ $item->Hubungan }}</td>
                                            <td>{{ $item->Pekerjaan }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="text-center">
                                    <tr>
                                        <th colspan="5">Data Unit Organisasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($pegawai->Esl4 != '')
                                    <tr>
                                        <td>Eselon IV</td>
                                        <td>{{ $pegawai->Esl4 }}</td>
                                    </tr>
                                    @endif
                                    @if ($pegawai->Esl3 != '')
                                    <tr>
                                        <td>Eselon III</td>
                                        <td>{{ $pegawai->Esl3 }}</td>
                                    </tr>
                                    @endif
                                    @if ($pegawai->Esl2 != '')
                                    <tr>
                                        <td>Eselon II</td>
                                        <td>{{ $pegawai->Esl2 }}</td>
                                    </tr>
                                    @endif
                                    @if ($pegawai->Esl1 != '')
                                    <tr>
                                        <td>Eselon I</td>
                                        <td>{{ $pegawai->Esl1 }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td>Kode Satker</td>
                                        <td>{{ $pegawai->KdSatker }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nama Satker</td>
                                        <td>{{ $pegawai->NamaSatker }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="text-center">
                                    <tr>
                                        <th colspan="6">Data Rekening</th>
                                    </tr>
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor Rekening</th>
                                        <th>Nama Pemilik Rekening</th>
                                        <th>Cabang Bank</th>
                                        <th>Jenis Peruntukan</th>
                                        <th>Nama Bank</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no =1;
                                    @endphp
                                    @foreach ($rekening as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->NomorRekening }}</td>
                                        <td>{{ $item->NamaPemilikRekening }}</td>
                                        <td>{{ $item->CabangBank }}</td>
                                        <td>{{ $item->JenisPeruntukan }}</td>
                                        <td>{{ $item->NamaBank }}</td>
                                    </tr>
                                    @endforeach
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