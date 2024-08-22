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
        Schema::create('serah_terima_details', function (Blueprint $table) {
            $table->id();
            $table->string('SerahTerimaId')->nullable();
            $table->string('KaryawanId')->nullable();
            $table->string('InstrumenId')->nullable();
            $table->string('Merk')->nullable();
            $table->string('Type')->nullable();
            $table->string('SerialNumber')->nullable();
            $table->bigInteger('Qty')->nullable();
            $table->string('Deskripsi')->nullable();
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
        Schema::dropIfExists('serah_terima_details');
    }
};
