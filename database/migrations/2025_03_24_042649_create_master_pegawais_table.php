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
        Schema::create('master_pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('sex', ['L', 'P'])->comment('L=Laki-laki, P=Perempuan');
            $table->string('gelar')->nullable();
            $table->string('alias')->nullable();
            $table->string('nip_lama')->unique()->nullable();
            $table->string('nip_baru')->unique()->nullable();
            $table->string('nik')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('nomor_hp')->nullable();
            $table->string('pangkat')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('educ')->nullable()->comment('Tingkat pendidikan disingkat (S1, S2, dll)');
            $table->string('pendidikan')->nullable();
            $table->string('universitas')->nullable();
            $table->boolean('is_active')->default(true);
            $table->softDeletes(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_pegawais');
    }
};
