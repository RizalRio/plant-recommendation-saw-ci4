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
        Schema::create('rekomendasi', function (Blueprint $table) {
            $table->id(); // Primary Key [cite: 82, 178]

            // Foreign Key ke tabel data_lingkungans
            $table->foreignId('id_data')->constrained('data_lingkungan', 'id'); // [cite: 82, 177, 178]

            // Foreign Key ke tabel tanamans
            $table->foreignId('id_tanaman')->constrained('tanaman', 'id'); // [cite: 82, 177, 178]

            $table->float('skor'); // [cite: 177]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekomendasi');
    }
};
