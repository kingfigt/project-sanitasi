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
        Schema::create('komunal', function (Blueprint $table) {
            $table->id('id_komunal');
            $table->foreignId('id')->constrained('users', 'id')->onDelete('cascade');
            $table->string('kelurahan');
            $table->integer('rw');
            $table->integer('jml_wc');
            $table->integer('jarak_air');
            $table->string('status_kelayakan'); // Menyesuaikan typo 'status = kelayakan'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komunals');
    }
};
