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
        Schema::create('detail_belanja', function (Blueprint $table) {
            $table->id('id_detail');
            $table->foreignId('id_anggaran')->constrained('anggaran', 'id_anggaran')->onDelete('cascade');
            $table->string('nama_item');
            $table->integer('volume_item');
            $table->decimal('harga_satuan', 15, 2);
            $table->decimal('total_harga', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_belanjas');
    }
};
