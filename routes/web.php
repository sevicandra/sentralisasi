<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SptController;
use App\Http\Controllers\SsoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminRoleController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Belanja51Controller;
use App\Http\Controllers\AdminBulanController;
use App\Http\Controllers\HonorariumController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\AdminSatkerController;
use App\Http\Controllers\DataPaymentController;
use App\Http\Controllers\Belanja51TTEController;
use App\Http\Controllers\SptMonitoringController;
use App\Http\Controllers\Belanja51MakanController;
use App\Http\Controllers\PusatBelanja51Controller;
use App\Http\Controllers\SewaRumahDinasController;
use App\Http\Controllers\Belanja51LemburController;
use App\Http\Controllers\DataPaymentLainController;
use App\Http\Controllers\AdminAdminSatkerController;
use App\Http\Controllers\DataPaymentServerController;
use App\Http\Controllers\MonitoringLaporanController;
use App\Http\Controllers\MonitoringRincianController;
use App\Http\Controllers\PusatBelanja51TTEController;
use App\Http\Controllers\AdminPenandatanganController;
use App\Http\Controllers\MonitoringBelanja51Controller;
use App\Http\Controllers\MonitoringPelaporanController;
use App\Http\Controllers\PembayaranUangMakanController;
use App\Http\Controllers\PusatBelanja51MakanController;
use App\Http\Controllers\Belanja51CreateMakanController;
use App\Http\Controllers\PembayaranUangLemburController;
use App\Http\Controllers\PusatBelanja51LemburController;
use App\Http\Controllers\SewaRumahDinasRejectController;
use App\Http\Controllers\SewaRumahDinasUsulanController;
use App\Http\Controllers\AdminRefPenandatanganController;
use App\Http\Controllers\Belanja51AbsensiMakanController;
use App\Http\Controllers\Belanja51CreateLemburController;
use App\Http\Controllers\DataPaymentHonorariumController;
use App\Http\Controllers\DataPaymentUploadLainController;
use App\Http\Controllers\MonitoringPenghasilanController;
use App\Http\Controllers\Belanja51AbsensiLemburController;
use App\Http\Controllers\SewaRumahDinasNonAktifController;
use App\Http\Controllers\MonitoringBelanja51PusatController;
use App\Http\Controllers\SewaRumahDinasMonitoringController;
use App\Http\Controllers\PusatBelanja51CreateMakanController;
use App\Http\Controllers\SewaRumahDinasPenghentianController;
use App\Http\Controllers\PembayaranDokumenUangMakanController;
use App\Http\Controllers\PembayaranUangMakanWilayahController;
use App\Http\Controllers\PusatBelanja51AbsensiMakanController;
use App\Http\Controllers\PusatBelanja51CreateLemburController;
use App\Http\Controllers\DataPaymentUploadHonorariumController;
use App\Http\Controllers\MonitoringBelanja51VertikalController;
use App\Http\Controllers\PembayaranDokumenUangLemburController;
use App\Http\Controllers\PembayaranUangLemburWilayahController;
use App\Http\Controllers\PusatBelanja51AbsensiLemburController;
use App\Http\Controllers\SewaRumahDinasMonitoringWilayahController;
use App\Http\Controllers\SewaRumahDinasMonitoringNonAktifController;

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

Route::get('/api/sso', [SsoController::class, 'sign_in'])->middleware('guest:web,admin');

Route::get('/sso', [SsoController::class, 'sso'])->middleware('guest:web,admin');

Route::get('/', [HomeController::class, 'index'])->middleware('auth:web,admin');

Route::get('/login', function () {
    return view('welcome');
})->name('sign-in')->middleware('guest:web,admin');

Route::controller(LoginController::class)->group(function () {
    Route::get('/logout', 'logout')->middleware('auth:web,admin');
});

Route::controller(MonitoringController::class)->middleware('can:monitoring')->group(function () {
    Route::get('/monitoring', 'index')->middleware('auth:web,admin');
    Route::get('/monitoring/detail', 'detail')->middleware('auth:web,admin');
});

Route::controller(MonitoringRincianController::class)->middleware('can:monitoring')->group(function () {
    Route::get('/monitoring/rincian', 'index')->middleware('auth:web,admin');
    Route::get('/monitoring/rincian/{nip}/penghasilan', 'penghasilan')->middleware('auth:web,admin');
    Route::get('/monitoring/rincian/{nip}/penghasilan/{thn}', 'penghasilan')->middleware('auth:web,admin');
    Route::get('/monitoring/rincian/{nip}/gaji', 'gaji')->middleware('auth:web,admin');
    Route::get('/monitoring/rincian/{nip}/gaji/{thn}', 'gaji')->middleware('auth:web,admin');
    Route::get('/monitoring/rincian/{nip}/gaji/{thn}/{jns}', 'gaji')->middleware('auth:web,admin');
    Route::get('/monitoring/rincian/{nip}/uang-makan', 'uang_makan')->middleware('auth:web,admin');
    Route::get('/monitoring/rincian/{nip}/uang-makan/{thn}', 'uang_makan')->middleware('auth:web,admin');
    Route::get('/monitoring/rincian/{nip}/uang-lembur', 'uang_lembur')->middleware('auth:web,admin');
    Route::get('/monitoring/rincian/{nip}/tunjangan-kinerja', 'tunjangan_kinerja')->middleware('auth:web,admin');
    Route::get('/monitoring/rincian/{nip}/tunjangan-kinerja/{thn}', 'tunjangan_kinerja')->middleware('auth:web,admin');
    Route::get('/monitoring/rincian/{nip}/tunjangan-kinerja/{thn}/{jns}', 'tunjangan_kinerja')->middleware('auth:web,admin');
    Route::get('/monitoring/rincian/{nip}/lainnya', 'lainnya')->middleware('auth:web,admin');
    Route::get('/monitoring/rincian/{nip}/lainnya/{thn}', 'lainnya')->middleware('auth:web,admin');
    Route::get('/monitoring/rincian/{nip}/lainnya/{thn}/{jns}', 'lainnya')->middleware('auth:web,admin');
    // Route::get('/monitoring/rincian/{nip}/lainnya/{thn}/{jns}/{bln}/detail', 'lainnya_detail')->middleware('auth:web,admin');
    // Route::get('/monitoring/rincian/penghasilan/{nip}/{thn}/{bln}/daftar', 'penghasilan_daftar')->middleware('auth:web,admin');
    // Route::get('/monitoring/rincian/penghasilan/{nip}/{thn}/{bln}/surat', 'penghasilan_surat')->middleware('auth:web,admin');
});

