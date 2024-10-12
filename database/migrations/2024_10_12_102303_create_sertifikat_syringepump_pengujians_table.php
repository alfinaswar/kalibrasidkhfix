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
        Schema::create('sertifikat_syringepump_pengujian', function (Blueprint $table) {
            $table->id();
            $table->string('SertifikatId')->nullable();
            $table->bigInteger('InstrumenId')->nullable();
            $table->enum('TipePengujian', ['FLOWRATE', 'HISAPMAKSIMUM'])->nullable();
            $table->json('Penunjukan')->nullable();
            $table->json('Pengulangan1')->nullable();
            $table->json('Pengulangan2')->nullable();
            $table->json('Pengulangan3')->nullable();
            $table->json('Pengulangan4')->nullable();
            $table->json('Pengulangan5')->nullable();
            $table->json('Pengulangan6')->nullable();
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
        Schema::dropIfExists('sertifikat_syringepump_pengujian');
    }
};
