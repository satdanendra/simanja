<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bukti_dukungs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rincian_kegiatan_id')->constrained('rincian_kegiatan')->onDelete('cascade');
            $table->string('nama_file');
            $table->string('file_path')->default('google_drive');
            $table->string('drive_id')->unique();
            $table->string('file_type')->nullable();
            $table->string('extension', 10)->nullable();
            $table->string('mime_type')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index(['rincian_kegiatan_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukti_dukungs');
    }
};