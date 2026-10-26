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
        Schema::create('rumah_tanggas', function (Blueprint $table) {
            $table->id('id_rt');
            // Menghubungkan Foreign Key ke id_user di tabel users
            $table->foreignId('id')->constrained('users', 'id')->onDelete('cascade');
            $table->string('kelurahan');
            $table->text('alamat');
            $table->string('no_kk'); // Disarankan string jika nomor KK besar/panjang
            $table->string('kepala_keluarga');
            $table->integer('jml_penghuni');
            $table->enum('kepemilikan_jamban', ['sendiri', 'bersama', 'menumpang']); 
            $table->string('jenis_jamban');
            $table->string('status_kelayakan');
            $table->string('pembuangan'); // Koreksi dari 'vaechar'
            $table->integer('jarak_air');
            $table->decimal('longitude', 10, 8)->nullable();
            $table->decimal('latitude', 11, 8)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rumah_tanggas');
    }
};
