<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\LogAbsensi;
use Carbon\Carbon;

class ScannerController extends Controller
{
    public function index()
    {
        return view('admin.scanner');
    }

    public function process_scan(Request $request)
    {
        $request->validate([
            'qr_code_token' => 'required|string'
        ]);

        $token = $request->qr_code_token;
        $anggota = Anggota::where('qr_code_token', $token)->first();

        if (!$anggota) {
            return response()->json(['status' => 'error', 'message' => 'QR Code tidak terdaftar.'], 404);
        }

        if (!$anggota->status_aktif) {
            return response()->json(['status' => 'error', 'message' => 'Anggota tidak aktif.'], 403);
        }

        $today = Carbon::today()->toDateString();
        $now = Carbon::now();

        $logsToday = LogAbsensi::where('anggota_id', $anggota->id)
                               ->where('tanggal', $today)
                               ->orderBy('waktu_scan', 'asc')
                               ->get();

        $count = $logsToday->count();

        if ($count >= 2) {
            return response()->json([
                'status' => 'warning',
                'message' => "Absensi Lengkap! {$anggota->nama} sudah melakukan pindaian MASUK dan PULANG hari ini. Silakan kembali lagi besok."
            ], 429);
        }

        if ($count == 1) {
            $tipe = 'OUT';
        } else {
            $tipe = 'IN';
        }

        LogAbsensi::create([
            'anggota_id' => $anggota->id,
            'waktu_scan' => $now,
            'tipe_absen' => $tipe,
            'tanggal' => $today
        ]);

        $statusText = $tipe == 'IN' ? 'MASUK' : 'PULANG';

        $allLogsToday = LogAbsensi::where('anggota_id', $anggota->id)
                                ->where('tanggal', $today)
                                ->get();
        $hasIn = $allLogsToday->where('tipe_absen', 'IN')->isNotEmpty();
        $hasOut = $allLogsToday->where('tipe_absen', 'OUT')->isNotEmpty();
        
        $statusHariIni = 'Tidak Hadir';
        if ($hasIn && $hasOut) {
            $statusHariIni = 'Hadir Penuh';
        } elseif ($hasIn || $hasOut) {
            $statusHariIni = 'Hadir Setengah';
        }

        return response()->json([
            'status' => 'success',
            'message' => "Pindaian Berhasil! {$anggota->nama} tercatat {$statusText} pada jam " . $now->format('H:i') . " WIB.",
            'data' => [
                'nama' => $anggota->nama,
                'tipe' => $tipe,
                'waktu' => $now->format('H:i'),
                'status_hari_ini' => $statusHariIni
            ]
        ]);
    }
}
