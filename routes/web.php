<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengawasController;
use App\Http\Controllers\AkunController;

// Dashboard Publik (Live Stream)
Route::get('/', [DashboardController::class, 'public_index'])->name('public.dashboard');
Route::get('/api/live-attendance', [DashboardController::class, 'api_live_attendance'])->middleware('throttle:30,1');

// Autentikasi
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Panel Admin (Hanya role admin)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'admin_index'])->name('admin.dashboard');
    Route::get('/api/history-attendance', [DashboardController::class, 'api_history_attendance']);

    // Scanner
    Route::get('/admin/scanner', [ScannerController::class, 'index'])->name('admin.scanner');
    Route::post('/api/scan-qr', [ScannerController::class, 'process_scan']);

    // Manual Update Kehadiran
    Route::post('/api/update-status', [DashboardController::class, 'api_update_status']);
    Route::delete('/api/attendance-logs', [DashboardController::class, 'api_delete_attendance_logs']);

    // Kelola Anggota (CRUD) — hanya admin
    Route::get('/api/anggota', [DashboardController::class, 'api_get_anggota']);
    Route::post('/api/anggota', [DashboardController::class, 'api_store_anggota']);
    Route::post('/api/anggota/{id}/foto', [DashboardController::class, 'api_update_foto_anggota']);
    Route::delete('/api/anggota/{id}/foto', [DashboardController::class, 'api_delete_foto_anggota']);
    Route::delete('/api/anggota/{id}', [DashboardController::class, 'api_delete_anggota']);

    // Pengaturan Sistem — hanya admin
    Route::get('/api/settings', [DashboardController::class, 'api_get_setting']);
    Route::post('/api/settings', [DashboardController::class, 'api_save_setting']);

    // Export Excel — hanya admin
    Route::get('/admin/export-excel', [DashboardController::class, 'exportExcel'])->name('admin.export-excel');

    // Manajemen Akun — hanya admin
    Route::get('/admin/akun', [AkunController::class, 'index'])->name('admin.akun');
    Route::post('/admin/akun', [AkunController::class, 'store'])->name('admin.akun.store');
    Route::delete('/admin/akun/{id}', [AkunController::class, 'destroy'])->name('admin.akun.destroy');
});

// Panel Pengawas (Hanya role pengawas)
Route::middleware(['auth', 'pengawas'])->prefix('pengawas')->group(function () {
    Route::get('/', [PengawasController::class, 'index'])->name('pengawas.dashboard');
    Route::get('/scanner', [PengawasController::class, 'scanner'])->name('pengawas.scanner');

    // API yang boleh diakses pengawas
    Route::get('/api/history-attendance', [PengawasController::class, 'api_history_attendance']);
    Route::post('/api/update-status', [PengawasController::class, 'api_update_status']);
    Route::delete('/api/attendance-logs', [PengawasController::class, 'api_delete_attendance_logs']);
    Route::post('/api/scan-qr', [PengawasController::class, 'api_scan_qr']);
});
