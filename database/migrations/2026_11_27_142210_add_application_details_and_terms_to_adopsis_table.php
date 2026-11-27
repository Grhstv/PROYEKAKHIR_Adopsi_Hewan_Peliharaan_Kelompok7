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
        Schema::table('adopsis', function (Blueprint $table) {
            $table->text('alamat_lengkap')->nullable();
            $table->boolean('persetujuan_keluarga')->nullable();
            $table->string('jadwal_perawatan', 100)->nullable();
            $table->unsignedInteger('anggaran_bulanan')->nullable();
            $table->text('rencana_perawatan')->nullable();
            $table->longText('terms_snapshot')->nullable();
            $table->timestamp('terms_accepted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adopsis', function (Blueprint $table) {
            $table->dropColumn([
                'alamat_lengkap',
                'persetujuan_keluarga',
                'jadwal_perawatan',
                'anggaran_bulanan',
                'rencana_perawatan',
                'terms_snapshot',
                'terms_accepted_at',
            ]);
        });
    }
};
