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
        Schema::create('sertifikat_telaah_teknis', function (Blueprint $table) {
            $table->id();
            $table->string('SertifikatId')->nullable();
            $table->bigInteger('InstrumenId')->nullable();
            $table->enum('FisikFungsi', ['BAIK', 'TIDAKBAIK'])->nullable();
            $table->enum('KeselamatanListrik', ['AMAN', 'TIDAKAMAN'])->nullable();
            $table->enum('Kinerja', ['PERLUPERBAIKAN', 'DALAMBATASTOLENRANSI'])->nullable();
            $table->text('Catatan')->nullable();
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
        Schema::dropIfExists('sertifikat_telaah_teknis');
    }
};
