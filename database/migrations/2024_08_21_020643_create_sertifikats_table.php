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
        Schema::create('sertifikats', function (Blueprint $table) {
            $table->id();
            $table->string('NoSertifikat')->nullable();
            $table->string('SertifikatOrder')->nullable();
            $table->string('InstrumenId')->nullable();
            $table->string('CustomerId')->nullable();
            $table->string('Lokasi')->nullable();
            $table->string('Merk')->nullable();
            $table->string('Type')->nullable();
            $table->string('SerialNumber')->nullable();
            $table->string('TanggalPelaksanaan')->nullable();
            $table->string('TanggalTerbit')->nullable();
            $table->string('Ruangan')->nullable();
            $table->string('Hasil')->nullable();
            $table->string('Resolusi')->nullable();
            $table->string('MetodeId')->nullable();
            $table->string('Status')->nullable();
            $table->string('DisetujuiOleh')->nullable();
            $table->datetime('DisetujuiPada')->nullable();
            $table->string('ValidMutuOleh')->nullable();
            $table->datetime('ValidMutuPada')->nullable();
            $table->string('ValidTeknisOleh')->nullable();
            $table->datetime('ValidTeknisPada')->nullable();
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
        Schema::dropIfExists('sertifikats');
    }
};
