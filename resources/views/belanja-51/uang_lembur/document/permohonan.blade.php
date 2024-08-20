<style type="text/css">
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    .header {
        text-align: center;
    }

    .logo {
        text-align: center;
        width: 31mm;
    }

    .title {
        width: 146mm;
    }

    p {
        font-size: 11pt
    }

    .paragraph {
        text-align: justify;
        text-indent: 6.3mm;
        font-size: 11pt;
        line-height: 1.5;
    }

    .rekap {
        border-collapse: collapse;
        width: 100%;
    }

    .rekap th,
    .rekap td {
        border: 1px solid black;
        padding: 3px;
        font-size: 11pt;

    }

    .rekap th {
        text-align: center
    }

    .ttd {
        width: 100%;
    }

    .ttd-blank {
        width: 123mm
    }

    .ttd-box {
        width: 50mm;
        padding: 1mm
    }
</style>

<page backtop="0mm" backbottom="0mm" backleft="0mm" backright="0mm">
    @php
        $image_path = 'img/logo-kemenkeu.png';
        $image_data = base64_encode(file_get_contents($image_path));
        $image_type = pathinfo($image_path, PATHINFO_EXTENSION);

        // Generate data URI
        $src_img = 'data:image/' . $image_type . ';base64,' . $image_data;
    @endphp
    <table class="header">
        <tr>
            <td class="logo">
                <img src="{{ $src_img }}" alt="logo kemenkeu" style="width: 24.6mm">
            </td>
            <td class="title">
                <p style="font-size: 13pt; font-weight:bold; margin: 0 2mm;line-height:1.2;">KEMENTERIAN KEUANGAN
                    REPUBLIK
                    INDONESIA</p>
                <p style="font-size: 11pt; font-weight:bold; margin: 0 2mm;line-height:1.2;">{{ Str::upper($kop->eselon1)  }}
                </p>
                <p style="font-size: 11pt; font-weight:bold; margin: 0 2mm;line-height:1.2;">{{ Str::upper($kop->eselon2)  }}</p>
                <p style="font-size: 11pt; font-weight:bold; margin: 0 2mm;line-height:1.2;">{{ Str::upper($kop->eselon3)  }}</p>
                <p style="font-size: 7pt; margin: 0 2mm;line-height:1.2;">{{ Str::upper($kop->alamat)  }}</p>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="border-bottom: 1px solid black"></td>
        </tr>
    </table>
    <br>
    <p style="text-align: center">Register Permohonan Pembayaran Uang Makan</p>
    <p style="text-align: center">Nomor LBKP-{{ $nomor }}</p>
    <br>
    <p class="paragraph">
        Sehubungan dengan Keputusan Direktur Jenderal Kekayaan Negara Nomor 6/KN/2022 Tentang Sentralisasi Pengelolaan
        Belanja Pegawai Untuk Pegawai Lingkup Direktorat Jenderal Kekayaan Negara Bersama dengan ini, kami mengajukan
        Permohonan Pembayaran Uang Makan Periode Bulan Juni Tahun 2024, dengan
        rincian sebagai berikut:
    </p>
    <table class="rekap">
        <tr>
            <th style="width: 8mm;">No.</th>
            <th style="width: 77mm;">Nama</th>
            <th style="width: 45mm;">NIP</th>
            <th style="width: 15mm;">Jumlah Jam Hari Kerja</th>
            <th style="width: 15mm;">Jumlah Jam Hari Kerja</th>
        </tr>
        @foreach ($data as $item)
            <tr>
                <td style="text-align: center">{{ $loop->iteration }}.</td>
                <td>{{ $item->nama }}</td>
                <td style="text-align: center">{{ $item->nip }}</td>
                <td style="text-align: center">{{ $item->jumlahjamkerja }} jam</td>
                <td style="text-align: center">{{ $item->jumlahjamlibur }} jam</td>
            </tr>
        @endforeach
    </table>
    <br>
    <p class="paragraph">Apabila dikemudian hari terdapat kelebihan atas pembayaran uang makan, kami bersedia untuk
        menyetorkan
        kelebihan tersebut ke Kas Negara.</p>
    <p class="paragraph">Demikian permohonan ini kami buat dengan sebenarnya untuk dipergunakan sebagaimana mestinya.
    </p>
    <br>
    <br>
    <table class="ttd">
        <tr>
            <td class="ttd-blank">
            </td>
            <td class="ttd-box">
                {{ $kop->kota }}, {{ \Carbon\Carbon::parse($tanggal)->locale('id_ID')->isoFormat('D MMMM Y') }}
            </td>
        </tr>
        <tr>
            <td class="ttd-blank">
            </td>
            <td class="ttd-box">
                {{ $permohonan->jabatan }}
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="height: 100px; vertical-align: middle; padding-left: 50px">$</td>
        </tr>
        <tr>
            <td></td>
            <td>{{ $permohonan->nama }}</td>
        </tr>
        <tr>
            <td></td>
            <td>NIP {{ $permohonan->nip }}</td>
        </tr>
    </table>
</page>
