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
        Schema::create('data_lingkungan', function (Blueprint $table) {
            $table->id(); // Primary Key [cite: 82, 178]
            // Foreign Key ke tabel users
            $table->foreignId('id_user')->constrained('users', 'id'); // [cite: 82, 175, 178]
            $table->string('jenis_tanah'); // [cite: 175]
            $table->float('suhu'); // Di dokumen Anda namanya suhu [cite: 53]
            $table->float('curah_hujan'); // [cite: 53, 175]
            $table->string('ketersediaan_air'); // Dibuat string agar fleksibel, sesuai data sample "Banyak/Sedang" [cite: 53]
            $table->float('kelembaban'); // [cite: 53]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_lingkungan');
    }
};
