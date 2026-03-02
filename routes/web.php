<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\DashboardController;

// Dashboard Publik (Live Stream)
Route::get('/', [DashboardController::class, 'public_index'])->name('public.dashboard');
Route::get('/api/live-attendance', [DashboardController::class, 'api_live_attendance']);

// Autentikasi Admin
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Panel Admin (Dilindungi Auth)
Route::middleware('auth')->group(function () {
    Route::get('/admin', [DashboardController::class, 'admin_index'])->name('admin.dashboard');
    Route::get('/api/history-attendance', [DashboardController::class, 'api_history_attendance']);
    
    // Scanner
    Route::get('/admin/scanner', [ScannerController::class, 'index'])->name('admin.scanner');
    Route::post('/api/scan-qr', [ScannerController::class, 'process_scan']);
    
    // Manual Update Kehadiran
    Route::post('/api/update-status', [DashboardController::class, 'api_update_status']);
    Route::delete('/api/attendance-logs', [DashboardController::class, 'api_delete_attendance_logs']);

    // Kelola Anggota (CRUD)
    Route::get('/api/anggota', [DashboardController::class, 'api_get_anggota']);
    Route::post('/api/anggota', [DashboardController::class, 'api_store_anggota']);
    Route::post('/api/anggota/{id}/foto', [DashboardController::class, 'api_update_foto_anggota']);
    Route::delete('/api/anggota/{id}/foto', [DashboardController::class, 'api_delete_foto_anggota']);
    Route::delete('/api/anggota/{id}', [DashboardController::class, 'api_delete_anggota']);
});
