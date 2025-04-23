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
        Schema::create('proyek', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rk_tim_id')->constrained('rk_tim')->onDelete('cascade');
            $table->foreignId('master_proyek_id')->constrained('master_proyek')->onDelete('cascade');
            $table->foreignId('pic')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            
            // Add unique constraint to prevent duplicate entries
            $table->unique(['rk_tim_id', 'master_proyek_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyek');
    }
};