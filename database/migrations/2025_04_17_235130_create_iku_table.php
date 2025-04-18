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
        Schema::create('iku', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sasaran_id')->constrained('sasaran')->onDelete('cascade');
            $table->string('iku_kode');
            $table->text('iku_urai');
            $table->string('iku_satuan');
            $table->string('iku_target');
            $table->timestamps();
            
            // Ensure unique iku_kode within each sasaran
            $table->unique(['sasaran_id', 'iku_kode']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iku');
    }
};