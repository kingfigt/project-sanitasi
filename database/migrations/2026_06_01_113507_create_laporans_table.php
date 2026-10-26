<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->foreignId('id')->constrained('users', 'id')->onDelete('cascade');
            // Digunakan nullable() jika laporan tidak selalu terkait dengan komunal (opsional)
            $table->foreignId('id_komunal')->nullable()->constrained('komunal', 'id_komunal')->onDelete('set null');
            $table->text('alamat_mck');
            $table->text('deskrip_masalah');
            $table->string('status_kelayakan');
            $table->enum('kondisi_buangan', ['aman', 'tercemar']); 
            $table->enum('status_perbaikan', ['belum', 'proses', 'selesai']); 
            $table->string('foto_bukti');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
