<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('komunal', function (Blueprint $table) {
            // 1. Buat kolom nama_sistem jika belum ada
            if (!Schema::hasColumn('komunal', 'nama_sistem')) {
                $table->string('nama_sistem', 255)->nullable()->default('MCK Umum Bersama');
            }

            // 2. Buat kolom bilik_mandi jika belum ada
            if (!Schema::hasColumn('komunal', 'bilik_mandi')) {
                $table->string('bilik_mandi', 100)->nullable()->default('1 Bilik');
            }

            // 3. Buat kolom kondisi_fisik jika belum ada
            if (!Schema::hasColumn('komunal', 'kondisi_fisik')) {
                $table->string('kondisi_fisik', 100)->nullable()->default('Aman (Tidak Bocor)');
            }

            // 4. Buat kolom kondisi_air jika belum ada
            if (!Schema::hasColumn('komunal', 'kondisi_air')) {
                $table->string('kondisi_air', 100)->nullable()->default('Lancar & Cukup');
            }
        });
    }

    public function down()
    {
        Schema::table('komunal', function (Blueprint $table) {
            $table->dropColumn(['nama_sistem', 'bilik_mandi', 'kondisi_fisik', 'kondisi_air']);
        });
    }
};