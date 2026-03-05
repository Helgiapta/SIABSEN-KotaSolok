<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // MySQL: ubah enum untuk menambahkan 'Sakit'
        DB::statement("ALTER TABLE `status_manual` MODIFY `status` ENUM('Hadir Penuh', 'Hadir Setengah', 'Tidak Hadir', 'Izin', 'Sakit') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `status_manual` MODIFY `status` ENUM('Hadir Penuh', 'Hadir Setengah', 'Tidak Hadir', 'Izin') NOT NULL");
    }
};
