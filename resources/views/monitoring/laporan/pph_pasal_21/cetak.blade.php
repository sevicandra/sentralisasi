<style type="text/css">
    table.page_header {
        width: 100%;
        border: none;
        padding: 0mm;
        border-spacing: 0px;
        margin-top: 5px;
        margin-left: 20px;
        align-content: center;
        align-items: center;
        align-self: center;
        box-align: center;
        text-align: center;
    }

    table.page_header_garis {
        width: 100%;
        border: none;
        border-bottom: solid 1mm #77797a;
        padding: 0mm;
        border-spacing: 0px;
        margin-top: 5px;
        margin-left: 20px;
    }

    table.page_footer {
        width: 100%;
        border: none;
        padding: 0mm;
        font-size: 7px;
    }

    table.page {
        width: 100%;
        border: 1px;
        padding: 1mm;
        font-size: 13px;
    }

    table.detail {
        width: 100%;
        padding: 0mm;
        font-size: 13px;
        border-collapse: collapse;
        border: 1px solid black;
    }

    td.data {
        border: 1px solid black;
        font-size: 11px;
    }

    td.angka {
        border: 1px solid black;
        font-size: 11px;
        padding-top: 3px;
        padding-bottom: 3px;
    }

    td.kosong {
        font-size: 11px;
    }

    td.kosongatas {
        font-size: 11px;
        padding-top: 2px;
        padding-bottom: 2px;
    }

    td.head {
        border: 1px solid black;
        font-size: 13px;
    }

    td.headangka {
        border: 1px solid black;
        text-align: right;
        padding-right: 5px;
        font-size: 13px;
    }

    p.judul {
        font-size: 11px;
    }
</style>

