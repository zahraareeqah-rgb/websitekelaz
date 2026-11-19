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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); // Relasi ke tabel users (login)
            $table->string('nama_siswa');
            $table->string('nisn')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->integer('absen')->nullable(); // Nomor absen (diatur otomatis)
            $table->text('alamat')->nullable();   // Menggantikan kolom kelas menjadi alamat
            $table->string('jenis_kelamin')->nullable(); // Kolom baru jenis kelamin
            $table->string('foto')->nullable(); // Untuk menyimpan path file foto
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
