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
        Schema::create('master_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyek_id')->constrained('master_proyek')->onDelete('cascade');
            $table->string('iki')->nullable();
            $table->string('kegiatan_kode');
            $table->text('kegiatan_urai');
            $table->timestamps();
            
            // Ensure unique kegiatan_kode within each proyek
            $table->unique(['proyek_id', 'kegiatan_kode']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_kegiatan');
    }
};