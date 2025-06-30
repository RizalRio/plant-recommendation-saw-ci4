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
        Schema::create('kriteria', function (Blueprint $table) {
            $table->id(); // Primary Key [cite: 82, 178]
            $table->string('nama_kriteria'); // Nama kriteria dari dokumen [cite: 49]
            $table->float('bobot'); // [cite: 49, 82, 169, 178]
            $table->enum('tipe', ['benefit', 'cost']); // [cite: 49, 82, 169, 178]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriteria');
    }
};
