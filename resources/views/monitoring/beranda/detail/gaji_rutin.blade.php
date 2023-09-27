@extends('monitoring.beranda.detail.layout')
@section('beranda_content')
    <table class="table table-bordered table-hover">
        <thead class="text-center">
            <tr class="align-middle">
                <th rowspan="2">No</th>
                <th colspan="5">Data Pegawai</th>
                <th colspan="10">Bruto</th>
                <th colspan="7">Potongan</th>
                <th rowspan="2">Netto</th>
            </tr>
            <tr class="align-middle">
                <th>Nama</th>
                <th>NIP</th>
                <th>Kdkawin</th>
                <th>Kdgapok</th>
                <th>Kdjab</th>
                <th>Gapok</th>
                <th>Istri</th>
                <th>Anak</th>
                <th>Umum</th>
                <th>Str/Fng</th>
                <th>Bulat</th>
                <th>Beras</th>
                <th>Pajak</th>
                <th>Lain2</th>
                <th>Jumlah</th>
                <th>IWP</th>
                <th>PPh</th>
                <th>Rumdin</th>
                <th>Lain2</th>
                <th>Taperum</th>
                <th>BPJS</th>
                <th>BPJS Kel. Lainnya</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @php
                $j1 = 0;
                $j2 = 0;
                $j3 = 0;
                $j4 = 0;
                $j5 = 0;
                $j6 = 0;
                $j7 = 0;
                $j8 = 0;
                $j9 = 0;
                $j10 = 0;
                $j11 = 0;
                $j12 = 0;
                $j13 = 0;
                $j14 = 0;
                $j15 = 0;
                $j16 = 0;
                $j17 = 0;
                $j18 = 0;
                $j19 = 0;
            @endphp
            @foreach ($data as $item)
                <tr class="align-middle">

                    <td class="text-center">{{ $i++ }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->nip }}</td>
                    <td>{{ $item->kdkawin }}</td>
                    <td>{{ $item->kdgapok }}</td>
                    <td>{{ $item->kdjab }}</td>

                    @php
                        $gapok = $item->gapok;
                        $tistri = $item->tistri;
                        $tanak = $item->tanak;
                        $tumum = $item->tumum + $item->ttambumum;
                        $tstruktur = $item->tstruktur + $item->tfungsi;
                        $bulat = $item->bulat;
                        $tberas = $item->tberas;
                        $tpajak = $item->tpajak;
                        $bruto = $gapok + $tistri + $tanak + $tumum + $tstruktur + $bulat + $tberas + $tpajak;
                        $iwp = $item->iwp;
                        $pph = $item->pph;
                        $sewarmh = $item->sewarmh;
                        $tlain = $item->tpapua + $item->tpencil + $item->tlain;
                        $potlain = $item->pberas + $item->tunggakan + $item->utanglebih + $item->potlain;
                        $taperum = $item->taperum;
                        $bpjs = $item->bpjs;
                        $bpjs2 = $item->bpjs2;
                        $potongan = $iwp + $pph + $sewarmh + $potlain + $taperum + $bpjs + $bpjs2;
                        $netto = $bruto - $potongan;
                    @endphp

                    <td class="text-right"><?= number_format($gapok, 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format($tistri, 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format($tanak, 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format($tumum, 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format($tstruktur, 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format($bulat, 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format($tberas, 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format($tpajak, 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format($tlain, 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format($bruto, 0, ',', '.') ?>
                    <td class="text-right"><?= number_format($iwp, 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format($pph, 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format($sewarmh, 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format($potlain, 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format($taperum, 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format($bpjs, 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format($bpjs2, 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format($potongan, 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format($netto, 0, ',', '.') ?></td>
                </tr>
                @php
                    $j1 += $gapok;
                    $j2 += $tistri;
                    $j3 += $tanak;
                    $j4 += $tumum;
                    $j5 += $tstruktur;
                    $j6 += $bulat;
                    $j7 += $tberas;
                    $j8 += $tpajak;
                    $j9 += $tlain;
                    $j10 += $bruto;
                    $j11 += $iwp;
                    $j12 += $pph;
                    $j13 += $sewarmh;
                    $j14 += $potlain;
                    $j15 += $taperum;
                    $j16 += $bpjs;
                    $j17 += $potongan;
                    $j18 += $netto;
                    $j19 += $bpjs2;
                @endphp
            @endforeach
            <tr class="align-middle">
                <th colspan="6" class="text-center">Jumlah</th>
                <th class="text-right"><?= number_format($j1, 0, ',', '.') ?></th>
                <th class="text-right"><?= number_format($j2, 0, ',', '.') ?></th>
                <th class="text-right"><?= number_format($j3, 0, ',', '.') ?></th>
                <th class="text-right"><?= number_format($j4, 0, ',', '.') ?></th>
                <th class="text-right"><?= number_format($j5, 0, ',', '.') ?></th>
                <th class="text-right"><?= number_format($j6, 0, ',', '.') ?></th>
                <th class="text-right"><?= number_format($j7, 0, ',', '.') ?></th>
                <th class="text-right"><?= number_format($j8, 0, ',', '.') ?></th>
                <th class="text-right"><?= number_format($j9, 0, ',', '.') ?></th>
                <th class="text-right"><?= number_format($j10, 0, ',', '.') ?></th>
                <th class="text-right"><?= number_format($j11, 0, ',', '.') ?></th>
                <th class="text-right"><?= number_format($j12, 0, ',', '.') ?></th>
                <th class="text-right"><?= number_format($j13, 0, ',', '.') ?></th>
                <th class="text-right"><?= number_format($j14, 0, ',', '.') ?></th>
                <th class="text-right"><?= number_format($j15, 0, ',', '.') ?></th>
                <th class="text-right"><?= number_format($j16, 0, ',', '.') ?></th>
                <th class="text-right"><?= number_format($j19, 0, ',', '.') ?></th>
                <th class="text-right"><?= number_format($j17, 0, ',', '.') ?></th>
                <th class="text-right"><?= number_format($j18, 0, ',', '.') ?></th>
            </tr>
        </tbody>
    </table>
@endsection
