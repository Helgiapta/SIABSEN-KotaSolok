<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('log_absensi', function (Blueprint $table) {
            $table->index(['tanggal', 'anggota_id'], 'idx_log_tanggal_anggota');
        });

        Schema::table('status_manual', function (Blueprint $table) {
            $table->index(['tanggal', 'anggota_id'], 'idx_status_tanggal_anggota');
        });
    }

    public function down(): void
    {
        Schema::table('log_absensi', function (Blueprint $table) {
            $table->dropIndex('idx_log_tanggal_anggota');
        });

        Schema::table('status_manual', function (Blueprint $table) {
            $table->dropIndex('idx_status_tanggal_anggota');
        });
    }
};
