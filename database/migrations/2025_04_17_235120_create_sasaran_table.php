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
        Schema::create('sasaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tujuan_id')->constrained('tujuan')->onDelete('cascade');
            $table->string('sasaran_kode');
            $table->text('sasaran_urai');
            $table->timestamps();
            
            // Ensure unique sasaran_kode within each tujuan
            $table->unique(['tujuan_id', 'sasaran_kode']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sasaran');
    }
};