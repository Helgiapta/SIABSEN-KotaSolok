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

        // Load Settings
        $settingsPath = storage_path('app/siabsen_settings.json');
        $settings = file_exists($settingsPath) ? json_decode(file_get_contents($settingsPath), true) : [];
        $jamMasuk = $settings['jam_masuk'] ?? '06:00';
        $jamPulang = $settings['jam_pulang'] ?? '16:00';

        $waktuMasuk = Carbon::createFromFormat('H:i', $jamMasuk);
        $waktuPulang = Carbon::createFromFormat('H:i', $jamPulang);

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

        if ($count == 0) {
            // Validasi Jam Masuk
            if ($now->lt($waktuMasuk)) {
                return response()->json([
                    'status' => 'warning',
                    'message' => "Belum Waktunya! Scan MASUK baru bisa dilakukan mulai pukul {$jamMasuk} WIB."
                ], 403);
            }
            $tipe = 'IN';
        } else {
            // Validasi Jam Pulang
            if ($now->lt($waktuPulang)) {
                $diff = $now->diff($waktuPulang);
                $diffStr = "";
                if ($diff->h > 0) $diffStr .= "{$diff->h} Jam ";
                if ($diff->i > 0) $diffStr .= "{$diff->i} Menit ";
                if ($diff->s > 0) $diffStr .= "{$diff->s} Detik";
                
                return response()->json([
                    'status' => 'warning',
                    'message' => "Tunggu Sebentar! {$anggota->nama} sudah scan MASUK. Untuk melakukan scan PULANG Anda harus menunggu hingga pukul {$jamPulang} WIB (Sisa Waktu: ".trim($diffStr)." lagi)."
                ], 403);
            }
            $tipe = 'OUT';
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
