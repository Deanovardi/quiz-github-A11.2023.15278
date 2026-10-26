<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('poli', function (Blueprint $table) {
            $table->string('kode_poli', 5)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('poli', function (Blueprint $table) {
            $table->dropColumn('kode_poli');
        });
    }
};