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
            $table->foreignId('direktorat_id')->constrained('master_direktorats')->onDelete('cascade');
            $table->foreignId('master_tim_id')->constrained('master_tim')->onDelete('cascade');
            $table->foreignId('tim_ketua')->constrained('users')->onDelete('cascade');
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