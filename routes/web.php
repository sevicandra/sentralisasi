<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\MonitoringLaporanController;
use App\Http\Controllers\MonitoringRincianController;
use App\Http\Controllers\MonitoringPelaporanController;
use App\Http\Controllers\PembayaranUangMakanController;
use App\Http\Controllers\PembayaranUangLemburController;
use App\Http\Controllers\MonitoringPenghasilanController;
use App\Http\Controllers\PembayaranDokumenUangMakanController;
use App\Http\Controllers\PembayaranDokumenUangLemburController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::controller(MonitoringController::class)->group(function(){
    Route::get('/monitoring', 'index');
    Route::get('/monitoring/detail', 'detail');
});

Route::controller(MonitoringRincianController::class)->group(function(){
    Route::get('/monitoring/rincian', 'index');
    Route::get('/monitoring/rincian/penghasilan', 'penghasilan');
    Route::get('/monitoring/rincian/gaji', 'gaji');
    Route::get('/monitoring/rincian/uang-makan', 'uang_makan');
    Route::get('/monitoring/rincian/uang-lembur', 'uang_lembur');
    Route::get('/monitoring/rincian/tunjangan-kinerja', 'tunjangan_kinerja');
    Route::get('/monitoring/rincian/lainnya', 'lainnya');
    Route::get('/monitoring/rincian/lainnya/detail', 'lainnya_detail');
    Route::get('/monitoring/rincian/penghasilan/daftar', 'penghasilan_daftar');
    Route::get('/monitoring/rincian/penghasilan/surat', 'penghasilan_surat');
});

Route::controller(MonitoringLaporanController::class)->group(function(){
    Route::get('/monitoring/laporan', 'index');
    Route::get('/monitoring/laporan/profil', 'profil');
    Route::get('/monitoring/laporan/profil/kp4', 'profil_kp4');
    Route::get('/monitoring/laporan/pph-pasal-21', 'pph_pasal_21');
    Route::get('/monitoring/laporan/pph-pasal-21/cetak', 'pph_pasal_21_cetak');
    Route::get('/monitoring/laporan/pph-pasal-21-final', 'pph_pasal_21_final');
    Route::get('/monitoring/laporan/pph-pasal-21-final/cetak', 'pph_pasal_21_final_cetak');
    Route::get('/monitoring/laporan/penghasilan-tahunan', 'penghasilan_tahunan');
    // Route::get('/monitoring/laporan/dokumen-perubahan', 'dokumen_perubahan');
});

Route::controller(MonitoringPenghasilanController::class)->group(function(){
    Route::get('monitoring/penghasilan', 'index');
    Route::get('monitoring/penghasilan/satker', 'satker');
    Route::get('monitoring/penghasilan/satker/penghasilan', 'satker_penghasilan');
    Route::get('/monitoring/penghasilan/satker/gaji', 'satker_gaji');
    Route::get('/monitoring/penghasilan/satker/uang-makan', 'satker_uang_makan');
    Route::get('/monitoring/penghasilan/satker/uang-lembur', 'satker_uang_lembur');
    Route::get('/monitoring/penghasilan/satker/tunjangan-kinerja', 'satker_tunjangan_kinerja');
    Route::get('/monitoring/penghasilan/satker/lainnya', 'satker_lainnya');
    Route::get('/monitoring/penghasilan/satker/lainnya/detail', 'satker_lainnya_detail');
    Route::get('/monitoring/penghasilan/satker/penghasilan/daftar', 'satker_penghasilan_daftar');
    Route::get('/monitoring/penghasilan/satker/penghasilan/surat', 'satker_penghasilan_surat');

});

Route::controller(MonitoringPelaporanController::class)->group(function(){
    Route::get('/monitoring/pelaporan', 'index');
    Route::get('/monitoring/pelaporan/satker', 'satker');
    Route::get('/monitoring/pelaporan/satker/profil', 'satker_profil');
    Route::get('/monitoring/pelaporan/satker/profil/kp4', 'satker_profil_kp4');
    Route::get('/monitoring/pelaporan/satker/pph-pasal-21', 'satker_pph_pasal_21');
    Route::get('/monitoring/pelaporan/satker/pph-pasal-21/cetak', 'satker_pph_pasal_21_cetak');
    Route::get('/monitoring/pelaporan/satker/pph-pasal-21-final', 'satker_pph_pasal_21_final');
    Route::get('/monitoring/pelaporan/satker/pph-pasal-21-final/cetak', 'satker_pph_pasal_21_final_cetak');
    Route::get('/monitoring/pelaporan/satker/penghasilan-tahunan', 'satker_penghasilan_tahunan');
});

Route::controller(PembayaranController::class)->group(function(){
    Route::get('/pembayaran', 'index');
    Route::get('/pembayaran/detail', 'detail');
});

Route::controller(PembayaranUangMakanController::class)->group(function(){
    Route::get('/pembayaran/uang-makan', 'index');
    Route::get('/pembayaran/uang-makan/create', 'create');
    Route::post('/pembayaran/uang-makan/store', 'store');
    Route::get('/pembayaran/uang-makan/edit', 'edit');
    Route::patch('/pembayaran/uang-makan/update', 'update');
});

Route::controller(PembayaranUangLemburController::class)->group(function(){
    Route::get('/pembayaran/uang-lembur', 'index');
    Route::get('/pembayaran/uang-lembur/create', 'create');
    Route::post('/pembayaran/uang-lembur/store', 'store');
    Route::get('/pembayaran/uang-lembur/edit', 'edit');
    Route::patch('/pembayaran/uang-lembur/update', 'update');
});

Route::controller(PembayaranDokumenUangMakanController::class)->group(function(){
    Route::get('/pembayaran/dokumen-uang-makan', 'index');
    Route::get('/pembayaran/dokumen-uang-makan/detail', 'detail');
});

Route::controller(PembayaranDokumenUangLemburController::class)->group(function(){
    Route::get('/pembayaran/dokumen-uang-lembur', 'index');
    Route::get('/pembayaran/dokumen-uang-lembur/detail', 'detail');
});

Route::controller(AdminController::class)->group(function(){
    Route::get('/admin', 'index');
});