@extends('layout.main')
@section('aside-menu')
    @include('monitoring.sidemenu')
@endsection         
@section('main-content')

    <div id="main-content-header">
        <div class="row">
            <div class="row">
                <div class="row mb-3">
                    <div class="col-lg-8">
                        <a href="" class="btn btn-sm btn-outline-success ml-1 mt-1 mb-1">2022</a>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-8">
                        <a href="{{ Request::url() }}/pph-pasal-21/cetak" class="btn btn-sm btn-outline-success">Download Form 1721-A2</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="main-content">
        <div class="row">
            <div class="col-lg-8">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Uraian</th>
                                <th>Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th colspan="3">Penghasilan Bruto :</th>
                            </tr>
                            <tr>
                                <td class="text-center">1</td>
                                <td>Gaji Pokok</td>
                                <td class="text-right"></td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td>Tunjangan Istri/Suami</td>
                                <td class="text-right"></td>
                            </tr>
                            <tr>
                                <td class="text-center">3</td>
                                <td>Tunjangan Anak</td>
                                <td class="text-right"></td>
                            </tr>
                            <tr>
                                <td class="text-center">4</td>
                                <td>Jumlah Gaji dan Tunjangan Keluarga <small>(No.1 s/d No.3)</small></td>
                                <td class="text-right"></td>
                            </tr>
                            <tr>
                                <td class="text-center">5</td>
                                <td>Tunjangan Perbaikan Penghasilan</td>
                                <td class="text-right"></td>
                            </tr>
                            <tr>
                                <td class="text-center">6</td>
                                <td>Tunjangan Struktural/Fungsional</td>
                                <td class="text-right"></td>
                            </tr>
                            <tr>
                                <td class="text-center">7</td>
                                <td>Tunjangan Beras</td>
                                <td class="text-right"></td>
                            </tr>
                            <tr>
                                <td class="text-center">8</td>
                                <td>Tunjangan Khusus</td>
                                <td class="text-right"></td>
                            </tr>
                            <tr>
                                <td class="text-center">9</td>
                                <td>Tunjangan Lain-lain</td>
                                <td class="text-right"></td>
                            </tr>
                            <tr>
                                <td class="text-center">10</td>
                                <td>Penghasilan Tetap dan Teratur Lainnya yang Pembayarannya Terpisah dari Pembayaran Gaji</td>
                                <td class="text-right"></td>
                            </tr>
                            <tr>
                                <td class="text-center">11</td>
                                <td>Jumlah Penghasilan Bruto <small>(No.4 s/d No.10)</small></td>
                                <td class="text-right"></td>
                            </tr>
                            <tr>
                                <th colspan="3">Pengurangan :</th>
                            </tr>
                            <tr>
                                <td class="text-center">12</td>
                                <td>Biaya Jabatan <small>(5% <small>X</small> No.11 Maks. 6.000.000)</small></td>
                                <td class="text-right"></td>
                            </tr>
                            <tr>
                                <td class="text-center">13</td>
                                <td>Iuran Pensiun <small>(4,75% <small>X</small> No.4)</small></td>
                                <td class="text-right"></td>
                            </tr>
                            <tr>
                                <td class="text-center">14</td>
                                <td>Jumlah Pengurangan <small>(No.12 s/d No.13)</small></td>
                                <td class="text-right"></td>
                            </tr>
                            <tr>
                                <th colspan="3">Penghitungan PPh Pasal 21 :</th>
                            </tr>
                            <tr>
                                <td class="text-center">15</td>
                                <td>Jumlah Penghasilan Netto <small>(No.11 - No.14)</small></td>
                                <td class="text-right"></td>
                            </tr>
                            <tr>
                                <td class="text-center">16</td>
                                <td>Jumlah Penghasilan Masa Sebelumnya</td>
                                <td class="text-right">0</td>
                            </tr>
                            <tr class="text-bold text-success">
                                <td class="text-center">17</td>
                                <td>Jumlah Penghasilan Netto untuk Penghitungan PPh Pasal 21 (Setahun/Disetahunkan)</td>
                                <td class="text-right"></td>
                            </tr>
                            <tr class="text-bold text-success">
                                <td class="text-center">18</td>
                                <td>Penghasilan Tidak Kena Pajak (PTKP)</td>
                                <td class="text-right"></td>
                            </tr>
                            <tr>
                                <td class="text-center">19</td>
                                <td>Penghasilan Kena Pajak Setahun/Disetahunkan <small>(17 - 18)</small></td>
                                <td class="text-right"></td>
                            </tr>
                            <tr>
                                <td class="text-center">20</td>
                                <td>PPh Pasal 21 Atas Penghasilan Kena Pajak Setahun/Disetahunkan</td>
                                <td class="text-right"></td>
                            </tr>
                            <tr>
                                <td class="text-center">21</td>
                                <td>PPh Pasal 21 Yang Telah DIpotong Masa Sebelumnya</td>
                                <td class="text-right">0</td>
                            </tr>
                            <tr class="text-bold text-success">
                                <td class="text-center">22</td>
                                <td>PPh Pasal 21 Terutang</td>
                                <td class="text-right"></td>
                            </tr>
                            <tr class="text-bold text-success">
                                <td class="text-center">23</td>
                                <td>PPh Pasal 21 Yang Telah Dipotong dan Dilunasi</td>
                                <td class="text-right"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>A. Atas Gaji dan Tunjangan</td>
                                <td class="text-right"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>B. Atas Penghasilan Tidak Tetap dan Teratur Lainnya yang Pembayarannya Terpisah dari Pembayaran Gaji</td>
                                <td class="text-right"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="paginator">
        {{-- {{$data->links()}} --}}
    </div>


@endsection