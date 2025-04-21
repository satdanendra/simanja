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
        Schema::create('master_rincian_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_kegiatan_id')->constrained('master_kegiatan')->onDelete('cascade');
            $table->string('rincian_kegiatan_kode');
            $table->text('rincian_kegiatan_urai');
            $table->text('catatan')->nullable();
            $table->string('rincian_kegiatan_satuan')->nullable();
            $table->timestamps();
            
            // Ensure unique master_rincian_kegiatan_kode within each master_kegiatan
            $table->unique(['master_kegiatan_id', 'rincian_kegiatan_kode']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_rincian_kegiatan');
    }
};