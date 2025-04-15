<?php

use App\Http\Controllers\MasterPegawaiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
    Route::get('/tim/{tim}/anggota', [TimController::class, 'anggota'])->name('detailtim');
    Route::post('/tim/{tim}/anggota', [TimController::class, 'simpanAnggota'])->name('tim.simpan_anggota');
    Route::delete('/tim/{tim}/anggota/{user}', [TimController::class, 'hapusAnggota'])->name('tim.anggota.destroy');
    Route::get('/master-pegawai', [MasterPegawaiController::class, 'index'])->name('master-pegawai');
    Route::get('/master-pegawai/{masterPegawai}/edit', [MasterPegawaiController::class, 'edit'])->name('master-pegawai.edit');
    Route::put('/master-pegawai/{masterPegawai}', [MasterPegawaiController::class, 'update'])->name('master-pegawai.update');
    Route::post('/master-pegawai', [MasterPegawaiController::class, 'store'])->name('master-pegawai.store');
    Route::delete('/master-pegawai', [MasterPegawaiController::class, 'hapusMasterPegawai'])->name('master-pegawai.destroy');
    Route::post('/master-pegawai/import', [MasterPegawaiController::class, 'import'])->name('master-pegawai.import');
    Route::get('/master-pegawai/download-template', [MasterPegawaiController::class, 'downloadTemplate'])->name('master-pegawai.template.download');
    Route::post('/master-pegawai/{id}/deactivate', [MasterPegawaiController::class, 'deactivate'])->name('master-pegawai.deactivate');
    Route::post('/master-pegawai/{id}/activate', [MasterPegawaiController::class, 'activate'])->name('master-pegawai.activate');
});

require __DIR__ . '/auth.php';
