@extends('layout.main')
@section('aside-menu')
    @include('monitoring.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 flex-wrap py-2 px-4">
            <div class="w-full flex gap-1 flex-wrap">
                @foreach ($tahun as $item)
                    <a href="{{ config('app.url') }}/monitoring/laporan/pph-pasal-21/{{ $nip }}/{{ $item->tahun }}"
                        class="btn btn-xs btn-primary btn-outline @if ($thn === $item->tahun) btn-active @endif">{{ $item->tahun }}</a>
                @endforeach
            </div>
            <div class="w-full flex gap-1 flex-wrap">
                <a href="{{ config('app.url') }}/monitoring/laporan/pph-pasal-21/{{ $nip }}/{{ $thn }}/cetak"
                    class="btn btn-xs btn-primary">Download Form 1721-A2</a>
            </div>
        </div>
        <div class="grid grid-rows-[auto_1fr] grid-cols-1 overflow-hidden px-4 pb-2">
            @if ($kurang === null)
                @php
                    $kurang = new stdClass();
                    $kurang->gapok = null;
                    $kurang->tistri = null;
                    $kurang->tanak = null;
                    $kurang->tumum = null;
                    $kurang->tstruktur = null;
                    $kurang->tfungsi = null;
                    $kurang->tberas = null;
                    $kurang->bulat = null;
                    $kurang->tpapua = null;
                    $kurang->tpajak = null;
                @endphp
            @endif
            @php
                $setahun = $gaji->jumlah >= 12 ? 12 : $gaji->jumlah;
                $gapok = $gaji->gapok + $kurang->gapok;
                $tistri = $gaji->tistri + $kurang->tistri;
                $tanak = $gaji->tanak + $kurang->tanak;
                $kelg = $gapok + $tistri + $tanak;
                $tumum = $gaji->tumum + $kurang->tumum;
                $tstruktur = $gaji->tstruktur + $kurang->tstruktur;
                $tfungsi = $gaji->tfungsi + $kurang->tfungsi;
                $tunj = $tstruktur + $tfungsi;
                $tberas = $gaji->tberas + $kurang->tberas;
                $bulat = $gaji->bulat + $kurang->bulat;
                $tpapua = $gaji->tpapua + $kurang->tpapua;
                $tk = $tukin->bruto;
                $bruto = $kelg + $tumum + $tunj + $tberas + $bulat + $tpapua + $tk;
                $ptkp_wp = $tarif->ptkp_wp;
                $ptkp_istri = $tarif->ptkp_istri;
                $ptkp_anak = $tarif->ptkp_anak;
                $iuran_pensiun = $tarif->iuran_pensiun;
                $biaya_jabatan = $tarif->biaya_jabatan;
                $biaya_jabatan_maks = $tarif->biaya_jabatan_maks;
                $jml_iuran_pensiun = ($iuran_pensiun * $kelg) / 100;
                $jml_biaya_jabatan = ($biaya_jabatan * $bruto) / 100;
                $total_biaya_jabatan = $jml_biaya_jabatan >= 6000000 ? 6000000 : $jml_biaya_jabatan;
                $pengurangan = $jml_iuran_pensiun + $total_biaya_jabatan;
                $netto = $bruto - $pengurangan;
                $setahun = $setahun < 1 ? 1 : $setahun;
                $disetahun = floor((($netto / $setahun) * 12) / 1000) * 1000;
                $peg_wp = intval(substr($peg->kdkawin, 0, 1));
                $peg_istri = intval(substr($peg->kdkawin, 1, 1));
                $peg_anak = intval(substr($peg->kdkawin, 2, 2));
                $jml_ptkp_wp = $peg_wp * $ptkp_wp;
                $jml_ptkp_istri = $peg_istri * $ptkp_istri;
                $jml_ptkp_anak = $peg_anak * $ptkp_anak;
                $ptkp = $jml_ptkp_wp + $jml_ptkp_istri + $jml_ptkp_anak;
                $pkp = $disetahun - $ptkp;
                $jml_dipungut = $gaji->tpajak + $kurang->tpajak + $tukin->potongan;
                $pph_tarif_1 = $tarif->pph_tarif_1;
                $pph_tarif_2 = $tarif->pph_tarif_2;
                $pph_tarif_3 = $tarif->pph_tarif_3;
                $pph_tarif_4 = $tarif->pph_tarif_4;
                $pph_limit_1 = $tarif->pph_limit_1;
                $pph_limit_2 = $tarif->pph_limit_2;
                $pph_limit_3 = $tarif->pph_limit_3;
                //hitung pph
                if ($pkp > $pph_limit_3) {
                    $pph1 = $pph_tarif_1 * $pph_limit_1;
                    $pph2 = $pph_tarif_2 * ($pph_limit_2 - $pph_limit_1);
                    $pph3 = $pph_tarif_3 * ($pph_limit_3 - $pph_limit_2);
                    $pph4 = $pph_tarif_4 * ($pkp - $pph_limit_3);
                    $pph = ($pph1 + $pph2 + $pph3 + $pph4) / 100;
                } elseif ($pkp > $pph_limit_2) {
                    $pph1 = $pph_tarif_1 * $pph_limit_1;
                    $pph2 = $pph_tarif_2 * ($pph_limit_2 - $pph_limit_1);
                    $pph3 = $pph_tarif_3 * ($pkp - $pph_limit_2);
                    $pph = ($pph1 + $pph2 + $pph3) / 100;
                } elseif ($pkp > $pph_limit_1) {
                    $pph1 = $pph_tarif_1 * $pph_limit_1;
                    $pph2 = $pph_tarif_2 * ($pkp - $pph_limit_1);
                    $pph = ($pph1 + $pph2) / 100;
                } else {
                    $pph = ($pph_tarif_1 * $pkp) / 100;
                }
                $sisa = $pph - $jml_dipungut;
            @endphp
            <div></div>
            <div class="overflow-x-auto overflow-y-auto h-full w-full max-w-2xl">
                <x-table class="collapse">
                    <x-table.header>
                        <tr class="*:border-x">
                            <x-table.header.column class="text-center">No</x-table.header.column>
                            <x-table.header.column class="text-center">Uraian</x-table.header.column>
                            <x-table.header.column class="text-center">Nominal</x-table.header.column>
                        </tr>
                    </x-table.header>
                    <x-table.body>
                        <tr class="*:border">
                            <x-table.body.column colspan="3">Penghasilan Bruto :</x-table.body.column>
                        </tr>
                        <tr class="*:border">
                            <x-table.body.column class="text-center">1</x-table.body.column>
                            <x-table.body.column>Gaji Pokok</x-table.body.column>
                            <x-table.body.column class="text-right">{{ number_format($gapok, 0, ',', '.') }}</x-table.body.column>
                        </tr>
                        <tr class="*:border">
                            <x-table.body.column class="text-center">2</x-table.body.column>
                            <x-table.body.column>Tunjangan Istri/Suami</x-table.body.column>
                            <x-table.body.column class="text-right">{{ number_format($tistri, 0, ',', '.') }}</x-table.body.column>
                        </tr>
                        <tr class="*:border">
                            <x-table.body.column class="text-center">3</x-table.body.column>
                            <x-table.body.column>Tunjangan Anak</x-table.body.column>
                            <x-table.body.column class="text-right">{{ number_format($tanak, 0, ',', '.') }}</x-table.body.column>
                        </tr>
                        <tr class="*:border">
                            <x-table.body.column class="text-center">4</x-table.body.column>
                            <x-table.body.column>Jumlah Gaji dan Tunjangan Keluarga <small>(No.1 s/d No.3)</small></x-table.body.column>
                            <x-table.body.column class="text-right">{{ number_format($kelg, 0, ',', '.') }}</x-table.body.column>
                        </tr>
                        <tr class="*:border">
                            <x-table.body.column class="text-center">5</x-table.body.column>
                            <x-table.body.column>Tunjangan Perbaikan Penghasilan</x-table.body.column>
                            <x-table.body.column class="text-right">{{ number_format($tumum, 0, ',', '.') }}</x-table.body.column>
                        </tr>
                        <tr class="*:border">
                            <x-table.body.column class="text-center">6</x-table.body.column>
                            <x-table.body.column>Tunjangan Struktural/Fungsional</x-table.body.column>
                            <x-table.body.column class="text-right">{{ number_format($tunj, 0, ',', '.') }}</x-table.body.column>
                        </tr>
                        <tr class="*:border">
                            <x-table.body.column class="text-center">7</x-table.body.column>
                            <x-table.body.column>Tunjangan Beras</x-table.body.column>
                            <x-table.body.column class="text-right">{{ number_format($tberas, 0, ',', '.') }}</x-table.body.column>
                        </tr>
                        <tr class="*:border">
                            <x-table.body.column class="text-center">8</x-table.body.column>
                            <x-table.body.column>Tunjangan Khusus</x-table.body.column>
                            <x-table.body.column class="text-right">{{ number_format($bulat, 0, ',', '.') }}</x-table.body.column>
                        </tr>
                        <tr class="*:border">
                            <x-table.body.column class="text-center">9</x-table.body.column>
                            <x-table.body.column>Tunjangan Lain-lain</x-table.body.column>
                            <x-table.body.column class="text-right">{{ number_format($tpapua, 0, ',', '.') }}</x-table.body.column>
                        </tr>
                        <tr class="*:border">
                            <x-table.body.column class="text-center">10</x-table.body.column>
                            <x-table.body.column>Penghasilan Tetap dan Teratur Lainnya yang Pembayarannya Terpisah dari Pembayaran
                                Gaji</x-table.body.column>
                            <x-table.body.column class="text-right">{{ number_format($tk, 0, ',', '.') }}</x-table.body.column>
                        </tr>
                        <tr class="*:border">
                            <x-table.body.column class="text-center">11</x-table.body.column>
                            <x-table.body.column>Jumlah Penghasilan Bruto <small>(No.4 s/d No.10)</small></x-table.body.column>
                            <x-table.body.column class="text-right">{{ number_format($bruto, 0, ',', '.') }}</x-table.body.column>
                        </tr>
                        <tr class="*:border">
                            <x-table.body.column colspan="3">Pengurangan :</x-table.body.column>
                        </tr>
                        <tr class="*:border">
                            <x-table.body.column class="text-center">12</x-table.body.column>
                            <x-table.body.column>Biaya Jabatan <small>(5% <small>X</small> No.11 Maks. 6.000.000)</small></x-table.body.column>
                            <x-table.body.column class="text-right">{{ number_format($total_biaya_jabatan, 0, ',', '.') }}</x-table.body.column>
                        </tr>
                        <tr class="*:border">
                            <x-table.body.column class="text-center">13</x-table.body.column>
                            <x-table.body.column>Iuran Pensiun <small>(4,75% <small>X</small> No.4)</small></x-table.body.column>
                            <x-table.body.column class="text-right">{{ number_format($jml_iuran_pensiun, 0, ',', '.') }}</x-table.body.column>
                        </tr>
                        <tr class="*:border">
                            <x-table.body.column class="text-center">14</x-table.body.column>
                            <x-table.body.column>Jumlah Pengurangan <small>(No.12 s/d No.13)</small></x-table.body.column>
                            <x-table.body.column class="text-right">{{ number_format($pengurangan, 0, ',', '.') }}</x-table.body.column>
                        </tr>
                        <tr class="*:border">
                            <x-table.body.column colspan="3">Penghitungan PPh Pasal 21 :</x-table.body.column>
                        </tr>
                        <tr class="*:border">
                            <x-table.body.column class="text-center">15</x-table.body.column>
                            <x-table.body.column>Jumlah Penghasilan Netto <small>(No.11 - No.14)</small></x-table.body.column>
                            <x-table.body.column class="text-right">{{ number_format($netto, 0, ',', '.') }}</x-table.body.column>
                        </tr>
                        <tr class="*:border">
                            <x-table.body.column class="text-center">16</x-table.body.column>
                            <x-table.body.column>Jumlah Penghasilan Masa Sebelumnya</x-table.body.column>
                            <x-table.body.column class="text-right">0</x-table.body.column>
                        </tr>
                        <tr class="text-bold text-success *:border">
                            <x-table.body.column class="text-center">17</x-table.body.column>
                            <x-table.body.column>Jumlah Penghasilan Netto untuk Penghitungan PPh Pasal 21 (Setahun/Disetahunkan)</x-table.body.column>
                            <x-table.body.column class="text-right">{{ number_format($disetahun, 0, ',', '.') }}</x-table.body.column>
                        </tr>
                        <tr class="text-bold text-success *:border">
                            <x-table.body.column class="text-center">18</x-table.body.column>
                            <x-table.body.column>Penghasilan Tidak Kena Pajak (PTKP)</x-table.body.column>
                            <x-table.body.column class="text-right">{{ number_format($ptkp, 0, ',', '.') }}</x-table.body.column>
                        </tr>
                        <tr class="*:border">
                            <x-table.body.column class="text-center">19</x-table.body.column>
                            <x-table.body.column>Penghasilan Kena Pajak Setahun/Disetahunkan <small>(17 - 18)</small></x-table.body.column>
                            <x-table.body.column class="text-right">{{ number_format($pkp, 0, ',', '.') }}</x-table.body.column>
                        </tr>
                        <tr class="*:border">
                            <x-table.body.column class="text-center">20</x-table.body.column>
                            <x-table.body.column>PPh Pasal 21 Atas Penghasilan Kena Pajak Setahun/Disetahunkan</x-table.body.column>
                            <x-table.body.column class="text-right">{{ number_format($pph, 0, ',', '.') }}</x-table.body.column>
                        </tr>
                        <tr class="*:border">
                            <x-table.body.column class="text-center">21</x-table.body.column>
                            <x-table.body.column>PPh Pasal 21 Yang Telah DIpotong Masa Sebelumnya</x-table.body.column>
                            <x-table.body.column class="text-right">0</x-table.body.column>
                        </tr>
                        <tr class="text-bold text-success *:border">
                            <x-table.body.column class="text-center">22</x-table.body.column>
                            <x-table.body.column>PPh Pasal 21 Terutang</x-table.body.column>
                            <x-table.body.column class="text-right">{{ number_format($pph, 0, ',', '.') }}</x-table.body.column>
                        </tr>
                        <tr class="text-bold text-success *:border">
                            <x-table.body.column class="text-center">23</x-table.body.column>
                            <x-table.body.column>PPh Pasal 21 Yang Telah Dipotong dan Dilunasi</x-table.body.column>
                            <x-table.body.column class="text-right">{{ number_format($pph, 0, ',', '.') }}</x-table.body.column>
                        </tr>
                        <tr class="*:border">
                            <x-table.body.column></x-table.body.column>
                            <x-table.body.column>A. Atas Gaji dan Tunjangan</x-table.body.column>
                            <x-table.body.column class="text-right">{{ number_format($jml_dipungut, 0, ',', '.') }}</x-table.body.column>
                        </tr>
                        <tr class="*:border">
                            <x-table.body.column></x-table.body.column>
                            <x-table.body.column>B. Atas Penghasilan Tidak Tetap dan Teratur Lainnya yang Pembayarannya Terpisah dari
                                Pembayaran Gaji</x-table.body.column>
                            <x-table.body.column class="text-right">{{ number_format($sisa, 0, ',', '.') }}</x-table.body.column>
                        </tr>
                    </x-table.body>
                </x-table>
            </div>
        </div>
        <div>
            {{-- {{$data->links()}} --}}
        </div>
    </div>
@endsection
