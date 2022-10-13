<?php

use App\Http\Controllers\MonitoringController;
use Illuminate\Support\Facades\Route;

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
    Route::get('/monitoring/rincian', 'index_rincian');
    Route::get('/monitoring/rincian/penghasilan', 'rincian_penghasilan');
    Route::get('/monitoring/rincian/gaji', 'rincian_gaji');
    Route::get('/monitoring/rincian/uang-makan', 'rincian_uang_makan');
    Route::get('/monitoring/rincian/uang-lembur', 'rincian_uang_lembur');
    Route::get('/monitoring/rincian/tunjangan-kinerja', 'rincian_tunjangan_kinerja');
    Route::get('/monitoring/rincian/lainnya', 'rincian_lainnya');
});

