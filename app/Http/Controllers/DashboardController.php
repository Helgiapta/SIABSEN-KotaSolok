<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\LogAbsensi;
use App\Models\Anggota;
use App\Models\StatusManual;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function public_index()
    {
        return view('dashboard.public');
    }

    public function admin_index()
    {
        return view('admin.dashboard');
    }

    public function api_live_attendance()
    {
        $today = Carbon::today()->toDateString();
        
        $logs = LogAbsensi::with('anggota:id,nama')
            ->where('tanggal', $today)
            ->orderBy('waktu_scan', 'desc')
            ->get();

        $statusManuals = StatusManual::where('tanggal', $today)
            ->get()
            ->keyBy('anggota_id');
            
        $anggotaIds = $logs->pluck('anggota_id')->unique();
        $statusHarian = [];
        
        foreach ($anggotaIds as $pId) {
            $userLogs = $logs->where('anggota_id', $pId);
            $hasIn = $userLogs->where('tipe_absen', 'IN')->isNotEmpty();
            $hasOut = $userLogs->where('tipe_absen', 'OUT')->isNotEmpty();
            
            if ($hasIn && $hasOut) {
                $status = 'Hadir Penuh';
            } elseif ($hasIn || $hasOut) {
                $status = 'Hadir Setengah';
            } else {
                $status = 'Tidak Hadir';
            }

            if (isset($statusManuals[$pId])) {
                $status = $statusManuals[$pId]->status;
            }

            $statusHarian[$pId] = $status;
        }

        $formattedLogs = $logs->map(function ($log) use ($statusHarian) {
            return [
                'id'             => $log->id,
                'nama'           => $log->anggota->nama,
                'waktu'          => Carbon::parse($log->waktu_scan)->format('H:i'),
                'tipe_absen'     => $log->tipe_absen == 'IN' ? 'Datang' : 'Pulang',
                'status_hari_ini'=> $statusHarian[$log->anggota_id]
            ];
        });

        return response()->json([
            'status' => 'success',
            'data'   => $formattedLogs
        ]);
    }

    public function api_history_attendance(Request $request)
    {
        $date = $request->query('date', Carbon::today()->toDateString());
        
        $logs = LogAbsensi::with('anggota:id,nama')
            ->where('tanggal', $date)
            ->get();
            
        // Ambil semua anggota yang aktif
        $semuaAnggota = Anggota::with(['status_manuals' => function($q) use ($date) {
            $q->where('tanggal', $date);
        }])->where('status_aktif', true)->get();
        $totalAnggota = $semuaAnggota->count();
        
        $statistik = [
            'hadir_penuh' => 0,
            'hadir_setengah' => 0,
            'absen' => 0,
            'izin' => 0
        ];
        
        $formattedLogs = [];

        foreach ($semuaAnggota as $anggota) {
            // Cek apakah ada status absensi manual (di-override) oleh Admin
            $statusManual = $anggota->status_manuals->first();
            
            $userLogs = $logs->where('anggota_id', $anggota->id);
            $logIn = $userLogs->where('tipe_absen', 'IN')->first();
            $logOut = $userLogs->where('tipe_absen', 'OUT')->first();
            
            $waktuMasuk = $logIn ? Carbon::parse($logIn->waktu_scan)->format('H:i') : null;
            $waktuPulang = $logOut ? Carbon::parse($logOut->waktu_scan)->format('H:i') : null;
            
            $status = 'Absen';
            if ($waktuMasuk && $waktuPulang) {
                $status = 'Hadir Penuh';
            } elseif ($waktuMasuk || $waktuPulang) {
                $status = 'Hadir Setengah';
            }
            
            if ($statusManual) {
                // enum('Hadir Penuh', 'Hadir Setengah', 'Tidak Hadir', 'Izin')
                $status = $statusManual->status; 
            }

            if ($status == 'Hadir Penuh') {
                $statistik['hadir_penuh']++;
            } elseif ($status == 'Hadir Setengah') {
                $statistik['hadir_setengah']++;
            } elseif ($status == 'Izin') {
                $statistik['izin']++;
            } else {
                $status = 'Tidak Hadir';
                $statistik['absen']++;
            }

            $formattedLogs[] = [
                'anggota_id' => $anggota->id,
                'nama' => $anggota->nama,
                'waktu_masuk' => $waktuMasuk,
                'waktu_pulang' => $waktuPulang,
                'status_hari_ini' => $status
            ];
        }
            
        return response()->json([
            'status' => 'success',
            'date' => $date,
            'total_anggota' => $totalAnggota,
            'statistik' => $statistik,
            'data' => $formattedLogs
        ]);
    }

    public function api_delete_attendance_logs(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'tanggal' => 'required|date'
        ]);

        $anggotaId = $request->anggota_id;
        $tanggal = $request->tanggal;

        LogAbsensi::where('anggota_id', $anggotaId)
            ->where('tanggal', $tanggal)
            ->delete();

        StatusManual::where('anggota_id', $anggotaId)
            ->where('tanggal', $tanggal)
            ->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Seluruh data absensi hari ini berhasil dihapus. Anggota dapat melakukan scan ulang.'
        ]);
    }

    public function api_update_status(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:Hadir Penuh,Hadir Setengah,Tidak Hadir,Izin'
        ]);

        $statusManual = StatusManual::updateOrCreate(
            [
                'anggota_id' => $request->anggota_id,
                'tanggal' => $request->tanggal,
            ],
            [
                'status' => $request->status
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Status kehadiran berhasil diperbarui.',
            'data' => $statusManual
        ]);
    }
    // Fitur Kelola Anggota
    public function api_get_anggota()
    {
        $anggota = Anggota::orderBy('nama', 'asc')->get();
        return response()->json([
            'status' => 'success',
            'data' => $anggota
        ]);
    }

    public function api_store_anggota(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048' // max 2MB
        ]);

        $token = 'SQRS-' . time() . '-' . rand(1000, 9999);
        
        $fotoPath = null;
        if($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/images/anggota'), $filename);
            $fotoPath = 'assets/images/anggota/' . $filename;
        }

        $anggota = Anggota::create([
            'nama' => $request->nama,
            'qr_code_token' => $token,
            'foto' => $fotoPath,
            'status_aktif' => true
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Anggota berhasil ditambahkan.',
            'data' => $anggota
        ]);
    }

    public function api_update_foto_anggota(Request $request, $id)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $anggota = Anggota::find($id);
        if (!$anggota) {
            return response()->json(['status' => 'error', 'message' => 'Anggota tidak ditemukan.'], 404);
        }

        if($request->hasFile('foto')) {
            if($anggota->foto && file_exists(public_path($anggota->foto))) {
                unlink(public_path($anggota->foto));
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/images/anggota'), $filename);
            $anggota->foto = 'assets/images/anggota/' . $filename;
            $anggota->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Foto profil berhasil diperbarui.',
            'foto_url' => asset($anggota->foto)
        ]);
    }

    public function api_delete_foto_anggota($id)
    {
        $anggota = Anggota::find($id);
        if (!$anggota) {
            return response()->json(['status' => 'error', 'message' => 'Anggota tidak ditemukan.'], 404);
        }

        // Jika foto sudah kosong sejak awal, kembalikan response sukses
        if(!$anggota->foto) {
            return response()->json(['status' => 'success', 'message' => 'Anggota memang tidak memiliki foto.']);
        }

        if(file_exists(public_path($anggota->foto))) {
            unlink(public_path($anggota->foto));
        }

        $anggota->foto = null;
        $anggota->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Foto profil berhasil dihapus.'
        ]);
    }

    public function api_delete_anggota($id)
    {
        $anggota = Anggota::find($id);
        if (!$anggota) {
            return response()->json(['status' => 'error', 'message' => 'Anggota tidak ditemukan.'], 404);
        }

        $anggota->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Anggota berhasil dihapus.'
        ]);
    }
    // Fitur Pengaturan Sistem
    private function settingsFilePath()
    {
        return storage_path('app/siabsen_settings.json');
    }

    private function loadSettings()
    {
        $path = $this->settingsFilePath();
        $defaultSettings = [
            'jam_masuk' => '06:00',
            'jam_pulang' => '16:00'
        ];
        
        if (!file_exists($path)) {
            return $defaultSettings;
        }
        
        $settings = json_decode(file_get_contents($path), true);
        return array_merge($defaultSettings, $settings ?? []);
    }

    public function api_get_setting()
    {
        return response()->json([
            'status' => 'success',
            'data' => $this->loadSettings()
        ]);
    }

    public function api_save_setting(Request $request)
    {
        $request->validate([
            'jam_masuk' => 'required|date_format:H:i',
            'jam_pulang' => 'required|date_format:H:i'
        ]);

        $settings = $this->loadSettings();
        $settings['jam_masuk'] = $request->jam_masuk;
        $settings['jam_pulang'] = $request->jam_pulang;

        file_put_contents($this->settingsFilePath(), json_encode($settings, JSON_PRETTY_PRINT));

        return response()->json([
            'status' => 'success',
            'message' => 'Pengaturan jam kerja berhasil disimpan.',
            'data' => $settings
        ]);
    }
}
