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
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();

            // Relasi ke Mapel secara eksplisit
            $table->unsignedBigInteger('mapel_id');
            $table->foreign('mapel_id')->references('id')->on('mapels')->onDelete('cascade');

            // Relasi ke Guru secara eksplisit (aman & tidak error 150)
            $table->unsignedBigInteger('guru_id')->nullable();
            $table->foreign('guru_id')->references('id')->on('gurus')->onDelete('cascade');

            $table->integer('minggu_ke')->default(1);
            $table->string('hari'); // Senin, Selasa, dll
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};
