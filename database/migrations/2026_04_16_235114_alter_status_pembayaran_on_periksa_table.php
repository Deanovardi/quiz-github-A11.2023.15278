<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        DB::statement("
            ALTER TABLE periksa
            MODIFY status_pembayaran ENUM('belum_bayar', 'menunggu_verifikasi', 'ditolak', 'lunas')
            NOT NULL DEFAULT 'belum_bayar'
        ");
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        DB::statement("
            ALTER TABLE periksa
            MODIFY status_pembayaran ENUM('belum_bayar', 'menunggu_verifikasi', 'lunas')
            NOT NULL DEFAULT 'belum_bayar'
        ");
    }
};