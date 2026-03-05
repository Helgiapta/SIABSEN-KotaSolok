<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\LogAbsensi;
use App\Models\Anggota;
use App\Models\StatusManual;
use Carbon\Carbon;

class PengawasController extends Controller
{
    public function index()
    {
        return view('pengawas.dashboard');
    }

    public function scanner()
    {
        return view('pengawas.scanner');
    }

    public function api_history_attendance(Request $request)
    {
        $date = $request->query('date', Carbon::today()->toDateString());

        $logs = LogAbsensi::with('anggota:id,nama')
            ->where('tanggal', $date)
            ->get();

        $semuaAnggota = Anggota::with(['status_manuals' => function($q) use ($date) {
            $q->where('tanggal', $date);
        }])->where('status_aktif', true)->get();
        $totalAnggota = $semuaAnggota->count();

        $statistik = [
            'hadir_penuh'    => 0,
            'hadir_setengah' => 0,
            'absen'          => 0,
            'izin'           => 0
        ];

        $formattedLogs = [];

        foreach ($semuaAnggota as $anggota) {
            $statusManual = $anggota->status_manuals->first();

            $userLogs  = $logs->where('anggota_id', $anggota->id);
            $logIn     = $userLogs->where('tipe_absen', 'IN')->first();
            $logOut    = $userLogs->where('tipe_absen', 'OUT')->first();

            $waktuMasuk   = $logIn  ? Carbon::parse($logIn->waktu_scan)->format('H:i')  : null;
            $waktuPulang  = $logOut ? Carbon::parse($logOut->waktu_scan)->format('H:i') : null;

            $status = 'Absen';
            if ($waktuMasuk && $waktuPulang) {
                $status = 'Hadir Penuh';
            } elseif ($waktuMasuk || $waktuPulang) {
                $status = 'Hadir Setengah';
            }

            if ($statusManual) {
                $status = $statusManual->status;
            }

            if ($status == 'Hadir Penuh') {
                $statistik['hadir_penuh']++;
            } elseif ($status == 'Hadir Setengah') {
                $statistik['hadir_setengah']++;
            } elseif ($status == 'Izin' || $status == 'Sakit') {
                $statistik['izin']++;
            } else {
                $status = 'Tidak Hadir';
                $statistik['absen']++;
            }

            $formattedLogs[] = [
                'anggota_id'     => $anggota->id,
                'nama'           => $anggota->nama,
                'waktu_masuk'    => $waktuMasuk,
                'waktu_pulang'   => $waktuPulang,
                'status_hari_ini'=> $status
            ];
        }

        return response()->json([
            'status'        => 'success',
            'date'          => $date,
            'total_anggota' => $totalAnggota,
            'statistik'     => $statistik,
            'data'          => $formattedLogs
        ]);
    }

