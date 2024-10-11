<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sertifikat_timbangan_pengujians', function (Blueprint $table) {
            $table->id();
            $table->string('SertifikatId')->nullable();
            $table->bigInteger('InstrumenId')->nullable();
            $table->enum('TipePengujian', ['KINERJA', 'SKALA'])->nullable();
            $table->json('MassaHalf')->nullable();
            $table->json('MassaMax')->nullable();
            $table->json('PengujianZ')->nullable();
            $table->json('PengujianM')->nullable();
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
        Schema::dropIfExists('sertifikat_timbangan_pengujians');
    }
};
