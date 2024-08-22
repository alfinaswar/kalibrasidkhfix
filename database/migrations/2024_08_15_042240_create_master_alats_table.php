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
        Schema::create('master_alats', function (Blueprint $table) {
            $table->id();
            $table->string('KodeAlat')->nullable();
            $table->string('NamaAlat')->nullable();
            $table->string('Merk')->nullable();
            $table->string('Type')->nullable();
            $table->string('SerialNumber')->nullable();
            $table->string('Foto')->nullable();
            $table->date('BuyDate')->nullable();
            $table->date('TanggalKalibrasi')->nullable();
            $table->date('DueDate')->nullable();
            $table->string('Tertelusur')->nullable();
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
        Schema::dropIfExists('master_alats');
    }
};
