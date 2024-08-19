<style type="text/css">
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    .header {
        position: relative;
    }

    .header table {
        top: 0px;
        right: 75mm;
        position: absolute;
    }

    .title {
        text-align: justify;
        text-indent: 6.3mm;
        font-size: 11pt;
        line-height: 1.5;
        text-align: center;
    }

    .rotate-text {
        rotate: -90;
        width: 15mm;
        height: 8mm;
        position: absolute;
        left: -2mm
    }

    .content {
        border-collapse: collapse;
        table-layout: fixed;
        font-size: 7pt;
    }

    .content td,
    .content th {
        border: 1px solid black;
        padding: 3px 0;
    }

    .content th {
        text-align: center
    }

    .ttd {
        width: 100%;
    }

    .ttd-blank {
        width: 240mm
    }

    .ttd-box {
        width: 50mm;
        padding: 1mm
    }
</style>

<page backtop="0mm" backbottom="0mm" backleft="0mm" backright="0mm">
    <div class="header">
        <table>
            <tr>
                <td colspan="3">Lampiran Permohonan Pembayaran Uang Makan</td>
            </tr>
            <tr>
                <td style="width: 20mm">Nomor</td>
                <td style="width: 1mm">:</td>
                <td style="width: 54mm">LBKP-{{ $nomor }}</td>
            </tr>
            <tr>
                <td style="width: 20mm">Tanggal</td>
                <td style="width: 1mm">:</td>
                <td style="width: 54mm">{{ \Carbon\Carbon::parse($tanggal)->locale('id_ID')->isoFormat('D MMMM Y') }}</td>
            </tr>
        </table>
    </div>
    <br>
    <br>
    <br>
    <p class="title">
        Rekap Absensi Uang Makan
    </p>
    <p class="title">
        Periode Juni 2024
    </p>
    <br>


    <table class="content">
        <tr>
            <th rowspan="2" style="width: 6mm">No.</th>
            <th rowspan="2" style="width: 35mm">Nama/NIP</th>
            <th colspan="{{ $daysInMonth }}">Tanggal</th>
        </tr>
        <tr>
            @for ($i = 1; $i <= $daysInMonth; $i++)
                <th>{{ $i }}</th>
            @endfor
        </tr>
        @foreach ($data as $item)
            <tr>
                <td style="text-align: center">{{ $loop->iteration }}</td>
                <td style="padding: 3px">{{ $item->nama }} <br> {{ $item->nip }}</td>
                @for ($i = 1; $i <= $daysInMonth; $i++)
                    <td>
                        <div style="width: 8mm; height: 15mm; overflow: visible; position: relative">
                            <div style="" class="rotate-text">
                                <div style="width: 100%; height: 100%; text-align: center;">
                                    {{ optional($item->data->where('tanggal', \Carbon\Carbon::parse($thn . '-' . $bln . '-' . $i)->format('Y-m-d'))->first())->absensimasuk }}
                                    -
                                    {{ optional($item->data->where('tanggal', \Carbon\Carbon::parse($thn . '-' . $bln . '-' . $i)->format('Y-m-d'))->first())->absensikeluar }}
                                </div>
                            </div>
                        </div>
                    </td>
                @endfor
            </tr>
        @endforeach
    </table>
    <br>
    <br>
    <table class="ttd">
        <tr>
            <td class="ttd-blank">
            </td>
            <td class="ttd-box">
                {{ $permohonan->jabatan}}
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="height: 100px; vertical-align: middle; padding-left: 50px">$</td>
        </tr>
        <tr>
            <td></td>
            <td>{{ $permohonan->nama}}</td>
        </tr>
        <tr>
            <td></td>
            <td>NIP {{ $permohonan->nip}}</td>
        </tr>
    </table>
</page>
