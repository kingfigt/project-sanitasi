<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rumah_tanggas', function (Blueprint $table) {
            // Menambahkan kolom foto_dokumen setelah kolom longitude
            $table->string('foto_dokumen', 255)->nullable()->after('longitude');
        });
    }

    public function down(): void
    {
        Schema::table('rumah_tanggas', function (Blueprint $table) {
            $table->dropColumn('foto_dokumen');
        });
    }
};
