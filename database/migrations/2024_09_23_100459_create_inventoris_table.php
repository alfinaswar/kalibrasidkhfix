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
        Schema::create('inventoris', function (Blueprint $table) {
            $table->id();
            $table->enum('Kategori', ['ALATUKUR', 'ARTEFAK', 'LAINNYA'])->nullable();
            $table->string('Kode')->unique();
            $table->string('Nama')->nullable();
            $table->string('merk')->nullable();
            $table->string('Tipe')->nullable();
            $table->string('Sn')->nullable();
            $table->string('Foto')->nullable();
            $table->date('BuyDate')->nullable();
            $table->date('KalibrasiDate')->nullable();
            $table->date('kalibrasiDueDate')->nullable();
            $table->boolean('Tertelusur')->nullable();
            $table->enum('Status', ['AKTIF', 'TIDAK'])->nullable();
            $table->unsignedBigInteger('UserId')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventoris');
    }
};
