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
        Schema::create('rincian_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegiatan_id')->constrained('kegiatan')->onDelete('cascade');
            $table->foreignId('master_rincian_kegiatan_id')->constrained('master_rincian_kegiatan');
            $table->decimal('volume', 10, 2)->nullable();
            $table->decimal('waktu', 10, 2)->nullable()->comment('Dalam jam');
            $table->date('deadline')->nullable();
            $table->boolean('is_variabel_kontrol')->default(false);
            $table->timestamps();
            
            // Unique constraint untuk mencegah duplikasi
            $table->unique(['kegiatan_id', 'master_rincian_kegiatan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rincian_kegiatan');
    }
};