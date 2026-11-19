<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\CatatanController;

// Jika akses root '/', langsung lempar ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// HALAMAN LOGIN (Hanya bisa diakses kalau belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.process');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/catatan', [CatatanController::class, 'index'])->name('catatan.index');
    Route::post('/catatan', [CatatanController::class, 'store'])->name('catatan.store');
    Route::delete('/catatan/{id}', [CatatanController::class, 'destroy'])->name('catatan.destroy');
});
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Rute Ubah Password
    Route::get('/ganti-password', [HomeController::class, 'editPassword'])->name('password.edit');
    Route::post('/ganti-password', [HomeController::class, 'updatePassword'])->name('password.update');

    Route::get('/absensi/rekap', [AbsensiController::class, 'rekap'])->name('absensi.rekap');
    Route::post('/absensi/update-cepat', [AbsensiController::class, 'updateClassCepat'])->name('absensi.updateCepat');

    // Rute resource untuk fitur lainnya
    Route::resource('mapel', MapelController::class);
    Route::resource('jadwal', JadwalController::class);
    Route::resource('tugas', TugasController::class);
    Route::resource('absensi', AbsensiController::class);
    Route::resource('guru', GuruController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('prestasi', PrestasiController::class);

    // LOGOUT
    Route::any('/logout', [LoginController::class, 'logout'])->name('logout');
});
