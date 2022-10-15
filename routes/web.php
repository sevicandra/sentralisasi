<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\MonitoringLaporanController;
use App\Http\Controllers\MonitoringRincianController;

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
    Route::get('/monitoring/daftar', 'daftar');
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