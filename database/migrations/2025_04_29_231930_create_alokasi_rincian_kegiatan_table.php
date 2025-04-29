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
        Schema::create('alokasi_rincian_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rincian_kegiatan_id')->constrained('rincian_kegiatan')->onDelete('cascade');
            $table->foreignId('pelaksana_id')->constrained('users')->onDelete('cascade');
            $table->decimal('target', 10, 2)->default(0);
            $table->decimal('realisasi', 10, 2)->default(0);
            $table->timestamps();

            // Membuat indeks gabungan untuk memastikan satu pegawai hanya memiliki satu alokasi per rincian kegiatan
            $table->unique(['rincian_kegiatan_id', 'pelaksana_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alokasi_rincian_kegiatan');
    }
};