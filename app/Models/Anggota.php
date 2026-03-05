<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'anggota';
    protected $fillable = ['nama', 'foto', 'status_aktif', 'qr_code_token'];

    public function status_manuals()
    {
        return $this->hasMany(StatusManual::class, 'anggota_id');
    }
}
