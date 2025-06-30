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
        Schema::create('kriteria_tanaman', function (Blueprint $table) {
            $table->id(); // Primary Key [cite: 82, 178]
            // Foreign Key ke tabel tanamans, sesuai relasi ERD
            $table->foreignId('id_tanaman')->constrained('tanaman', 'id'); // [cite: 82, 173, 178]
            // Foreign Key ke tabel kriterias, sesuai relasi ERD
            $table->foreignId('id_kriteria')->constrained('kriteria', 'id'); // [cite: 82, 173, 178]

            // Nilai preferensi tanaman, dibuat string agar fleksibel (bisa "Lempung", "24-32", dll)
            $table->string('nilai'); // [cite: 51]

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriteria_tanaman');
    }
};
