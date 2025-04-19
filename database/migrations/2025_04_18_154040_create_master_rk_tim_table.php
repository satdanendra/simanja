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
        Schema::create('master_rk_tim', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tim_id')->constrained('master_tim')->onDelete('cascade');
            $table->string('rk_tim_kode');
            $table->text('rk_tim_urai');
            $table->string('iku_kode')->nullable();
            $table->text('iku_urai')->nullable();
            $table->timestamps();
            
            // Ensure unique rk_tim_kode within each tim
            $table->unique(['tim_id', 'rk_tim_kode']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_rk_tim');
    }
};