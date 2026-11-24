<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adopsis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('hewan_id')->constrained('hewans')->restrictOnDelete();
            $table->text('alasan');
            $table->string('tempat_tinggal', 30);
            $table->string('pengalaman', 30);
            $table->string('no_telepon', 20);
            $table->string('status', 20)->default('menunggu')->index(); // menunggu | disetujui | ditolak | dibatalkan
            $table->string('catatan_admin', 500)->nullable();
            $table->timestamp('diproses_at')->nullable();
            $table->timestamps();

            $table->index(['hewan_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adopsis');
    }
};
