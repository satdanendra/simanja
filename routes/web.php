<?php

use App\Http\Controllers\AlokasiRincianKegiatanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterPegawaiController;
use App\Http\Controllers\MasterDirektoratController;
use App\Http\Controllers\MasterRincianKegiatanController;
use App\Http\Controllers\IkuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimController;
use App\Http\Controllers\RkTimController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanHarianController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::post('/users/{id}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
    Route::post('/users/{id}/activate', [UserController::class, 'activate'])->name('users.activate');
    Route::get('/tim', [TimController::class, 'index'])->name('tim');
    Route::post('/tims', [TimController::class, 'store'])->name('tims.store');
    Route::get('/tims/{tim}/edit', [TimController::class, 'edit'])->name('tims.edit');
    Route::put('/tims/{tim}', [TimController::class, 'update'])->name('tims.update');
    Route::delete('/tims/{tim}', [TimController::class, 'destroy'])->name('tims.destroy');
    Route::get('/tim/{tim}/anggota', [TimController::class, 'anggota'])->name('detailtim');
    Route::post('/tim/{tim}/anggota', [TimController::class, 'simpanAnggota'])->name('tim.simpan_anggota');
    Route::delete('/tim/{tim}/anggota/{user}', [TimController::class, 'hapusAnggota'])->name('tim.anggota.destroy');
    Route::post('/tim/{tim}/rktim', [TimController::class, 'simpanRkTim'])->name('tim.simpan_rktim');
    Route::put('/tim/{tim}/rktim/{rktim}', [TimController::class, 'updateRkTim'])->name('tim.rktim.update');
    Route::delete('/tim/{tim}/rktim/{rktim}', [TimController::class, 'hapusRkTim'])->name('tim.rktim.destroy');
    Route::get('/rktim/{rktim}', [RkTimController::class, 'detailRkTim'])->name('detailrktim');
    Route::post('/rktim/{rktim}/proyek', [RkTimController::class, 'simpanProyek'])->name('rktim.simpan_proyek');
    Route::put('/rktim/{rktim}/proyek/{proyek}', [RkTimController::class, 'updateProyek'])->name('rktim.proyek.update');
    Route::delete('/rktim/{rktim}/proyek/{proyek}', [RkTimController::class, 'hapusProyek'])->name('rktim.proyek.destroy');
    Route::post('/tim/{tim}/proyek', [TimController::class, 'simpanProyek'])->name('tim.simpan_proyek');
    Route::put('/tim/{tim}/proyek/{proyek}', [TimController::class, 'updateProyek'])->name('tim.proyek.update');
    Route::delete('/tim/{tim}/proyek/{proyek}', [TimController::class, 'hapusProyek'])->name('tim.proyek.destroy');
    Route::get('/proyek/{proyek}', [ProyekController::class, 'detailProyek'])->name('detailproyek');
    Route::put('/proyek/{proyek}', [ProyekController::class, 'update'])->name('proyek.update');
    Route::post('/proyek/{proyek}/kegiatan', [ProyekController::class, 'simpanKegiatan'])->name('proyek.simpan_kegiatan');
    Route::put('/proyek/{proyek}/kegiatan/{kegiatan}', [ProyekController::class, 'updateKegiatan'])->name('proyek.kegiatan.update');
    Route::delete('/proyek/{proyek}/kegiatan/{kegiatan}', [ProyekController::class, 'destroyKegiatan'])->name('proyek.kegiatan.destroy');
    Route::get('/kegiatan/{kegiatan}', [KegiatanController::class, 'detailKegiatan'])->name('detailkegiatan');
    Route::put('/kegiatan/{kegiatan}', [KegiatanController::class, 'update'])->name('kegiatan.update');
    Route::post('/kegiatan/{kegiatan}/rincian', [KegiatanController::class, 'simpanRincian'])->name('kegiatan.simpan_rincian');
    Route::put('/kegiatan/{kegiatan}/rincian/{rincian}', [KegiatanController::class, 'updateRincian'])->name('kegiatan.rincian.update');
    Route::delete('/kegiatan/{kegiatan}/rincian/{rincian}', [KegiatanController::class, 'destroyRincian'])->name('kegiatan.rincian.destroy');
    Route::get('/rincian-kegiatan/{rincianKegiatan}', [AlokasiRincianKegiatanController::class, 'detailRincianKegiatan'])->name('detailrinciankegiatan');
    Route::post('/rincian-kegiatan/{rincianKegiatan}/alokasi', [AlokasiRincianKegiatanController::class, 'storeAlokasi'])->name('alokasi.store');
    Route::get('/rincian-kegiatan/{rincianKegiatan}/bukti-dukung', [AlokasiRincianKegiatanController::class, 'buktiDukungIndex'])->name('detailbuktidukung');
    Route::get('/rincian-kegiatan/{rincianKegiatan}/bukti-dukung/create', [AlokasiRincianKegiatanController::class, 'buktiDukungCreate'])->name('bukti-dukung-rincian.create');
    Route::post('/rincian-kegiatan/{rincianKegiatan}/bukti-dukung', [AlokasiRincianKegiatanController::class, 'buktiDukungStore'])->name('bukti-dukung.store');
    Route::get('/bukti-dukung/{buktiDukung}/view', [AlokasiRincianKegiatanController::class, 'buktiDukungView'])->name('bukti-dukung.view');
    Route::get('/bukti-dukung/{buktiDukung}/download', [AlokasiRincianKegiatanController::class, 'buktiDukungDownload'])->name('bukti-dukung.download');
    Route::delete('/bukti-dukung/{buktiDukung}', [AlokasiRincianKegiatanController::class, 'buktiDukungDestroy'])->name('bukti-dukung.destroy');
    Route::put('/alokasi/{alokasi}', [AlokasiRincianKegiatanController::class, 'updateAlokasi'])->name('alokasi.update');
    Route::delete('/alokasi/{alokasi}', [AlokasiRincianKegiatanController::class, 'destroyAlokasi'])->name('alokasi.destroy');
    Route::get('/master-pegawai', [MasterPegawaiController::class, 'index'])->name('master-pegawai');
    Route::get('/master-pegawai/{masterPegawai}/edit', [MasterPegawaiController::class, 'edit'])->name('master-pegawai.edit');
    Route::put('/master-pegawai/{masterPegawai}', [MasterPegawaiController::class, 'update'])->name('master-pegawai.update');
    Route::post('/master-pegawai', [MasterPegawaiController::class, 'store'])->name('master-pegawai.store');
    Route::delete('/master-pegawai', [MasterPegawaiController::class, 'hapusMasterPegawai'])->name('master-pegawai.destroy');
    Route::post('/master-pegawai/import', [MasterPegawaiController::class, 'import'])->name('master-pegawai.import');
    Route::get('/master-pegawai/download-template', [MasterPegawaiController::class, 'downloadTemplate'])->name('master-pegawai.template.download');
    Route::post('/master-pegawai/{id}/deactivate', [MasterPegawaiController::class, 'deactivate'])->name('master-pegawai.deactivate');
    Route::post('/master-pegawai/{id}/activate', [MasterPegawaiController::class, 'activate'])->name('master-pegawai.activate');
    Route::get('/master-direktorat', [MasterDirektoratController::class, 'index'])->name('master-direktorat');
    Route::post('/master-direktorat', [MasterDirektoratController::class, 'store'])->name('master-direktorat.store');
    Route::get('/master-direktorat/{masterDirektorat}/edit', [MasterDirektoratController::class, 'edit'])->name('master-direktorat.edit');
    Route::put('/master-direktorat/{masterDirektorat}', [MasterDirektoratController::class, 'update'])->name('master-direktorat.update');
    Route::delete('/master-direktorat/{masterDirektorat}', [MasterDirektoratController::class, 'destroy'])->name('master-direktorat.destroy');
    Route::post('/master-direktorat/import', [MasterDirektoratController::class, 'import'])->name('master-direktorat.import');
    Route::get('/master-direktorat/download-template', [MasterDirektoratController::class, 'downloadTemplate'])->name('master-direktorat.template.download');
    Route::delete('/master-direktorat/batch-delete', [MasterDirektoratController::class, 'batchDelete'])->name('master-direktorat.batch-delete');
    Route::get('/iku', [IkuController::class, 'index'])->name('iku');
    Route::post('/iku', [IkuController::class, 'store'])->name('iku.store');
    Route::get('/iku/{iku}/edit', [IkuController::class, 'edit'])->name('iku.edit');
    Route::put('/iku/{iku}', [IkuController::class, 'update'])->name('iku.update');
    Route::delete('/iku/{iku}', [IkuController::class, 'destroy'])->name('iku.destroy');
    Route::post('/iku/import', [IkuController::class, 'import'])->name('iku.import');
    Route::get('/iku/download-template', [IkuController::class, 'downloadTemplate'])->name('iku.template.download');
    Route::delete('/iku/batch-delete', [IkuController::class, 'batchDelete'])->name('iku.batch-delete');
    Route::get('/master-rincian-kegiatan', [MasterRincianKegiatanController::class, 'index'])->name('master-rincian-kegiatan');
    Route::post('/master-rincian-kegiatan/import', [MasterRincianKegiatanController::class, 'import'])->name('master-rincian-kegiatan.import');
    Route::get('/master-rincian-kegiatan/download-template', [MasterRincianKegiatanController::class, 'downloadTemplate'])->name('master-rincian-kegiatan.template.download');
    Route::delete('/master-rincian-kegiatan/{masterRincianKegiatan}', [MasterRincianKegiatanController::class, 'destroy'])->name('master-rincian-kegiatan.destroy');
    Route::delete('/master-rincian-kegiatan/batch-delete', [MasterRincianKegiatanController::class, 'batchDelete'])->name('master-rincian-kegiatan.batch-delete');
    Route::get('/alokasi/{alokasi}/download', [AlokasiRincianKegiatanController::class, 'downloadBuktiDukung'])->name('alokasi.download');
    // Laporan Harian Routes
    Route::get('/laporan-harian', [LaporanHarianController::class, 'index'])
        ->name('laporanharian');
    
    Route::get('/rincian-kegiatan/{rincianKegiatan}/laporan-harian/create', [LaporanHarianController::class, 'create'])
        ->name('laporan-harian.create');
    
    Route::post('/rincian-kegiatan/{rincianKegiatan}/laporan-harian', [LaporanHarianController::class, 'store'])
        ->name('laporan-harian.store');
    
    Route::get('/laporan-harian/{laporan}', [LaporanHarianController::class, 'show'])
        ->name('laporan-harian.show');
    
    Route::get('/laporan-harian/{laporan}/download', [LaporanHarianController::class, 'download'])
        ->name('laporan-harian.download');
    
    Route::delete('/laporan-harian/{laporan}', [LaporanHarianController::class, 'destroy'])
        ->name('laporan-harian.destroy');
});

require __DIR__ . '/auth.php';
