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
        Schema::create('sertifikat_spyghmomanometer_pengujian', function (Blueprint $table) {
            $table->id();
            $table->string('SertifikatId')->nullable();
            $table->bigInteger('InstrumenId')->nullable();
            $table->enum('TypePengujian', ['kebocoran', 'lajubuang'])->nullable();
            $table->string('Penunjukan_standart')->nullable();
            $table->string('TekananAkhir')->nullable();
            $table->string('WaktuTerukur')->nullable();
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
        Schema::dropIfExists('sertifikat_spyghmomanometer_pengujian');
    }
};
