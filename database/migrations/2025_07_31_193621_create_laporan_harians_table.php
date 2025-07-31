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
        Schema::create('laporan_harians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('proyek_id')->constrained('proyek')->onDelete('cascade');
            $table->foreignId('rincian_kegiatan_id')->constrained('rincian_kegiatan')->onDelete('cascade');
            $table->enum('tipe_waktu', ['single_date', 'rentang_tanggal']);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->text('kegiatan_deskripsi');
            $table->text('capaian');
            $table->json('dasar_pelaksanaan'); // Array of {nomor, deskripsi, is_terlampir}
            $table->text('kendala')->nullable();
            $table->text('solusi')->nullable();
            $table->text('catatan')->nullable();
            $table->json('bukti_dukung_ids')->nullable(); // Array of {id, urutan}
            $table->string('file_path')->default('google_drive')->nullable();
            $table->string('drive_id')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index(['user_id', 'created_at']);
            $table->index(['rincian_kegiatan_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_harians');
    }
};