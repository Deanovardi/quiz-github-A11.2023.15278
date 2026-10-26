<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('poli', function (Blueprint $table) {
            $table->integer('tarif')
                  ->default(0)
                  ->after('nama_poli');
        });
    }

    public function down(): void
    {
        Schema::table('poli', function (Blueprint $table) {
            $table->dropColumn('tarif');
        });
    }
};