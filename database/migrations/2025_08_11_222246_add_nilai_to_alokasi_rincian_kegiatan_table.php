<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alokasi_rincian_kegiatan', function (Blueprint $table) {
            $table->decimal('nilai', 5, 2)->nullable()->after('realisasi'); // Nilai 0-100 dengan 2 desimal
        });
    }

    public function down(): void
    {
        Schema::table('alokasi_rincian_kegiatan', function (Blueprint $table) {
            $table->dropColumn('nilai');
        });
    }
};