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
        Schema::create('sertifikat_suctionpump_pengujian', function (Blueprint $table) {
            $table->id();
            $table->string('SertifikatId')->nullable();
            $table->bigInteger('InstrumenId')->nullable();
            $table->json('Penunjukan')->nullable();
            $table->json('StandartNaik1')->nullable();
            $table->json('StandartTurun1')->nullable();
            $table->json('StandartNaik2')->nullable();
            $table->json('StandartTurun2')->nullable();
            $table->json('StandartNaik3')->nullable();
            $table->json('StandartTurun3')->nullable();
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
        Schema::dropIfExists('sertifikat_suctionpump_pengujian');
    }
};
