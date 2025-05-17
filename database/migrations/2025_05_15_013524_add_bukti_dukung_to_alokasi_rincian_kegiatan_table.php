<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('alokasi_rincian_kegiatan', function (Blueprint $table) {
            $table->string('bukti_dukung_file_id')->nullable();
            $table->string('bukti_dukung_file_name')->nullable();
            $table->string('bukti_dukung_link')->nullable();
            $table->timestamp('bukti_dukung_uploaded_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('alokasi_rincian_kegiatan', function (Blueprint $table) {
            $table->dropColumn([
                'bukti_dukung_file_id',
                'bukti_dukung_file_name',
                'bukti_dukung_link',
                'bukti_dukung_uploaded_at'
            ]);
        });
    }
};