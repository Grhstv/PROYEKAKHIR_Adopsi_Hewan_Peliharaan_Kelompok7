<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hewans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategoris')->restrictOnDelete();
            $table->string('nama', 100);
            $table->string('ras', 100)->nullable();
            $table->string('jenis_kelamin', 10);              // jantan | betina
            $table->unsignedSmallInteger('umur_bulan');
            $table->string('warna', 50)->nullable();
            $table->text('deskripsi');
            $table->string('kesehatan', 500)->nullable();
            $table->boolean('sudah_vaksin')->default(false);
            $table->boolean('sudah_steril')->default(false);
            $table->string('foto')->nullable();               // path file upload (disk public)
            $table->string('foto_url', 500)->nullable();      // alternatif: URL gambar
            $table->string('status', 20)->default('tersedia')->index(); // tersedia | teradopsi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hewans');
    }
};
