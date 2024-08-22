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
        Schema::create('alat_ukurs', function (Blueprint $table) {
            $table->id();
            $table->string('KodeAlat')->nullable();
            $table->string('NamaAlat')->nullable();
            $table->string('Merk')->nullable();
            $table->string('Model')->nullable();
            $table->string('NoSeri')->nullable();
            $table->string('NoSertifikat')->nullable();
            $table->boolean('Tertelusur')->nullable();
            $table->integer('Tahun')->nullable();
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
        Schema::dropIfExists('alat_ukurs');
    }
};
