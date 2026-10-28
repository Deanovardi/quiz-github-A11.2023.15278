<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('poli', function (Blueprint $table) {
            $table->unique('nama_poli', 'poli_nama_poli_unique');
        });
    }

    public function down(): void
    {
        Schema::table('poli', function (Blueprint $table) {
            $table->dropUnique('poli_nama_poli_unique');
        });
    }
};