Route::controller(MonitoringLaporanController::class)->middleware('can:monitoring')->group(function () {
    Route::get('/monitoring/laporan', 'index')->middleware('auth:web,admin');
    Route::get('/monitoring/laporan/profil/{nip}', 'profil')->middleware('auth:web,admin');
    // Route::get('/monitoring/laporan/profil/kp4', 'profil_kp4')->middleware('auth:web,admin');
    Route::get('/monitoring/laporan/pph-pasal-21/{nip}', 'pph_pasal_21')->middleware('auth:web,admin');
    Route::get('/monitoring/laporan/pph-pasal-21/{nip}/{thn}', 'pph_pasal_21')->middleware('auth:web,admin');
    Route::get('/monitoring/laporan/pph-pasal-21/{nip}/{thn}/cetak', 'pph_pasal_21_cetak')->middleware('auth:web,admin');
    Route::get('/monitoring/laporan/pph-pasal-21-final/{nip}', 'pph_pasal_21_final')->middleware('auth:web,admin');
    Route::get('/monitoring/laporan/pph-pasal-21-final/{nip}/{thn}', 'pph_pasal_21_final')->middleware('auth:web,admin');
    Route::get('/monitoring/laporan/pph-pasal-21-final/{nip}/{thn}/cetak', 'pph_pasal_21_final_cetak')->middleware('auth:web,admin');
    Route::get('/monitoring/laporan/penghasilan-tahunan/{nip}', 'penghasilan_tahunan')->middleware('auth:web,admin');
    Route::get('/monitoring/laporan/penghasilan-tahunan/{nip}/{thn}', 'penghasilan_tahunan')->middleware('auth:web,admin');
    // Route::get('/monitoring/laporan/dokumen-perubahan', 'dokumen_perubahan')->middleware('auth:web,admin');
});

Route::controller(MonitoringPenghasilanController::class)->middleware('can:monitoring')->group(function () {
    Route::get('/monitoring/penghasilan', 'index')->middleware('auth:web,admin');
    Route::get('/monitoring/penghasilan/{satker:kdsatker}', 'satker')->middleware('auth:web,admin');
    Route::get('/monitoring/penghasilan/{satker:kdsatker}/{nip}/penghasilan', 'satker_penghasilan')->middleware('auth:web,admin');
    Route::get('/monitoring/penghasilan/{satker:kdsatker}/{nip}/penghasilan/{thn}', 'satker_penghasilan')->middleware('auth:web,admin');
    // Route::get('/monitoring/penghasilan/{satker:kdsatker}/{nip}/penghasilan/{nip}/{thn}', 'satker_penghasilan')->middleware('auth:web,admin');
    Route::get('/monitoring/penghasilan/{satker:kdsatker}/{nip}/gaji', 'satker_gaji')->middleware('auth:web,admin');
    Route::get('/monitoring/penghasilan/{satker:kdsatker}/{nip}/gaji/{thn}', 'satker_gaji')->middleware('auth:web,admin');
    Route::get('/monitoring/penghasilan/{satker:kdsatker}/{nip}/gaji/{thn}/{jns}', 'satker_gaji')->middleware('auth:web,admin');
    Route::get('/monitoring/penghasilan/{satker:kdsatker}/{nip}/uang-makan', 'satker_uang_makan')->middleware('auth:web,admin');
    Route::get('/monitoring/penghasilan/{satker:kdsatker}/{nip}/uang-makan/{thn}', 'satker_uang_makan')->middleware('auth:web,admin');
    Route::get('/monitoring/penghasilan/{satker:kdsatker}/{nip}/uang-lembur', 'satker_uang_lembur')->middleware('auth:web,admin');
    Route::get('/monitoring/penghasilan/{satker:kdsatker}/{nip}/tunjangan-kinerja', 'satker_tunjangan_kinerja')->middleware('auth:web,admin');
    Route::get('/monitoring/penghasilan/{satker:kdsatker}/{nip}/tunjangan-kinerja/{thn}', 'satker_tunjangan_kinerja')->middleware('auth:web,admin');
    Route::get('/monitoring/penghasilan/{satker:kdsatker}/{nip}/tunjangan-kinerja/{thn}/{jns}', 'satker_tunjangan_kinerja')->middleware('auth:web,admin');
    Route::get('/monitoring/penghasilan/{satker:kdsatker}/{nip}/lainnya', 'satker_lainnya')->middleware('auth:web,admin');
    Route::get('/monitoring/penghasilan/{satker:kdsatker}/{nip}/lainnya/{thn}', 'satker_lainnya')->middleware('auth:web,admin');
    Route::get('/monitoring/penghasilan/{satker:kdsatker}/{nip}/lainnya/{thn}/{jns}', 'satker_lainnya')->middleware('auth:web,admin');
    Route::get('/monitoring/penghasilan/{satker:kdsatker}/{nip}/lainnya/{thn}/{jns}/{bln}/detail', 'satker_lainnya_detail')->middleware('auth:web,admin');
});

Route::controller(MonitoringPelaporanController::class)->middleware('can:monitoring')->group(function () {
    Route::get('/monitoring/pelaporan', 'index')->middleware('auth:web,admin');
    Route::get('/monitoring/pelaporan/{satker:kdsatker}', 'satker')->middleware('auth:web,admin');
    Route::get('/monitoring/pelaporan/{satker:kdsatker}/profil/{nip}', 'satker_profil')->middleware('auth:web,admin');
    // Route::get('/monitoring/pelaporan/satker/profil/kp4', 'satker_profil_kp4')->middleware('auth:web,admin');
    Route::get('/monitoring/pelaporan/{satker:kdsatker}/pph-pasal-21/{nip}', 'satker_pph_pasal_21')->middleware('auth:web,admin');
    Route::get('/monitoring/pelaporan/{satker:kdsatker}/pph-pasal-21/{nip}/{thn}', 'satker_pph_pasal_21')->middleware('auth:web,admin');
    Route::get('/monitoring/pelaporan/{satker:kdsatker}/pph-pasal-21/{nip}/{thn}/cetak', 'satker_pph_pasal_21_cetak')->middleware('auth:web,admin');
    Route::get('/monitoring/pelaporan/{satker:kdsatker}/pph-pasal-21-final/{nip}', 'satker_pph_pasal_21_final')->middleware('auth:web,admin');
    Route::get('/monitoring/pelaporan/{satker:kdsatker}/pph-pasal-21-final/{nip}/{thn}', 'satker_pph_pasal_21_final')->middleware('auth:web,admin');
    Route::get('/monitoring/pelaporan/{satker:kdsatker}/pph-pasal-21-final/{nip}/{thn}/cetak', 'satker_pph_pasal_21_final_cetak')->middleware('auth:web,admin');
    Route::get('/monitoring/pelaporan/{satker:kdsatker}/penghasilan-tahunan/{nip}', 'satker_penghasilan_tahunan')->middleware('auth:web,admin');
    Route::get('/monitoring/pelaporan/{satker:kdsatker}/penghasilan-tahunan/{nip}/{thn}', 'satker_penghasilan_tahunan')->middleware('auth:web,admin');
});

