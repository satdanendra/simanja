<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rk_tim', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tim_id')->constrained('tims')->onDelete('cascade');
            $table->foreignId('rk_tim_id')->constrained('master_rk_tim')->onDelete('cascade');
            $table->timestamps();
            
            // Memastikan tidak ada duplikasi kombinasi tim_id dan rk_tim_id
            $table->unique(['tim_id', 'rk_tim_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rk_tim');
    }
};