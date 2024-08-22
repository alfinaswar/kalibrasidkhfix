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
        Schema::create('kaji_ulangs', function (Blueprint $table) {
            $table->id();
            $table->string('KodeKajiUlang', 255)->nullable();
            $table->string('SerahTerimaId', 255)->nullable();
            $table->string('InstrumenId')->nullable();
            $table->string('Metode1')->nullable();
            $table->string('Metode2')->nullable();
            $table->string('Status')->nullable();
            $table->string('Kondisi')->nullable();
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
        Schema::dropIfExists('kaji_ulangs');
    }
};