    public function api_update_status(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'tanggal'    => 'required|date',
            'status'     => 'required|in:Hadir Penuh,Hadir Setengah,Tidak Hadir,Izin,Sakit'
        ]);

        $statusManual = StatusManual::updateOrCreate(
            [
                'anggota_id' => $request->anggota_id,
                'tanggal'    => $request->tanggal,
            ],
            [
                'status' => $request->status
            ]
        );

        return response()->json([
            'status'  => 'success',
            'message' => 'Status kehadiran berhasil diperbarui.',
            'data'    => $statusManual
        ]);
    }

    public function api_delete_attendance_logs(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'tanggal'    => 'required|date'
        ]);

        $anggotaId = $request->anggota_id;
        $tanggal   = $request->tanggal;

        LogAbsensi::where('anggota_id', $anggotaId)
            ->where('tanggal', $tanggal)
            ->delete();

        StatusManual::where('anggota_id', $anggotaId)
            ->where('tanggal', $tanggal)
            ->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Seluruh data absensi hari ini berhasil dihapus. Anggota dapat melakukan scan ulang.'
        ]);
    }

    public function api_scan_qr(Request $request)
    {
        $request->validate([
            'qr_code_token' => 'required|string'
        ]);

        $token   = $request->qr_code_token;
        $anggota = Anggota::where('qr_code_token', $token)->first();

        if (!$anggota) {
            return response()->json(['status' => 'error', 'message' => 'QR Code tidak terdaftar.'], 404);
        }

        if (!$anggota->status_aktif) {
            return response()->json(['status' => 'error', 'message' => 'Anggota tidak aktif.'], 403);
        }

        $today = Carbon::today()->toDateString();
        $now   = Carbon::now();

        $settingsPath = storage_path('app/siabsen_settings.json');
        $settings = Cache::remember('siabsen_settings', 3600, function () use ($settingsPath) {
            return file_exists($settingsPath) ? json_decode(file_get_contents($settingsPath), true) : [];
        });
        $jamMasuk  = $settings['jam_masuk']  ?? '06:00';
        $jamPulang = $settings['jam_pulang'] ?? '16:00';

        $waktuMasuk  = Carbon::createFromFormat('H:i', $jamMasuk);
        $waktuPulang = Carbon::createFromFormat('H:i', $jamPulang);

        $logsToday = LogAbsensi::where('anggota_id', $anggota->id)
            ->where('tanggal', $today)
            ->orderBy('waktu_scan', 'asc')
            ->get();

        $count = $logsToday->count();

        if ($count >= 2) {
            return response()->json([
                'status'  => 'warning',
                'message' => "Absensi Lengkap! {$anggota->nama} sudah melakukan pindaian MASUK dan PULANG hari ini."
            ], 429);
        }

        if ($count == 0) {
            if ($now->lt($waktuMasuk)) {
                return response()->json([
                    'status'  => 'warning',
                    'message' => "Belum Waktunya! Scan MASUK baru bisa dilakukan mulai pukul {$jamMasuk} WIB."
                ], 403);
            }
            $tipe = 'IN';
        } else {
            if ($now->lt($waktuPulang)) {
                $diff    = $now->diff($waktuPulang);
                $diffStr = '';
                if ($diff->h > 0) $diffStr .= "{$diff->h} Jam ";
                if ($diff->i > 0) $diffStr .= "{$diff->i} Menit ";
                if ($diff->s > 0) $diffStr .= "{$diff->s} Detik";

                return response()->json([
                    'status'  => 'warning',
                    'message' => "Tunggu Sebentar! {$anggota->nama} sudah scan MASUK. Scan PULANG bisa dilakukan mulai pukul {$jamPulang} WIB (Sisa: " . trim($diffStr) . " lagi)."
                ], 403);
            }
            $tipe = 'OUT';
        }

        LogAbsensi::create([
            'anggota_id' => $anggota->id,
            'waktu_scan' => $now,
            'tipe_absen' => $tipe,
            'tanggal'    => $today
        ]);

        $statusText = $tipe == 'IN' ? 'MASUK' : 'PULANG';

        $allLogsToday = LogAbsensi::where('anggota_id', $anggota->id)
            ->where('tanggal', $today)
            ->get();
        $hasIn  = $allLogsToday->where('tipe_absen', 'IN')->isNotEmpty();
        $hasOut = $allLogsToday->where('tipe_absen', 'OUT')->isNotEmpty();

        $statusHariIni = 'Tidak Hadir';
        if ($hasIn && $hasOut) {
            $statusHariIni = 'Hadir Penuh';
        } elseif ($hasIn || $hasOut) {
            $statusHariIni = 'Hadir Setengah';
        }

        return response()->json([
            'status'  => 'success',
            'message' => "Pindaian Berhasil! {$anggota->nama} tercatat {$statusText} pada jam " . $now->format('H:i') . " WIB.",
            'data'    => [
                'nama'           => $anggota->nama,
                'tipe'           => $tipe,
                'waktu'          => $now->format('H:i'),
                'status_hari_ini'=> $statusHariIni
            ]
        ]);
    }
}
