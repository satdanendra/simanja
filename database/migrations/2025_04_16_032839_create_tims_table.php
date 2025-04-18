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
        Schema::create('tims', function (Blueprint $table) {
            $table->id(); // Kolom ID
            $table->string('direktorat'); // Kolom Direktorat
            $table->string('tim_kode')->unique(); // Kolom Kode Tim
            $table->string('tim_nama'); // Kolom Nama Tim
            $table->string('tim_ketua'); // Kolom Ketua Tim
            $table->year('tahun'); // Kolom Tahun
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tims');
    }
};