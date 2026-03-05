<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusManual extends Model
{
    protected $table = 'status_manual';
    protected $fillable = ['anggota_id', 'tanggal', 'status'];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }
}
