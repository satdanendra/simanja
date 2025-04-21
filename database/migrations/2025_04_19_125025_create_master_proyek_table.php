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
        Schema::create('master_proyek', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_rk_tim_id')->constrained('master_rk_tim')->onDelete('cascade');
            $table->string('iku_kode')->nullable();
            $table->text('iku_urai')->nullable();
            $table->string('proyek_kode');
            $table->text('proyek_urai');
            $table->string('rk_anggota')->nullable();
            $table->string('proyek_lapangan')->nullable();
            $table->timestamps();
            
            // Ensure unique master_proyek_kode within each master_rk_tim
            $table->unique(['master_rk_tim_id', 'proyek_kode']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_proyek');
    }
};