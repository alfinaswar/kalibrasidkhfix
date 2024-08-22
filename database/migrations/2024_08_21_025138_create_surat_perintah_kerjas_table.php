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
        Schema::create('surat_perintah_kerjas', function (Blueprint $table) {
            $table->id();
            $table->string('KodeSpk')->nullable();
            $table->string('PoId')->nullable();
            $table->string('CustomerId')->nullable();
            $table->string('Tanggal')->nullable();
            $table->string('KaryawanId')->nullable();
            $table->string('Deskripsi')->nullable();
            $table->string('Status')->nullable();
            $table->string('Disetujui')->nullable();
            $table->string('idUser')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_perintah_kerjas');
    }
};