Route::controller(PembayaranController::class)->middleware('can:belanja_51')->group(function () {
    Route::get('/belanja-51', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51/index', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51/index/{thn}', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51/uang-makan/{thn}/{bln}/detail', 'detailUM')->middleware('auth:web,admin');
    Route::get('/belanja-51/uang-lembur/{thn}/{bln}/detail', 'detailUL')->middleware('auth:web,admin');
    Route::get('/belanja-51/uang-makan/{um}/dokumen', 'dokumenUM')->middleware('auth:web,admin');
    Route::patch('/belanja-51/uang-lembur/{ul}/dokumen', 'dokumenUL')->middleware('auth:web,admin');
});

Route::controller(PembayaranUangMakanController::class)->middleware('can:belanja_51')->group(function () {
    Route::get('/belanja-51/uang-makan', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51/uang-makan/index', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51/uang-makan/index/{thn}', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51/uang-makan/create', 'create')->middleware('auth:web,admin');
    Route::post('/belanja-51/uang-makan/store', 'store')->middleware('auth:web,admin');
    Route::get('/belanja-51/uang-makan/{dokumenUangMakan}/edit', 'edit')->middleware('auth:web,admin');
    Route::patch('/belanja-51/uang-makan/{dokumenUangMakan}/update', 'update')->middleware('auth:web,admin');
    Route::delete('/belanja-51/uang-makan/{dokumenUangMakan}/delete', 'delete')->middleware('auth:web,admin');
    Route::get('/belanja-51/uang-makan/{dokumenUangMakan}/kirim', 'kirim')->middleware('auth:web,admin');
    Route::patch('/belanja-51/uang-makan/{dokumenUangMakan}/dokumen', 'dokumen')->middleware('auth:web,admin');
    Route::patch('/belanja-51/uang-makan/{dokumenUangMakan}/dokumen-excel', 'dokumen_excel')->middleware('auth:web,admin');
});

Route::controller(PembayaranUangLemburController::class)->middleware('can:belanja_51')->group(function () {
    Route::get('/belanja-51/uang-lembur', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51/uang-lembur/index', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51/uang-lembur/index/{thn}', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51/uang-lembur/create', 'create')->middleware('auth:web,admin');
    Route::post('/belanja-51/uang-lembur/store', 'store')->middleware('auth:web,admin');
    Route::get('/belanja-51/uang-lembur/{dokumenUangLembur}/edit', 'edit')->middleware('auth:web,admin');
    Route::patch('/belanja-51/uang-lembur/{dokumenUangLembur}/update', 'update')->middleware('auth:web,admin');
    Route::delete('/belanja-51/uang-lembur/{dokumenUangLembur}/delete', 'delete')->middleware('auth:web,admin');
    Route::get('/belanja-51/uang-lembur/{dokumenUangLembur}/kirim', 'kirim')->middleware('auth:web,admin');
    Route::patch('/belanja-51/uang-lembur/{dokumenUangLembur}/dokumen', 'kirim')->middleware('auth:web,admin');
    Route::patch('/belanja-51/uang-lembur/{dokumenUangLembur}/dokumen-excel', 'dokumen_excel')->middleware('auth:web,admin');
});

Route::controller(PembayaranUangMakanWilayahController::class)->middleware('can:belanja_51')->group(function () {
    Route::get('/belanja-51/wilayah/uang-makan', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51/wilayah/uang-makan/{thn}', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51/wilayah/uang-makan/{thn}/{bln}', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51/wilayah/uang-makan/{kdsatker}/{thn}/{bln}/detail', 'detail')->middleware('auth:web,admin');
    Route::patch('/belanja-51/wilayah/uang-makan/{dokumenUangMakan}/dokumen', 'dokumen')->middleware('auth:web,admin');
    Route::patch('/belanja-51/wilayah/uang-makan/{dokumenUangMakan}/dokumen-excel', 'dokumen_excel')->middleware('auth:web,admin');
});

Route::controller(PembayaranUangLemburWilayahController::class)->middleware('can:belanja_51')->group(function () {
    Route::get('/belanja-51/wilayah/uang-lembur', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51/wilayah/uang-lembur/{thn}', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51/wilayah/uang-lembur/{thn}/{bln}', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51/wilayah/uang-lembur/{kdsatker}/{thn}/{bln}/detail', 'detail')->middleware('auth:web,admin');
    Route::patch('/belanja-51/wilayah/uang-lembur/{dokumenUangLembur}/dokumen', 'dokumen')->middleware('auth:web,admin');
    Route::patch('/belanja-51/wilayah/uang-lembur/{dokumenUangLembur}/dokumen-excel', 'dokumen_excel')->middleware('auth:web,admin');
});

Route::controller(PembayaranDokumenUangMakanController::class)->middleware('can:belanja_51')->group(function () {
    Route::get('/belanja-51/dokumen-uang-makan', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51/dokumen-uang-makan/rekap', 'rekap')->middleware('auth:web,admin');
    Route::get('/belanja-51/dokumen-uang-makan/{thn}', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51/dokumen-uang-makan/{thn}/{bln}', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51/dokumen-uang-makan/{kdsatker}/{thn}/{bln}/detail', 'detail')->middleware('auth:web,admin');
    Route::delete('/belanja-51/dokumen-uang-makan/{dokumenUangMakan}', 'reject')->middleware('auth:web,admin');
    Route::patch('/belanja-51/dokumen-uang-makan/{dokumenUangMakan}/dokumen', 'dokumen')->middleware('auth:web,admin');
    Route::patch('/belanja-51/dokumen-uang-makan/{dokumenUangMakan}/dokumen-excel', 'dokumen_excel')->middleware('auth:web,admin');
    Route::patch('/belanja-51/dokumen-uang-makan/{dokumenUangMakan}/approve', 'approve')->middleware('auth:web,admin');
});

Route::controller(PembayaranDokumenUangLemburController::class)->middleware('can:belanja_51')->group(function () {
    Route::get('/belanja-51/dokumen-uang-lembur', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51/dokumen-uang-lembur/rekap', 'rekap')->middleware('auth:web,admin');
    Route::get('/belanja-51/dokumen-uang-lembur/{thn}', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51/dokumen-uang-lembur/{thn}/{bln}', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51/dokumen-uang-lembur/{kdsatker}/{thn}/{bln}/detail', 'detail')->middleware('auth:web,admin');
    Route::delete('/belanja-51/dokumen-uang-lembur/{dokumenUangLembur}', 'reject')->middleware('auth:web,admin');
    Route::patch('/belanja-51/dokumen-uang-lembur/{dokumenUangLembur}/dokumen', 'dokumen')->middleware('auth:web,admin');
    Route::patch('/belanja-51/dokumen-uang-lembur/{dokumenUangLembur}/dokumen-excel', 'dokumen_excel')->middleware('auth:web,admin');
    Route::patch('/belanja-51/dokumen-uang-lembur/{dokumenUangLembur}/approve', 'approve')->middleware('auth:web,admin');
});

Route::controller(AdminController::class)->group(function () {
    Route::get('/admin', 'index')->middleware('auth:web,admin');
});

Route::controller(AdminUserController::class)->group(function () {
    Route::get('/admin/user', 'index')->middleware('auth:web,admin');
    Route::get('/admin/user/create', 'create')->middleware('auth:web,admin');
    Route::get('/admin/user/{user:nip}/edit', 'edit')->middleware('auth:web,admin');
    Route::post('/admin/user/store', 'store')->middleware('auth:web,admin');
    Route::patch('/admin/user/{user:nip}/update', 'update')->middleware('auth:web,admin');
    Route::delete('/admin/user/{user:nip}', 'delete')->middleware('auth:web,admin');
    Route::get('/admin/user/{user:nip}/role', 'role')->middleware('auth:web,admin');
    Route::get('/admin/user/{user:nip}/role/create', 'role_create')->middleware('auth:web,admin');
    Route::post('/admin/user/{user:nip}/role/{role}', 'role_store')->middleware('auth:web,admin');
    Route::delete('/admin/user/{user:nip}/role/{role}', 'role_delete')->middleware('auth:web,admin');
});

Route::controller(AdminRoleController::class)->group(function () {
    Route::get('/admin/role', 'index')->middleware('auth:web,admin');
    Route::get('/admin/role/create', 'create')->middleware('auth:web,admin');
    Route::post('/admin/role/store', 'store')->middleware('auth:web,admin');
    Route::get('/admin/role/{role}/edit', 'edit')->middleware('auth:web,admin');
    Route::patch('/admin/role/{role}', 'update')->middleware('auth:web,admin');
});

Route::controller(AdminSatkerController::class)->group(function () {
    Route::get('/admin/satker', 'index')->middleware('auth:web,admin');
    Route::get('/admin/satker/create', 'create')->middleware('auth:web,admin');
    Route::post('/admin/satker/store', 'store')->middleware('auth:web,admin');
    Route::get('/admin/satker/{satker:kdsatker}/edit', 'edit')->middleware('auth:web,admin');
    Route::patch('/admin/satker/{satker:kdsatker}', 'update')->middleware('auth:web,admin');
    Route::delete('/admin/satker/{satker:kdsatker}', 'delete')->middleware('auth:web,admin');
});

Route::controller(AdminBulanController::class)->group(function () {
    Route::get('admin/bulan', 'index')->middleware('auth:web,admin');
    Route::get('admin/bulan/create', 'create')->middleware('auth:web,admin');
    Route::post('admin/bulan/store', 'store')->middleware('auth:web,admin');
    Route::get('admin/bulan/{bulan}/edit', 'edit')->middleware('auth:web,admin');
    Route::patch('admin/bulan/{bulan}/update', 'update')->middleware('auth:web,admin');
});

Route::controller(AdminAdminSatkerController::class)->group(function () {
    Route::get('admin/admin-satker', 'index')->middleware('auth:web,admin');
    Route::get('admin/admin-satker/create', 'create')->middleware('auth:web,admin');
    Route::post('admin/admin-satker', 'store')->middleware('auth:web,admin');
    Route::get('admin/admin-satker/{adminSatker}/edit', 'edit')->middleware('auth:web,admin');
    Route::patch('admin/admin-satker/{adminSatker}', 'update')->middleware('auth:web,admin');
    Route::delete('admin/admin-satker/{adminSatker}', 'delete')->middleware('auth:web,admin');
});

Route::controller(HonorariumController::class)->middleware('can:honorarium')->group(function () {
    Route::get('honorarium', 'index')->middleware('auth:web,admin');
    Route::get('honorarium/create', 'create')->middleware('auth:web,admin');
    Route::post('honorarium/import', 'import')->middleware('auth:web,admin');
    Route::get('honorarium/{thn}', 'index')->middleware('auth:web,admin');
    Route::get('honorarium/{file}/detail', 'detail')->middleware('auth:web,admin');
    Route::get('honorarium/{file}/kirim', 'kirim')->middleware('auth:web,admin');
    Route::patch('honorarium/{file}/dokumen', 'dokumen')->middleware('auth:web,admin');
    Route::patch('honorarium/{file}/update', 'update')->middleware('auth:web,admin');
    Route::get('honorarium/{dataHonorarium:file}/edit', 'edit')->middleware('auth:web,admin');
    Route::delete('honorarium/{file}', 'delete')->middleware('auth:web,admin');
    Route::get('honorarium/edit-detail/{dataHonorarium}', 'editDetail')->middleware('auth:web,admin');
    Route::get('honorarium/kirim-detail/{dataHonorarium}', 'kirimDetail')->middleware('auth:web,admin');
    Route::delete('honorarium/hapus-detail/{dataHonorarium}', 'deleteDetail')->middleware('auth:web,admin');
    Route::patch('honorarium/{dataHonorarium}/update-detail', 'updateDetail')->middleware('auth:web,admin');
});

Route::controller(DataPaymentController::class)->group(function () {
    Route::get('data-payment', 'index')->middleware('auth:web,admin');
});

Route::controller(DataPaymentServerController::class)->group(function () {
    Route::get('data-payment/server', 'index')->middleware('auth:web,admin');
    Route::get('data-payment/server/{id}/edit', 'edit')->middleware('auth:web,admin');
    Route::patch('data-payment/server/{id}', 'update')->middleware('auth:web,admin');
    Route::delete('data-payment/server/{id}', 'delete')->middleware('auth:web,admin');
});

Route::controller(DataPaymentHonorariumController::class)->group(function () {
    Route::get('data-payment/honorarium', 'index')->middleware('auth:web,admin');
    Route::get('data-payment/honorarium/{file}/detail', 'detail')->middleware('auth:web,admin');
    Route::patch('data-payment/honorarium/{file}/dokumen', 'dokumen')->middleware('auth:web,admin');
    Route::get('data-payment/honorarium/{file}/upload', 'upload')->middleware('auth:web,admin');
    Route::get('data-payment/honorarium/{dataHonorarium}/upload-detail', 'uploadDetail')->middleware('auth:web,admin');
    Route::delete('data-payment/honorarium/{file}', 'tolak')->middleware('auth:web,admin');
    Route::delete('data-payment/honorarium/{dataHonorarium}/detail', 'tolakDetail')->middleware('auth:web,admin');
});

Route::controller(DataPaymentLainController::class)->group(function () {
    Route::get('/data-payment/lain', 'index')->middleware('auth:web,admin');
    Route::get('/data-payment/lain/create', 'create')->middleware('auth:web,admin');
    Route::post('/data-payment/lain', 'impor')->middleware('auth:web,admin');
    Route::delete('/data-payment/lain/{kdsatker}/{jenis}/{thn}/{bln}', 'delete')->middleware('auth:web,admin');
    Route::post('/data-payment/lain/{kdsatker}/{jenis}/{thn}/{bln}', 'upload')->middleware('auth:web,admin');
    Route::get('/data-payment/lain/{kdsatker}/{jenis}/{thn}/{bln}/detail', 'detail')->middleware('auth:web,admin');
    Route::get('/data-payment/lain/{dataPembayaranLainnya}/edit', 'edit')->middleware('auth:web,admin');
    Route::patch('/data-payment/lain/{dataPembayaranLainnya}', 'update')->middleware('auth:web,admin');
    Route::delete('/data-payment/lain/{dataPembayaranLainnya}', 'deletedetail')->middleware('auth:web,admin');
    Route::post('/data-payment/lain/{dataPembayaranLainnya}', 'uploaddetail')->middleware('auth:web,admin');
});

Route::controller(DataPaymentUploadHonorariumController::class)->group(function () {
    Route::get('/data-payment/upload/honorarium', 'index')->middleware('auth:web,admin');
    Route::get('/data-payment/upload/honorarium/{file}/dokumen', 'dokumen')->middleware('auth:web,admin');
    Route::delete('/data-payment/upload/honorarium/{file}', 'drop')->middleware('auth:web,admin');
    Route::get('/data-payment/upload/honorarium/{file}/detail', 'detail')->middleware('auth:web,admin');
    Route::delete('/data-payment/upload/honorarium/{dataHonorarium}/detail', 'dropDetail')->middleware('auth:web,admin');
});

Route::controller(DataPaymentUploadLainController::class)->group(function () {
    Route::get('/data-payment/upload/lain', 'index')->middleware('auth:web,admin');
    Route::delete('/data-payment/upload/lain/{kdsatker}/{jenis}/{thn}/{bln}', 'drop')->middleware('auth:web,admin');
    Route::get('/data-payment/upload/lain/{kdsatker}/{jenis}/{thn}/{bln}/detail', 'detail')->middleware('auth:web,admin');
    Route::delete('/data-payment/upload/lain/{dataPembayaranLainnya}/detail', 'dropDetail')->middleware('auth:web,admin');
});

Route::controller(SptController::class)->middleware('can:spt')->group(function () {
    Route::get('/spt', 'index')->middleware('auth:web,admin');
    Route::get('/spt/create', 'create')->middleware('auth:web,admin');
    Route::get('/spt/import', 'import')->middleware('auth:web,admin');
    Route::post('/spt/import', 'importAlika')->middleware('auth:web,admin');
    Route::post('/spt/create', 'store')->middleware('auth:web,admin');
    Route::get('/spt/{id}/edit', 'edit')->middleware('auth:web,admin');
    Route::patch('/spt/{id}', 'update')->middleware('auth:web,admin');
    Route::delete('/spt/{id}', 'delete')->middleware('auth:web,admin');
});

Route::controller(SptMonitoringController::class)->middleware('can:spt')->group(function () {
    Route::get('/spt-monitoring', 'index')->middleware('auth:web,admin');
    Route::get('/spt-monitoring/{satker:kdsatker}', 'satker')->middleware('auth:web,admin');
    Route::get('/spt-monitoring/{kdsatker}/{id}/edit', 'edit')->middleware('auth:web,admin');
    Route::patch('/spt-monitoring/{kdsatker}/{id}', 'update')->middleware('auth:web,admin');
    Route::delete('/spt-monitoring/{kdsatker}/{id}', 'delete')->middleware('auth:web,admin');
});

Route::controller(SewaRumahDinasController::class)->middleware('can:rumdin')->group(function () {
    Route::get('/sewa-rumdin', 'index')->middleware('auth:web,admin');
    Route::get('/sewa-rumdin/create', 'create')->middleware('auth:web,admin');
    Route::post('/sewa-rumdin/create', 'store')->middleware('auth:web,admin');
    Route::get('/sewa-rumdin/{sewaRumahDinas}/edit', 'edit')->middleware('auth:web,admin');
    Route::patch('/sewa-rumdin/{sewaRumahDinas}/edit', 'update')->middleware('auth:web,admin');
    Route::delete('/sewa-rumdin/{sewaRumahDinas}/delete', 'delete')->middleware('auth:web,admin');
    Route::get('/sewa-rumdin/{sewaRumahDinas}/kirim', 'kirim')->middleware('auth:web,admin');
    Route::patch('/sewa-rumdin/{sewaRumahDinas}/non-aktif', 'nonAktif')->middleware('auth:web,admin');
    Route::patch('/sewa-rumdin/{sewaRumahDinas}/cancel-pengajuan', 'cancelPengajuan')->middleware('auth:web,admin');
    Route::patch('/sewa-rumdin/{sewaRumahDinas}/cancel-non-aktif', 'cancelNonAktif')->middleware('auth:web,admin');
    Route::patch('/sewa-rumdin/{sewaRumahDinas}/dokumen', 'dokumen')->middleware('auth:web,admin');
});

Route::controller(SewaRumahDinasRejectController::class)->middleware('can:rumdin')->group(function () {
    Route::get('/sewa-rumdin/reject', 'index')->middleware('auth:web,admin');
    Route::get('/sewa-rumdin/reject/{sewaRumahDinas}/edit', 'edit')->middleware('auth:web,admin');
    Route::patch('/sewa-rumdin/reject/{sewaRumahDinas}/edit', 'update')->middleware('auth:web,admin');
    Route::delete('/sewa-rumdin/reject/{sewaRumahDinas}/delete', 'delete')->middleware('auth:web,admin');
    Route::get('/sewa-rumdin/reject/{sewaRumahDinas}/kirim', 'kirim')->middleware('auth:web,admin');
    Route::patch('/sewa-rumdin/reject/{sewaRumahDinas}/dokumen', 'dokumen')->middleware('auth:web,admin');
});

Route::controller(SewaRumahDinasUsulanController::class)->middleware('can:rumdin')->group(function () {
    Route::get('/sewa-rumdin/usulan', 'index')->middleware('auth:web,admin');
    Route::patch('/sewa-rumdin/usulan/{sewaRumahDinas}/tolak', 'tolak')->middleware('auth:web,admin');
    Route::patch('/sewa-rumdin/usulan/{sewaRumahDinas}/approve', 'approve')->middleware('auth:web,admin');
    Route::patch('/sewa-rumdin/usulan/{sewaRumahDinas}/dokumen', 'dokumen')->middleware('auth:web,admin');
});

Route::controller(SewaRumahDinasPenghentianController::class)->middleware('can:rumdin')->group(function () {
    Route::get('/sewa-rumdin/penghentian', 'index')->middleware('auth:web,admin');
    Route::patch('/sewa-rumdin/penghentian/{sewaRumahDinas}/approve', 'approve')->middleware('auth:web,admin');
    Route::patch('/sewa-rumdin/penghentian/{sewaRumahDinas}/dokumen', 'dokumen')->middleware('auth:web,admin');
});

Route::controller(SewaRumahDinasNonAktifController::class)->middleware('can:rumdin')->group(function () {
    Route::get('/sewa-rumdin/non-aktif', 'index')->middleware('auth:web,admin');
});

Route::controller(SewaRumahDinasMonitoringController::class)->middleware('can:rumdin')->group(function () {
    Route::get('/sewa-rumdin/monitoring', 'index')->middleware('auth:web,admin');
    Route::get('/sewa-rumdin/monitoring/{kdsatker}', 'detail')->middleware('auth:web,admin');
    Route::patch('/sewa-rumdin/monitoring/{sewaRumahDinas}/dokumen', 'dokumen')->middleware('auth:web,admin');
});

Route::controller(SewaRumahDinasMonitoringNonAktifController::class)->middleware('can:rumdin')->group(function () {
    Route::get('/sewa-rumdin/monitoring-nonaktif', 'index')->middleware('auth:web,admin');
    Route::get('/sewa-rumdin/monitoring-nonaktif/{kdsatker}', 'detail')->middleware('auth:web,admin');
    Route::patch('/sewa-rumdin/monitoring-nonaktif/{sewaRumahDinas}/dokumen', 'dokumen')->middleware('auth:web,admin');
});

Route::controller(SewaRumahDinasMonitoringWilayahController::class)->middleware('can:rumdin')->group(function () {
    Route::get('/sewa-rumdin/wilayah/monitoring', 'index')->middleware('auth:web,admin');
    Route::get('/sewa-rumdin/wilayah/monitoring/{kdsatker}', 'detail')->middleware('auth:web,admin');
    Route::patch('/sewa-rumdin/wilayah/monitoring/{sewaRumahDinas}/dokumen', 'dokumen')->middleware('auth:web,admin');
});

Route::controller(AdminPenandatanganController::class)->group(function () {
    Route::get('admin/penandatangan', 'index')->middleware('auth:web,admin');
    Route::get('admin/penandatangan/create', 'create')->middleware('auth:web,admin');
    Route::post('admin/penandatangan/create', 'store')->middleware('auth:web,admin');
    Route::get('admin/penandatangan/{id}', 'edit')->middleware('auth:web,admin');
    Route::patch('admin/penandatangan/{id}', 'update')->middleware('auth:web,admin');
});

Route::controller(AdminRefPenandatanganController::class)->group(function () {
    Route::get('admin/ref-penandatangan', 'index')->middleware('auth:web,admin');
    Route::get('admin/ref-penandatangan/{kdsatker}', 'satker')->middleware('auth:web,admin');
    Route::get('admin/ref-penandatangan/{kdsatker}/create', 'create')->middleware('auth:web,admin');
    Route::post('admin/ref-penandatangan/{kdsatker}/create', 'store')->middleware('auth:web,admin');
    Route::get('admin/ref-penandatangan/{kdsatker}/{id}/edit', 'edit')->middleware('auth:web,admin');
    Route::patch('admin/ref-penandatangan/{kdsatker}/{id}/edit', 'update')->middleware('auth:web,admin');
});

Route::controller(Belanja51Controller::class)->group(function () {
    Route::get('/belanja-51-vertikal', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51-v2/document/{path}', 'document')->where('path', '.*')->middleware('auth:web,admin');
});

Route::controller(Belanja51MakanController::class)->group(function () {
    Route::get('/belanja-51-vertikal/uang-makan/permohonan', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51-vertikal/uang-makan/permohonan/{id}', 'detail')->middleware('auth:web,admin');
    Route::delete('/belanja-51-vertikal/uang-makan/permohonan/{id}', 'destroy')->middleware('auth:web,admin');
    Route::patch('/belanja-51-vertikal/uang-makan/permohonan/{id}', 'kirim')->middleware('auth:web,admin');
    Route::patch('/belanja-51-vertikal/uang-makan/arsip/{id}/batal', 'batal')->middleware('auth:web,admin');
    Route::get('/belanja-51-vertikal/uang-makan/arsip', 'arsip')->middleware('auth:web,admin');
    Route::get('/belanja-51-vertikal/uang-makan/arsip/{id}', 'detailArsip')->middleware('auth:web,admin');
    Route::get('/belanja-51-vertikal/uang-makan/arsip/{id}/history', 'history')->middleware('auth:web,admin');
});

Route::controller(Belanja51AbsensiMakanController::class)->group(function () {
    Route::get('/belanja-51-vertikal/uang-makan/absensi', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51-vertikal/uang-makan/absensi/create', 'create')->middleware('auth:web,admin');
    Route::post('/belanja-51-vertikal/uang-makan/absensi/create', 'store')->middleware('auth:web,admin');
    Route::get('/belanja-51-vertikal/uang-makan/absensi/{id}/edit', 'edit')->middleware('auth:web,admin');
    Route::delete('/belanja-51-vertikal/uang-makan/absensi/{AbsensiUangMakan}', 'destroy')->middleware('auth:web,admin');
    Route::patch('/belanja-51-vertikal/uang-makan/absensi/{AbsensiUangMakan}/edit', 'update')->middleware('auth:web,admin');
    Route::get('/belanja-51-vertikal/uang-makan/absensi/{thn}', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51-vertikal/uang-makan/absensi/{thn}/{bln}', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51-vertikal/uang-makan/absensi/{thn}/{bln}/{nip}', 'detail')->middleware('auth:web,admin');
});

Route::controller(Belanja51CreateMakanController::class)->group(function () {
    Route::get('/belanja-51-vertikal/uang-makan/create', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51-vertikal/uang-makan/create/{thn}', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51-vertikal/uang-makan/create/{thn}/{bln}', 'preview')->middleware('auth:web,admin');
    Route::post('/belanja-51-vertikal/uang-makan/create/{thn}/{bln}', 'store')->middleware('auth:web,admin');
});

Route::controller(Belanja51TTEController::class)->group(function () {
    Route::get('/belanja-51-vertikal/tte', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51-vertikal/tte/arsip', 'arsip')->middleware('auth:web,admin');
    Route::get('/belanja-51-vertikal/tte/arsip/{id}', 'detailArsip')->middleware('auth:web,admin');
    Route::get('/belanja-51-vertikal/tte/arsip/{id}/history', 'history')->middleware('auth:web,admin');
    Route::get('/belanja-51-vertikal/tte/{id}', 'detail')->middleware('auth:web,admin');
    Route::patch('/belanja-51-vertikal/tte/{id}/tolak', 'tolak')->middleware('auth:web,admin');
    Route::patch('/belanja-51-vertikal/tte/{id}', 'TTE')->middleware('auth:web,admin');
});

Route::controller(Belanja51LemburController::class)->group(function () {
    Route::get('/belanja-51-vertikal/uang-lembur/permohonan', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51-vertikal/uang-lembur/permohonan/{id}', 'detail')->middleware('auth:web,admin');
    Route::patch('/belanja-51-vertikal/uang-lembur/permohonan/{id}/spkl', 'uploadSPKL')->middleware('auth:web,admin');
    Route::patch('/belanja-51-vertikal/uang-lembur/permohonan/{id}/sptjm', 'uploadSPTJM')->middleware('auth:web,admin');
    Route::patch('/belanja-51-vertikal/uang-lembur/permohonan/{id}/lpt', 'uploadLPT')->middleware('auth:web,admin');
    Route::delete('/belanja-51-vertikal/uang-lembur/permohonan/{id}/spkl', 'deleteSPKL')->middleware('auth:web,admin');
    Route::delete('/belanja-51-vertikal/uang-lembur/permohonan/{id}/sptjm', 'deleteSPTJM')->middleware('auth:web,admin');
    Route::delete('/belanja-51-vertikal/uang-lembur/permohonan/{id}/lpt', 'deleteLPT')->middleware('auth:web,admin');
    Route::delete('/belanja-51-vertikal/uang-lembur/permohonan/{id}', 'destroy')->middleware('auth:web,admin');
    Route::patch('/belanja-51-vertikal/uang-lembur/permohonan/{id}', 'kirim')->middleware('auth:web,admin');
    Route::patch('/belanja-51-vertikal/uang-lembur/arsip/{id}/batal', 'batal')->middleware('auth:web,admin');
    Route::get('/belanja-51-vertikal/uang-lembur/arsip', 'arsip')->middleware('auth:web,admin');
    Route::get('/belanja-51-vertikal/uang-lembur/arsip/{id}', 'detailArsip')->middleware('auth:web,admin');
    Route::get('/belanja-51-vertikal/uang-lembur/arsip/{id}/history', 'history')->middleware('auth:web,admin');
});

Route::controller(Belanja51AbsensiLemburController::class)->group(function () {
    Route::get('/belanja-51-vertikal/uang-lembur/absensi', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51-vertikal/uang-lembur/absensi/create', 'create')->middleware('auth:web,admin');
    Route::post('/belanja-51-vertikal/uang-lembur/absensi/create', 'store')->middleware('auth:web,admin');
    Route::get('/belanja-51-vertikal/uang-lembur/absensi/template', 'template')->middleware('auth:web,admin');
    Route::get('/belanja-51-vertikal/uang-lembur/absensi/{id}/edit', 'edit')->middleware('auth:web,admin');
    Route::delete('/belanja-51-vertikal/uang-lembur/absensi/{AbsensiUangLembur}', 'destroy')->middleware('auth:web,admin');
    Route::patch('/belanja-51-vertikal/uang-lembur/absensi/{AbsensiUangLembur}/edit', 'update')->middleware('auth:web,admin');
    Route::get('/belanja-51-vertikal/uang-lembur/absensi/{thn}', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51-vertikal/uang-lembur/absensi/{thn}/{bln}', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51-vertikal/uang-lembur/absensi/{thn}/{bln}/{nip}', 'detail')->middleware('auth:web,admin');
});

Route::controller(Belanja51CreateLemburController::class)->group(function () {
    Route::get('/belanja-51-vertikal/uang-lembur/create', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51-vertikal/uang-lembur/create/{thn}', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51-vertikal/uang-lembur/create/{thn}/{bln}', 'preview')->middleware('auth:web,admin');
    Route::post('/belanja-51-vertikal/uang-lembur/create/{thn}/{bln}', 'store')->middleware('auth:web,admin');
});

Route::controller(PusatBelanja51Controller::class)->group(function () {
    Route::get('/belanja-51-pusat', 'index')->middleware('auth:web,admin');
});

Route::controller(PusatBelanja51MakanController::class)->group(function () {
    Route::get('/belanja-51-pusat/uang-makan/permohonan', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51-pusat/uang-makan/permohonan/{id}', 'detail')->middleware('auth:web,admin');
    Route::delete('/belanja-51-pusat/uang-makan/permohonan/{id}', 'destroy')->middleware('auth:web,admin');
    Route::patch('/belanja-51-pusat/uang-makan/permohonan/{id}', 'kirim')->middleware('auth:web,admin');
    Route::patch('/belanja-51-pusat/uang-makan/arsip/{id}/batal', 'batal')->middleware('auth:web,admin');
    Route::get('/belanja-51-pusat/uang-makan/arsip', 'arsip')->middleware('auth:web,admin');
    Route::get('/belanja-51-pusat/uang-makan/arsip/{id}', 'detailArsip')->middleware('auth:web,admin');
    Route::get('/belanja-51-pusat/uang-makan/arsip/{id}/history', 'history')->middleware('auth:web,admin');
});

Route::controller(PusatBelanja51AbsensiMakanController::class)->group(function () {
    Route::get('/belanja-51-pusat/uang-makan/absensi', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51-pusat/uang-makan/absensi/create', 'create')->middleware('auth:web,admin');
    Route::post('/belanja-51-pusat/uang-makan/absensi/create', 'store')->middleware('auth:web,admin');
    Route::get('/belanja-51-pusat/uang-makan/absensi/{id}/edit', 'edit')->middleware('auth:web,admin');
    Route::delete('/belanja-51-pusat/uang-makan/absensi/{AbsensiUangMakan}', 'destroy')->middleware('auth:web,admin');
    Route::patch('/belanja-51-pusat/uang-makan/absensi/{AbsensiUangMakan}/edit', 'update')->middleware('auth:web,admin');
    Route::get('/belanja-51-pusat/uang-makan/absensi/{thn}', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51-pusat/uang-makan/absensi/{thn}/{bln}', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51-pusat/uang-makan/absensi/{thn}/{bln}/{nip}', 'detail')->middleware('auth:web,admin');
});

Route::controller(PusatBelanja51CreateMakanController::class)->group(function () {
    Route::get('/belanja-51-pusat/uang-makan/create', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51-pusat/uang-makan/create/{thn}', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51-pusat/uang-makan/create/{thn}/{bln}', 'preview')->middleware('auth:web,admin');
    Route::post('/belanja-51-pusat/uang-makan/create/{thn}/{bln}', 'store')->middleware('auth:web,admin');
});

Route::controller(PusatBelanja51TTEController::class)->group(function () {
    Route::get('/belanja-51-pusat/tte', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51-pusat/tte/arsip', 'arsip')->middleware('auth:web,admin');
    Route::get('/belanja-51-pusat/tte/arsip/{id}', 'detailArsip')->middleware('auth:web,admin');
    Route::get('/belanja-51-pusat/tte/arsip/{id}/history', 'history')->middleware('auth:web,admin');
    Route::get('/belanja-51-pusat/tte/{id}', 'detail')->middleware('auth:web,admin');
    Route::patch('/belanja-51-pusat/tte/{id}/tolak', 'tolak')->middleware('auth:web,admin');
    Route::patch('/belanja-51-pusat/tte/{id}', 'TTE')->middleware('auth:web,admin');
});

Route::controller(PusatBelanja51LemburController::class)->group(function () {
    Route::get('/belanja-51-pusat/uang-lembur/permohonan', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51-pusat/uang-lembur/permohonan/{id}', 'detail')->middleware('auth:web,admin');
    Route::patch('/belanja-51-pusat/uang-lembur/permohonan/{id}/spkl', 'uploadSPKL')->middleware('auth:web,admin');
    Route::patch('/belanja-51-pusat/uang-lembur/permohonan/{id}/sptjm', 'uploadSPTJM')->middleware('auth:web,admin');
    Route::patch('/belanja-51-pusat/uang-lembur/permohonan/{id}/lpt', 'uploadLPT')->middleware('auth:web,admin');
    Route::delete('/belanja-51-pusat/uang-lembur/permohonan/{id}/spkl', 'deleteSPKL')->middleware('auth:web,admin');
    Route::delete('/belanja-51-pusat/uang-lembur/permohonan/{id}/sptjm', 'deleteSPTJM')->middleware('auth:web,admin');
    Route::delete('/belanja-51-pusat/uang-lembur/permohonan/{id}/lpt', 'deleteLPT')->middleware('auth:web,admin');
    Route::delete('/belanja-51-pusat/uang-lembur/permohonan/{id}', 'destroy')->middleware('auth:web,admin');
    Route::patch('/belanja-51-pusat/uang-lembur/permohonan/{id}', 'kirim')->middleware('auth:web,admin');
    Route::patch('/belanja-51-pusat/uang-lembur/arsip/{id}/batal', 'batal')->middleware('auth:web,admin');
    Route::get('/belanja-51-pusat/uang-lembur/arsip', 'arsip')->middleware('auth:web,admin');
    Route::get('/belanja-51-pusat/uang-lembur/arsip/{id}', 'detailArsip')->middleware('auth:web,admin');
    Route::get('/belanja-51-pusat/uang-lembur/arsip/{id}/history', 'history')->middleware('auth:web,admin');
});

Route::controller(PusatBelanja51AbsensiLemburController::class)->group(function () {
    Route::get('/belanja-51-pusat/uang-lembur/absensi', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51-pusat/uang-lembur/absensi/create', 'create')->middleware('auth:web,admin');
    Route::post('/belanja-51-pusat/uang-lembur/absensi/create', 'store')->middleware('auth:web,admin');
    Route::get('/belanja-51-pusat/uang-lembur/absensi/template', 'template')->middleware('auth:web,admin');
    Route::get('/belanja-51-pusat/uang-lembur/absensi/{id}/edit', 'edit')->middleware('auth:web,admin');
    Route::delete('/belanja-51-pusat/uang-lembur/absensi/{AbsensiUangLembur}', 'destroy')->middleware('auth:web,admin');
    Route::patch('/belanja-51-pusat/uang-lembur/absensi/{AbsensiUangLembur}/edit', 'update')->middleware('auth:web,admin');
    Route::get('/belanja-51-pusat/uang-lembur/absensi/{thn}', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51-pusat/uang-lembur/absensi/{thn}/{bln}', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51-pusat/uang-lembur/absensi/{thn}/{bln}/{nip}', 'detail')->middleware('auth:web,admin');
});

Route::controller(PusatBelanja51CreateLemburController::class)->group(function () {
    Route::get('/belanja-51-pusat/uang-lembur/create', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51-pusat/uang-lembur/create/{thn}', 'index')->middleware('auth:web,admin');
    Route::get('/belanja-51-pusat/uang-lembur/create/{thn}/{bln}', 'preview')->middleware('auth:web,admin');
    Route::post('/belanja-51-pusat/uang-lembur/create/{thn}/{bln}', 'store')->middleware('auth:web,admin');
});

Route::controller(MonitoringBelanja51Controller::class)->group(function (){
    Route::get('/belanja-51-monitoring', 'index')->middleware('auth:web');
});

Route::controller(MonitoringBelanja51VertikalController::class)->group(function (){
    Route::get('/belanja-51-monitoring/vertikal/uang-makan', 'uangMakan')->middleware('auth:web');
    Route::get('/belanja-51-monitoring/vertikal/uang-makan/detail/{id}', 'uangMakanDetail')->middleware('auth:web');
    Route::get('/belanja-51-monitoring/vertikal/uang-makan/detail/{id}/rekap', 'uangMakanRekap')->middleware('auth:web');
    Route::PATCH('/belanja-51-monitoring/vertikal/uang-makan/detail/{id}/approve', 'uangMakanApprove')->middleware('auth:web');
    Route::PATCH('/belanja-51-monitoring/vertikal/uang-makan/detail/{id}/tolak', 'uangMakanTolak')->middleware('auth:web');
    Route::get('/belanja-51-monitoring/vertikal/uang-makan/monitoring', 'uangMakanMonitoring')->middleware('auth:web');
    Route::get('/belanja-51-monitoring/vertikal/uang-makan/monitoring/detail/{id}', 'uangMakanMonitoringDetail')->middleware('auth:web');
    Route::get('/belanja-51-monitoring/vertikal/uang-makan/monitoring/{thn}/', 'uangMakanMonitoring')->middleware('auth:web');
    Route::get('/belanja-51-monitoring/vertikal/uang-makan/monitoring/{thn}/{bln}', 'uangMakanMonitoring')->middleware('auth:web');
    Route::get('/belanja-51-monitoring/vertikal/uang-makan/monitoring/{thn}/{bln}/{kdsatker}', 'uangMakanMonitoringRekap')->middleware('auth:web');

    Route::get('/belanja-51-monitoring/vertikal/uang-lembur', 'uangLembur')->middleware('auth:web');
    Route::get('/belanja-51-monitoring/vertikal/uang-lembur/detail/{id}', 'uangLemburDetail')->middleware('auth:web');
    Route::get('/belanja-51-monitoring/vertikal/uang-lembur/detail/{id}/rekap', 'uangLemburRekap')->middleware('auth:web');
    Route::PATCH('/belanja-51-monitoring/vertikal/uang-lembur/detail/{id}/approve', 'uangLemburApprove')->middleware('auth:web');
    Route::PATCH('/belanja-51-monitoring/vertikal/uang-lembur/detail/{id}/tolak', 'uangLemburTolak')->middleware('auth:web');
    Route::get('/belanja-51-monitoring/vertikal/uang-lembur/monitoring', 'uangLemburMonitoring')->middleware('auth:web');
    Route::get('/belanja-51-monitoring/vertikal/uang-lembur/monitoring/detail/{id}', 'uangLemburMonitoringDetail')->middleware('auth:web');
    Route::get('/belanja-51-monitoring/vertikal/uang-lembur/monitoring/{thn}/', 'uangLemburMonitoring')->middleware('auth:web');
    Route::get('/belanja-51-monitoring/vertikal/uang-lembur/monitoring/{thn}/{bln}', 'uangLemburMonitoring')->middleware('auth:web');
    Route::get('/belanja-51-monitoring/vertikal/uang-lembur/monitoring/{thn}/{bln}/{kdsatker}', 'uangLemburMonitoringRekap')->middleware('auth:web');
});

Route::controller(MonitoringBelanja51PusatController::class)->group(function (){
    Route::get('/belanja-51-monitoring/pusat/uang-makan', 'uangMakan')->middleware('auth:web');
    Route::get('/belanja-51-monitoring/pusat/uang-makan/detail/{id}', 'uangMakanDetail')->middleware('auth:web');
    Route::get('/belanja-51-monitoring/pusat/uang-makan/detail/{id}/rekap', 'uangMakanRekap')->middleware('auth:web');
    Route::PATCH('/belanja-51-monitoring/pusat/uang-makan/detail/{id}/approve', 'uangMakanApprove')->middleware('auth:web');
    Route::PATCH('/belanja-51-monitoring/pusat/uang-makan/detail/{id}/tolak', 'uangMakanTolak')->middleware('auth:web');
    Route::get('/belanja-51-monitoring/pusat/uang-makan/monitoring', 'uangMakanMonitoring')->middleware('auth:web');
    Route::get('/belanja-51-monitoring/pusat/uang-makan/monitoring/detail/{id}', 'uangMakanMonitoringDetail')->middleware('auth:web');
    Route::get('/belanja-51-monitoring/pusat/uang-makan/monitoring/{thn}/', 'uangMakanMonitoring')->middleware('auth:web');
    Route::get('/belanja-51-monitoring/pusat/uang-makan/monitoring/{thn}/{bln}', 'uangMakanMonitoring')->middleware('auth:web');
    Route::get('/belanja-51-monitoring/pusat/uang-makan/monitoring/{thn}/{bln}/{kdunit}', 'uangMakanMonitoringRekap')->middleware('auth:web');

    Route::get('/belanja-51-monitoring/pusat/uang-lembur', 'uangLembur')->middleware('auth:web');
    Route::get('/belanja-51-monitoring/pusat/uang-lembur/detail/{id}', 'uangLemburDetail')->middleware('auth:web');
    Route::get('/belanja-51-monitoring/pusat/uang-lembur/detail/{id}/rekap', 'uangLemburRekap')->middleware('auth:web');
    Route::PATCH('/belanja-51-monitoring/pusat/uang-lembur/detail/{id}/approve', 'uangLemburApprove')->middleware('auth:web');
    Route::PATCH('/belanja-51-monitoring/pusat/uang-lembur/detail/{id}/tolak', 'uangLemburTolak')->middleware('auth:web');
    Route::get('/belanja-51-monitoring/pusat/uang-lembur/monitoring', 'uangLemburMonitoring')->middleware('auth:web');
    Route::get('/belanja-51-monitoring/pusat/uang-lembur/monitoring/detail/{id}', 'uangLemburMonitoringDetail')->middleware('auth:web');
    Route::get('/belanja-51-monitoring/pusat/uang-lembur/monitoring/{thn}/', 'uangLemburMonitoring')->middleware('auth:web');
    Route::get('/belanja-51-monitoring/pusat/uang-lembur/monitoring/{thn}/{bln}', 'uangLemburMonitoring')->middleware('auth:web');
    Route::get('/belanja-51-monitoring/pusat/uang-lembur/monitoring/{thn}/{bln}/{kdunit}', 'uangLemburMonitoringRekap')->middleware('auth:web');
});