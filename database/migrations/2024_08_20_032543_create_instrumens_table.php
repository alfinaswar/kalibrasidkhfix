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
        Schema::create('instrumens', function (Blueprint $table) {
            $table->id();
            $table->string('KodeInstrumen')->nullable();
            $table->string('Kategori')->nullable();
            $table->string('Nama')->nullable();
            $table->string('Tarif')->nullable();
            $table->string('Akreditasi')->nullable();
            $table->json('AlatUkur')->nullable();
            $table->string('LK')->nullable();
            $table->string('Status')->nullable();
            $table->integer('idUser')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instrumens');
    }
};
