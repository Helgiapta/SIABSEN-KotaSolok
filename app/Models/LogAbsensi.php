<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAbsensi extends Model
{
    protected $table = 'log_absensi';
    protected $fillable = ['anggota_id', 'waktu_scan', 'tipe_absen', 'tanggal'];
    protected $casts = [
        'waktu_scan' => 'datetime'
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
}
