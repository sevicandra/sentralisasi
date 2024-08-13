@extends('layout.main')
@section('aside-menu')
    @include('monitoring.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex gap-2 flex-wrap py-2 px-4">
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-2 overflow-hidden px-4 pb-2">
            <div>
                <div class="overflow-x-auto overflow-y-hidden h-full w-full">
                    <x-table class="collapse">
                        <x-table.header>
                            <tr class="*:border">
                                <x-table.header.column :colspan="2" class="text-center">Data Pokok</x-table.header.column>
                            </tr>
                        </x-table.header>
                        <x-table.body>
                            <tr class="*:border">
                                <x-table.body.column>NIP</x-table.body.column>
                                <x-table.body.column>{{ $pegawai->Nip18 }}</x-table.body.column>
                            </tr>
                            <tr class="*:border">
                                <x-table.body.column>Nama</x-table.body.column>
                                <x-table.body.column>{{ $pegawai->GelarDepan . ' ' . $pegawai->Nama . ', ' . $pegawai->GelarBelakang }}</x-table.body.column>
                            </tr>
                            <tr class="*:border">
                                <x-table.body.column>TTL</x-table.body.column>
                                <x-table.body.column>{{ $pegawai->TempatLahir }},
                                    {{ date('d-m-Y', strtotime($pegawai->TanggalLahir)) }}</x-table.body.column>
                            </tr>
                            <tr class="*:border">
                                <x-table.body.column>NPWP</x-table.body.column>
                                <x-table.body.column>{{ $pegawai->Npwp }}</x-table.body.column>
                            </tr>
                            <tr class="*:border">
                                <x-table.body.column>No Karpeg</x-table.body.column>
                                <x-table.body.column>{{ $pegawai->NoKartuPegawai }}</x-table.body.column>
                            </tr>
                            <tr class="*:border">
                                <x-table.body.column>NIK</x-table.body.column>
                                <x-table.body.column>{{ $pegawai->Nik }}</x-table.body.column>
                            </tr>
                            <tr class="*:border">
                                <x-table.body.column>Gol</x-table.body.column>
                                <x-table.body.column>{{ $pegawai->KodeGolonganRuang }}</x-table.body.column>
                            </tr>
                            <tr class="*:border">
                                <x-table.body.column>Grade</x-table.body.column>
                                <x-table.body.column>{{ $pegawai->Grading }}</x-table.body.column>
                            </tr>
                            <tr class="*:border">
                                <x-table.body.column>Jabatan</x-table.body.column>
                                <x-table.body.column>{{ $pegawai->Jabatan }}</x-table.body.column>
                            </tr>
                            <tr class="*:border">
                                <x-table.body.column>Alamat</x-table.body.column>
                                <x-table.body.column>{{ $pegawai->AlamatKtp }}</x-table.body.column>
                            </tr>
                            <tr class="*:border">
                                <x-table.body.column>No Telp</x-table.body.column>
                                <x-table.body.column>{{ $pegawai->NomorTelepon }}</x-table.body.column>
                            </tr>
                            <tr class="*:border">
                                <x-table.body.column>Email</x-table.body.column>
                                <x-table.body.column>{{ $pegawai->Email }}</x-table.body.column>
                            </tr>
                            <tr class="*:border">
                                <x-table.body.column>Gol Darah</x-table.body.column>
                                <x-table.body.column>{{ $pegawai->GolonganDarah }}</x-table.body.column>
                            </tr>
                            <tr class="*:border">
                                <x-table.body.column>Agama</x-table.body.column>
                                <x-table.body.column>{{ $pegawai->Agama }}</x-table.body.column>
                            </tr>
                        </x-table.body>
                    </x-table>
                </div>
            </div>
            <div class="overflow-y-auto overflow-x-hidden flex flex-col gap-2">
                <div class="overflow-y-auto w-full shrink-0">
                    <x-table class="collapse">
                        <x-table.header>
                            <tr class="*:border-x">
                                <x-table.header.column :colspan="5" class="text-center">Data
                                    Keluarga</x-table.header.column>
                            </tr>
                            <tr class="*:border-x">
                                <x-table.header.column class="text-center">No</x-table.header.column>
                                <x-table.header.column class="text-center">Nama</x-table.header.column>
                                <x-table.header.column class="text-center">TTL</x-table.header.column>
                                <x-table.header.column class="text-center">Hubungan</x-table.header.column>
                                <x-table.header.column class="text-center">Status</x-table.header.column>
                            </tr>
                        </x-table.header>
                        <x-table.body>
                            @foreach ($keluarga as $item)
                                <tr class="*:border">
                                    <x-table.body.column>{{ $loop->iteration }}</x-table.body.column>
                                    <x-table.body.column>{{ $item->Nama }}</x-table.body.column>
                                    <x-table.body.column>{{ $item->TempatLahir . ', ' . date('d-m-Y', strtotime($item->TanggalLahir)) }}
                                    </x-table.body.column>
                                    <x-table.body.column>{{ $item->Hubungan }}</x-table.body.column>
                                    <x-table.body.column>{{ $item->StatusTanggungan }}</x-table.body.column>
                                </tr>
                            @endforeach
                        </x-table.body>
                    </x-table>
                </div>
                <div class="overflow-y-auto w-full shrink-0">
                    <x-table class="collapse">
                        <x-table.header>
                            <tr class="*:border-x">
                                <x-table.header.column :colspan="5" class="text-center">Data Unit
                                    Organisasi</x-table.header.column>
                            </tr>
                        </x-table.header>
                        <x-table.body>
                            @if ($pegawai->Esl4 != '')
                                <tr class="*:border">
                                    <x-table.body.column>Eselon IV</x-table.body.column>
                                    <x-table.body.column>{{ $pegawai->Esl4 }}</x-table.body.column>
                                </tr>
                            @endif
                            @if ($pegawai->Esl3 != '')
                                <tr class="*:border">
                                    <x-table.body.column>Eselon III</x-table.body.column>
                                    <x-table.body.column>{{ $pegawai->Esl3 }}</x-table.body.column>
                                </tr>
                            @endif
                            @if ($pegawai->Esl2 != '')
                                <tr class="*:border">
                                    <x-table.body.column>Eselon II</x-table.body.column>
                                    <x-table.body.column>{{ $pegawai->Esl2 }}</x-table.body.column>
                                </tr>
                            @endif
                            @if ($pegawai->Esl1 != '')
                                <tr class="*:border">
                                    <x-table.body.column>Eselon I</x-table.body.column>
                                    <x-table.body.column>{{ $pegawai->Esl1 }}</x-table.body.column>
                                </tr>
                            @endif
                            <tr class="*:border">
                                <x-table.body.column>Kode Satker</x-table.body.column>
                                <x-table.body.column>{{ $pegawai->KdSatker }}</x-table.body.column>
                            </tr>
                            <tr class="*:border">
                                <x-table.body.column>Nama Satker</x-table.body.column>
                                <x-table.body.column>{{ $pegawai->NamaSatker }}</x-table.body.column>
                            </tr>
                        </x-table.body>
                    </x-table>
                </div>
                <div class="overflow-y-auto w-full shrink-0">
                    <x-table class="collapse">
                        <x-table.header>
                            <tr class="*:border-x">
                                <x-table.header.column class="text-center" colspan="6">Data
                                    Rekening</x-table.header.column>
                            </tr>
                            <tr class="*:border-x">
                                <x-table.header.column class="text-center">No</x-table.header.column>
                                <x-table.header.column class="text-center">Nomor Rekening</x-table.header.column>
                                <x-table.header.column class="text-center">Nama Pemilik Rekening</x-table.header.column>
                                <x-table.header.column class="text-center">Cabang Bank</x-table.header.column>
                                <x-table.header.column class="text-center">Jenis Peruntukan</x-table.header.column>
                                <x-table.header.column class="text-center">Nama Bank</x-table.header.column>
                            </tr>
                        </x-table.header>
                        <x-table.body>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($rekening as $item)
                                <tr class="*:border">
                                    <x-table.body.column>{{ $no++ }}</x-table.body.column>
                                    <x-table.body.column>{{ $item->NomorRekening }}</x-table.body.column>
                                    <x-table.body.column>{{ $item->NamaPemilikRekening }}</x-table.body.column>
                                    <x-table.body.column>{{ $item->CabangBank }}</x-table.body.column>
                                    <x-table.body.column>{{ $item->JenisPeruntukan }}</x-table.body.column>
                                    <x-table.body.column>{{ $item->NamaBank }}</x-table.body.column>
                                </tr>
                            @endforeach
                        </x-table.body>
                    </x-table>
                </div>
            </div>
        </div>
        <div>
            {{-- {{$data->links()}} --}}
        </div>
    </div>
@endsection