<page backtop="0mm" backbottom="0mm" backleft="0mm" backright="0mm">

    <page_header>
    </page_header>
    <page_footer>

    </page_footer>

    <table class="detail">
        <tr>
            <td class="angka" style="width:25%; border-bottom:none; text-align:center;">
                {{-- <img src="" alt="logo kemenkeu" width="70"> --}}
            </td>
            <td class="angka" style="width:50%; text-align:center; padding-top:5px; padding-bottom:5px; font-size: 12px;">
                <strong>BUKTI PEMOTONGAN PAJAK PENGHASILAN</strong><br>
                <strong>PASAL 21 BAGI PEGAWAI NEGERI SIPIL ATAU</strong><br>
                <strong>ANGGOTA TENTARA NASIONAL INDONESIA</strong><br>
                <strong>ATAU ANGGOTA POLISI REPUBLIK INDONESIA</strong><br>
                <strong>ATAU PEJABAT NEGARA ATAU PENSIUNANNYA</strong>
            </td>
            <td rowspan="2" class="angka" style="width:25%; padding-top:0px; margin-top: 0px; padding-left:10px; padding-bottom:0px; text-align:center; border-bottom:none;">
                <span style="font-size: 13px;"><strong>FORMULIR 1721 - A2</strong></span><br><br>
                <span style="font-size: 8px;">Lembar ke-1 : untuk Penerima Penghasilan</span><br>
                <span style="font-size: 8px;">Lembar ke-2 : untuk Pemotong</span><br>
                <span style="font-size: 9px;"><strong>MASA PEROLEHAN</strong></span><br>
                <span style="font-size: 9px;"><strong>PENGHASILAN [mm - mm]</strong></span><br>
                <span style="font-size: 9px;"><strong>01 - 12</strong></span>
            </td>
        </tr>
        <tr>
            <td class="angka" style="font-size: 10px; text-align:center; border-bottom:none;">
                <strong>KEMENTERIAN KEUANGAN RI</strong><br>
                <strong>DIREKTORAT JENDERAL PAJAK</strong>
            </td>
            <td class="angka" style="text-align:center; font-size: 10px; padding-top:2px; padding-bottom:2px; border-bottom:none;">Nomor : <span style="margin-left: 5px; margin-right: 5px;">1</span>/1721-A2/2022</td>
        </tr>
    </table>

    <table style="border: 1px solid black; width: 100%;">
        <tr>
            <td class="kosong" style="width:20%; padding-left:20px; padding-top:3px;">NAMA INSTANSI/ BADAN LAIN</td>
            <td class="kosong" style="width:3%; padding-top:3px;">:</td>
            <td class="kosong" style="width:55%; padding-top:3px;"></td>
            <td class="kosong" style="width:22%; padding-top:3px;">NPWP BENDAHARA :</td>
        </tr>
        <tr>
            <td class="kosong" style="padding-left:20px; padding-bottom:3px;">NAMA BENDAHARA</td>
            <td class="kosong" style="padding-bottom:3px;">:</td>
            <td class="kosong" style="padding-bottom:3px;">BENDAHARA PENGELUARAN </td>
            {{-- <?php $np = $profil['npwp_bendahara']; ?>  --}}
            <td class="kosong" style="padding-bottom:3px;"></td>
        </tr>
    </table>

    <p class="judul" style="margin-top:5px; margin-bottom:5px;"><strong>A. IDENTITAS PENERIMA PENGHASILAN YANG DIPOTONG</strong></p>

    <table style="border: 1px solid black; width: 100%;">
        <tr>
            <td class="kosongatas" style="width:17%; padding-left:20px; padding-top:3px;">1. NPWP</td>
            <td class="kosongatas" style="width:3%; padding-top:3px;">:</td>
            <td class="kosongatas" style="width:33%; padding-top:3px;"></td>
            <td class="kosongatas" style="width:16%; padding-top:3px;">6. JENIS KELAMIN</td>
            <td class="kosongatas" style="width:2%; padding-top:3px;">:</td>
            <td class="kosongatas" style="width:29%; padding-top:3px;"></td>
        </tr>
        <tr>
            <td class="kosongatas" style="padding-left:20px;">2. NIP</td>
            <td class="kosongatas">:</td>
            <td class="kosongatas"></td>
            <td class="kosongatas">7. NIK</td>
            <td class="kosongatas">:</td>
            <td class="kosongatas"></td>
        </tr>
        <tr>
            <td class="kosongatas" style="padding-left:20px;">3. NAMA</td>
            <td class="kosongatas">:</td>
            <td class="kosongatas"></td>
            <td colspan="3" class="kosongatas">8. STATUS/ JUMLAH TANGGUNGAN KELUARGA UNTUK PTKP</td>
        </tr>
        <tr>
            <td class="kosongatas" style="padding-left:20px;">4. PANGKAT/ GOL</td>
            <td class="kosongatas">:</td>
            <td class="kosongatas"></td>
            <td class="kosongatas"></td>
            <td class="kosongatas">:</td>
            <td class="kosongatas"></td>
        </tr>
        <tr>
            <td class="kosongatas" style="width:17%; padding-left:20px; padding-bottom:3px;">5. ALAMAT</td>
            <td class="kosongatas" style="width:3%; padding-bottom:3px;">:</td>
            <td class="kosongatas" style="width:33%; padding-bottom:3px;"></td>
            <td class="kosongatas" style="width:16%; padding-bottom:3px;">9. NAMA JABATAN</td>
            <td class="kosongatas" style="width:2%; padding-bottom:3px;">:</td>
            <td class="kosongatas" style="width:29%; padding-bottom:3px;"></td>
        </tr>
    </table>

    <p class="judul" style="margin-top:5px; margin-bottom:5px;"><strong>B. RINCIAN PENGHASILAN DAN PENGHITUNGAN PPh PASAL 21</strong></p>

    <table class="detail">
        <tr style="text-align:center;">
            <td colspan="2" class="angka" style="width:88%;"><b>URAIAN</b></td>
            <td class="angka" style="width:12%;"><b>JUMLAH (Rp)</b></td>
        </tr>
        <tr>
            <td colspan="2" class="angka" style="padding-left:5px;"><b>KODE OBJEK PAJAK : 21-100-01</b></td>
            <td class="angka"></td>
        </tr>
        <tr>
            <td colspan="2" class="angka" style="padding-left:5px;"><b>PENGHASILAN BRUTO : </b></td>
            <td class="angka"></td>
        </tr>
        <tr>
            <td class="angka" style="width:3%; text-align:center;">1</td>
            <td class="angka" style="width:85%; padding-left:5px;">GAJI POKOK/ PENSIUN</td>
            <td class="angka" style="width:12%; text-align:right; padding-right:5px;"></td>
        </tr>
        <tr>
            <td class="angka" style="text-align:center;">2</td>
            <td class="angka" style="padding-left:5px;">TUNJANGAN ISTERI</td>
            <td class="angka" style="text-align:right; padding-right:5px;"></td>
        </tr>
        <tr>
            <td class="angka" style="text-align:center;">3</td>
            <td class="angka" style="padding-left:5px;">TUNJANGAN ANAK</td>
            <td class="angka" style="text-align:right; padding-right:5px;"></td>
        </tr>
        <tr>
            <td class="angka" style="text-align:center;">4</td>
            <td class="angka" style="padding-left:5px;">JUMLAH GAJI DAN TUNJANGAN KELUARGA (1+2+3)</td>
            <td class="angka" style="text-align:right; padding-right:5px;"></td>
        </tr>
        <tr>
            <td class="angka" style="text-align:center;">5</td>
            <td class="angka" style="padding-left:5px;">TUNJANGAN PERBAIKAN PENGHASILAN</td>
            <td class="angka" style="text-align:right; padding-right:5px;"></td>
        </tr>
        <tr>
            <td class="angka" style="text-align:center;">6</td>
            <td class="angka" style="padding-left:5px;">TUNJANGAN STRUKTURAL/ FUNGSIONAL</td>
            <td class="angka" style="text-align:right; padding-right:5px;"></td>
        </tr>
        <tr>
            <td class="angka" style="text-align:center;">7</td>
            <td class="angka" style="padding-left:5px;">TUNJANGAN BERAS</td>
            <td class="angka" style="text-align:right; padding-right:5px;"></td>
        </tr>
        <tr>
            <td class="angka" style="text-align:center;">8</td>
            <td class="angka" style="padding-left:5px;">TUNJANGAN KHUSUS</td>
            <td class="angka" style="text-align:right; padding-right:5px;"></td>
        </tr>
        <tr>
            <td class="angka" style="text-align:center;">9</td>
            <td class="angka" style="padding-left:5px;">TUNJANGAN LAIN-LAIN</td>
            <td class="angka" style="text-align:right; padding-right:5px;"></td>
        </tr>
        <tr>
            <td class="angka" style="text-align:center;">10</td>
            <td class="angka" style="padding-left:5px;">PENGHASILAN TETAP DAN TERATUR LAINNYA YANG PEMBAYARANNYA TERPISAH DARI PEMBAYARAN GAJI</td>
            <td class="angka" style="text-align:right; padding-right:5px;"></td>
        </tr>
        <tr>
            <td class="angka" style="text-align:center;">11</td>
            <td class="angka" style="padding-left:5px;">JUMLAH PENGHASILAN BRUTO (4 s/d 10)</td>
            <td class="angka" style="text-align:right; padding-right:5px;"></td>
        </tr>
        <tr>
            <td colspan="2" class="angka" style="width:88%; padding-left:5px;"><b>PENGURANGAN :</b></td>
            <td class="angka" style="width:12%;"></td>
        </tr>
        <tr>
            <td class="angka" style="width:3%; text-align:center;">12</td>
            <td class="angka" style="width:85%; padding-left:5px;">BIAYA JABATAN/ BIAYA PENSIUN</td>
            <td class="angka" style="width:12%; text-align:right; padding-right:5px;"></td>
        </tr>
        <tr>
            <td class="angka" style="text-align:center;">13</td>
            <td class="angka" style="padding-left:5px;">IURAN PENSIUN ATAU IURAN THT</td>
            <td class="angka" style="text-align:right; padding-right:5px;"></td>
        </tr>
        <tr>
            <td class="angka" style="text-align:center;">14</td>
            <td class="angka" style="padding-left:5px;">JUMLAH PENGURANGAN (12 + 13)</td>
            <td class="angka" style="text-align:right; padding-right:5px;"></td>
        </tr>
        <tr>
            <td colspan="2" class="angka" style="width:88%; padding-left:5px;"><b>PENGHITUNGAN PPh PASAL 21 :</b></td>
            <td class="angka" style="width:12%;"></td>
        </tr>
        <tr>
            <td class="angka" style="width:3%; text-align:center;">15</td>
            <td class="angka" style="width:85%; padding-left:5px;">JUMLAH PENGHASILAN NETTO (11 - 14)</td>
            <td class="angka" style="width:12%; text-align:right; padding-right:5px;"></td>
        </tr>
        <tr>
            <td class="angka" style="text-align:center;">16</td>
            <td class="angka" style="padding-left:5px;">JUMLAH PENGHASILAN MASA SEBELUMNYA</td>
            <td class="angka" style="text-align:right; padding-right:5px;">0</td>
        </tr>
        <tr>
            <td class="angka" style="text-align:center;">17</td>
            <td class="angka" style="padding-left:5px;">JUMLAH PENGHASILAN NETTO UNTUK PENGHITUNGAN PPh PASAL 21 (SETAHUN/ DISETAHUNKAN)</td>
            <td class="angka" style="text-align:right; padding-right:5px;"></td>
        </tr>
        <tr>
            <td class="angka" style="text-align:center;">18</td>
            <td class="angka" style="padding-left:5px;">PENGHASILAN TIDAK KENA PAJAK (PTKP)</td>
            <td class="angka" style="text-align:right; padding-right:5px;"></td>
        </tr>
        <tr>
            <td class="angka" style="text-align:center;">19</td>
            <td class="angka" style="padding-left:5px;">PENGHASILAN KENA PAJAK SETAHUN/ DISETAHUNKAN (17 - 18)</td>
            <td class="angka" style="text-align:right; padding-right:5px;"></td>
        </tr>
        <tr>
            <td class="angka" style="text-align:center;">20</td>
            <td class="angka" style="padding-left:5px;">PPh PASAL 21 ATAS PENGHASILAN KENA PAJAK SETAHUN/ DISETAHUNKAN</td>
            <td class="angka" style="text-align:right; padding-right:5px;"></td>
        </tr>
        <tr>
            <td class="angka" style="text-align:center;">21</td>
            <td class="angka" style="padding-left:5px;">PPh PASAL 21 YANG TELAH DIPOTONG MASA SEBELUMNYA</td>
            <td class="angka" style="text-align:right; padding-right:5px;">0</td>
        </tr>
        <tr>
            <td class="angka" style="text-align:center;">22</td>
            <td class="angka" style="padding-left:5px;">PPh PASAL 21 TERUTANG</td>
            <td class="angka" style="text-align:right; padding-right:5px;"></td>
        </tr>
        <tr>
            <td class="angka" style="text-align:center;">23</td>
            <td class="angka" style="padding-left:5px;">PPh PASAL 21 YANG TELAH DIPOTONG DAN DILUNASI</td>
            <td class="angka" style="text-align:right; padding-right:5px;"></td>
        </tr>
        <tr>
            <td class="angka" style="text-align:center;"></td>
            <td class="angka" style="padding-left:5px;">23A. ATAS GAJI DAN TUNJANGAN</td>
            <td class="angka" style="text-align:right; padding-right:5px;"></td>
        </tr>
        <tr>
            <td class="angka" style="text-align:center;"></td>
            <td class="angka" style="padding-left:5px;">23B. ATAS PENGHASILAN TIDAK TETAP DAN TERATUR LAINNYA YANG PEMBAYARANNYA TERPISAH DARI GAJI</td>
                <td class="angka" style="text-align:right; padding-right:5px;"></td>
        </tr>
    </table>

    <p class="judul" style="margin-top:4px; margin-bottom:4px;"><strong>C. PEGAWAI TERSEBUT :</strong></p>
    <p class="judul" style="margin-top:4px; margin-bottom:4px;"><strong>D. TANDATANGAN BENDAHARA</strong></p>

    <table style="border: 1px solid black; width: 100%;">
        <tr>
            <td class="kosong" style="width:17%; padding-left:20px; padding-bottom:10px; padding-top:5px;">1. NPWP</td>
            <td class="kosong" style="width:3%; padding-bottom:10px; padding-top:5px;">:</td>
            <td class="kosong" style="width:33%; padding-bottom:10px; padding-top:5px;"></td>
            <td class="kosong" style="width:22%; padding-bottom:10px; padding-top:5px;">4. TANGGAL & TTD</td>
                <td rowspan="3" class="angka" style="width:25%;"></td>
        </tr>
        <tr>
            <td class="kosong" style="padding-left:20px; padding-bottom:10px;">2. NAMA</td>
            <td class="kosong" style="padding-bottom:10px;">:</td>
            <td class="kosong" style="padding-bottom:10px;"></td>
            <td class="kosong"></td>
        </tr>
        <tr>
            <td class="kosong" style="padding-left:20px; padding-bottom:5px;">3. NIP/ NRP</td>
            <td class="kosong" style="padding-bottom:5px;">:</td>
            <td class="kosong" style="padding-bottom:5px;"></td>
                <td class="kosong" style="padding-left:15px; padding-bottom:5px;">[dd - mm - yyyy]</td>
        </tr>
    </table>

</page>